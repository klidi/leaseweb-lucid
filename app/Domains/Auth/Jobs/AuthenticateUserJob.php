<?php

namespace Framework\Domains\Auth\Jobs;

use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Job;

class AuthenticateUserJob extends Job
{
    private string $email;
    private string $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }


    public function handle()
    {
        return Auth::attempt(['email' => $this->email, 'password' => request('password')]) ?: false;
    }

}
