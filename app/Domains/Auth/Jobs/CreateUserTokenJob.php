<?php

namespace Framework\Domains\Auth\Jobs;

use Framework\Data\User;
use Lucid\Foundation\Job;

class CreateUserTokenJob extends Job
{
    private User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->user->createToken('Laravel Password Grant Client')->accessToken;
    }
}
