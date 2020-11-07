<?php

namespace Framework\Features\Auth;

use Framework\Domains\Auth\Jobs\ValidateRegistrationInputJob;
use Framework\Operations\Auth\RegisterUserOperation;
use Framework\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class RegisterUserFeature extends Feature
{
    public function handle(Request $request) : string
    {
        $this->run(ValidateRegistrationInputJob::class, [
            'input' => $request->input(),
        ]);

        $accessToken = $this->run(RegisterUserOperation::class, [
            'input' =>  $request->input(),
        ]);

        return $this->run(new RespondWithJsonJob($accessToken, 201));
    }
}
