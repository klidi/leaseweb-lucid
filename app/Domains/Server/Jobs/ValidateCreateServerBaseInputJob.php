<?php

namespace Framework\Domains\Server\Jobs;

use Framework\Data\Server;
use Lucid\Foundation\Validator;
use Lucid\Foundation\Job;

class ValidateCreateServerBaseInputJob extends Job
{
    private array $input;

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
     * @param Validator $validator
     * @return bool
     * @throws \Lucid\Foundation\InvalidInputException
     */
    public function handle(Validator $validator) : bool
    {
        return $validator->validate($this->input, Server::getValidationRules());
    }
}
