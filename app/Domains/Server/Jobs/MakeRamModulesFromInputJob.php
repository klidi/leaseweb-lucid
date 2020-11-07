<?php

namespace Framework\Domains\Server\Jobs;

use Framework\Data\ValueObjects\RamModuleType;
use Lucid\Foundation\InvalidInputException;
use Framework\Data\Collections\RamModules;
use Framework\Data\ValueObjects\RamModule;
use Lucid\Foundation\Job;

class MakeRamModulesFromInputJob extends Job
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
     * @return RamModules
     * @throws InvalidInputException
     */
    public function handle() : RamModules
    {
        if (count($this->ramModules) > 0) {
            $collection = new RamModules();
            foreach ($this->ramModules as $ramModule) {
                if (isset($ramModule['size']) && isset($ramModule['type'])) {
                    $collection->add(new RamModule($ramModule['size'], new RamModuleType($ramModule['type'])));
                    continue;
                }
                throw new InvalidInputException("Invalid input for RamModule");
            }
            return $collection;
        }
        throw new InvalidInputException("Empty ram modules");
    }
}
