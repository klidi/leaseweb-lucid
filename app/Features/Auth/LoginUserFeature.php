<?php

namespace Framework\Features\Auth;

use Framework\Data\User;
use Framework\Domains\Auth\Jobs\IncreaseLoginAttemptsJob;
use Framework\Domains\Auth\Jobs\ValidateLoginInputJob;
use Framework\Domains\Auth\Jobs\CheckLoginAttemptsJob;
use Framework\Domains\Auth\Jobs\AuthenticateUserJob;
use Framework\Domains\Auth\Jobs\CreateUserTokenJob;
use Framework\Http\Jobs\RespondWithJsonErrorJob;
use Framework\Http\Jobs\RespondWithJsonJob;
use Illuminate\Support\Facades\Auth;
use Framework\Http\Resources\User as UserResource;
use Illuminate\Http\JsonResponse;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class LoginUserFeature extends Feature
{
    public function handle(Request $request) :JsonResponse
    {
        $this->run(ValidateLoginInputJob::class, [
            'input' => $request->input(),
        ]);

        $this->run(CheckLoginAttemptsJob::class, [
            'request' => $request,
        ]);

        $isAuthenticated = $this->run(AuthenticateUserJob::class, [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if (!$isAuthenticated) {
            $this->run(IncreaseLoginAttemptsJob::class, [
                'request' => $request,
            ]);
            return $this->run(new RespondWithJsonErrorJob('Incorrect Credentials'), 401);
        }

        $accessToken = $this->run(CreateUserTokenJob::class, [
            'user' =>  Auth::user(),
        ]);

        // this is is included cuz i had no time to create extra endpoints for users
        return $this->run(new RespondWithJsonJob([
            'access_token' => $accessToken,
            'user' => new UserResource(Auth::user()),
        ], 200));
    }
}
