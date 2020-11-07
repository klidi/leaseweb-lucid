<?php

namespace Framework\Domains\Server\Tests\Jobs;

use Framework\Domains\Server\Jobs\MakeRamModulesFromInputJob;
use Framework\Data\ValueObjects\RamModuleType;
use Illuminate\Foundation\Testing\WithFaker;
use Lucid\Foundation\InvalidInputException;
use Framework\Data\Collections\RamModules;
use Tests\TestCase;

class MakeRamModulesFromInputJobTest extends TestCase
{
    use WithFaker;

    public function test_make_ram_modules_job_valid_input()
    {
        $job = new MakeRamModulesFromInputJob($this->generateFakeRamModules());
        $this->assertInstanceOf( RamModules::class, $job->handle());
    }

    public function test_make_ram_modules_job_empty_ram_modules()
    {
        $this->expectException(InvalidInputException::class);
        $job = new MakeRamModulesFromInputJob([]);
        $job->handle();
    }

    public function test_make_ram_modules_job_empty_ram_module()
    {
        $this->expectException(InvalidInputException::class);
        $job = new MakeRamModulesFromInputJob([[]]);
        $job->handle();
    }

    private function generateFakeRamMOdules()
    {
        return [
            [
                'type' => $this->faker->randomElement(RamModuleType::TYPES),
                'size' => $this->faker->randomElement([1, 2, 4, 8, 16, 32, 64]),
            ],
        ];
    }
}
