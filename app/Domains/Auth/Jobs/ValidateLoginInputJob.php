<?php

namespace Framework\Domains\Auth\Jobs;

use Lucid\Foundation\Validator;
use Lucid\Foundation\Job;

class ValidateLoginInputJob extends Job
{

    private array $input;

    private array $rules = [
        'email' => ['required', 'string', 'email', 'max:255'],
        'password' => ['required', 'string', 'min:8'],
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
    public function handle(Validator $validator)
    {
        return $validator->validate($this->input, $this->rules);
    }
}
