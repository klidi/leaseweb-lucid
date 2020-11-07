<?php

namespace Framework\Domains\Server\Jobs;

use Framework\Data\ValueObjects\RamModuleType;
use Framework\Data\ValueObjects\RamModule;
use Illuminate\Validation\Rule;
use Lucid\Foundation\Validator;
use Lucid\Foundation\Job;

class ValidateCreateServerRamModulesInputJob extends Job
{
    private array $ramModules;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $ramModules)
    {
        $this->ramModules = $ramModules;
    }

    /**
     * @param Validator $validator
     * @return bool
     * @throws \Lucid\Foundation\InvalidInputException
     */
    public function handle(Validator $validator) : bool
    {
        $isValidData = false;
        foreach ($this->ramModules as $ramModule) {
            $isValidData = $validator->validate($ramModule, RamModule::getValidationRules());
        }
        return $isValidData;
    }
}
