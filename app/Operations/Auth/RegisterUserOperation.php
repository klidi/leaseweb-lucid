<?php
namespace Framework\Operations\Auth;

use Framework\Domains\Auth\Jobs\CreateUserTokenJob;
use Framework\Http\Jobs\RespondWithJsonErrorJob;
use Framework\Domains\Auth\Jobs\SaveUserJob;
use Lucid\Foundation\Operation;
use Illuminate\Http\Request;

class RegisterUserOperation extends Operation
{
    private array $input;

    public function __construct(array $input)
    {
        $this->input = $input;
    }

    public function handle(Request $request) : string
    {
        $user = $this->run(SaveUserJob::class, [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if (!$user->exists) {
            return $this->run(new RespondWithJsonErrorJob('Failed to create user'));
        }

        return $this->run(CreateUserTokenJob::class, ['user' => $user]);
    }
}
