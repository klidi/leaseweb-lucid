<?php

namespace Framework\Domains\Auth\Jobs;

use Framework\Providers\RouteServiceProvider;
use Lucid\Foundation\Validator;
use Lucid\Foundation\Job;

class ValidateRegistrationInputJob extends Job
{
    private array $input;

    private array $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Validator $validator) : bool
    {
        return $validator->validate($this->input, $this->rules);
    }
}
