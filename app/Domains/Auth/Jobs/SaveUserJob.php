<?php

namespace Framework\Domains\Auth\Jobs;

use Illuminate\Support\Facades\Hash;
use Lucid\Foundation\Job;
use Framework\Data\User;

class SaveUserJob extends Job
{
    private string $name;
    private string $email;
    private string $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
     }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() : User
    {
        return User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
    }
}
