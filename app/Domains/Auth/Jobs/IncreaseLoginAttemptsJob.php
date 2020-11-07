<?php

namespace Framework\Domains\Auth\Jobs;

use Framework\Foundation\Auth\Traits\ThrottlesLogins;
use Illuminate\Http\Request;
use Lucid\Foundation\Job;

class IncreaseLoginAttemptsJob extends Job
{
    use ThrottlesLogins;

    private Request $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->incrementLoginAttempts($this->request);
    }
}
