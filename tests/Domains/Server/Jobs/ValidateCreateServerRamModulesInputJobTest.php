<?php

namespace Framework\Domains\Server\Tests\Jobs;

use Framework\Domains\Server\Jobs\ValidateCreateServerRamModulesInputJob;
use Framework\Data\ValueObjects\RamModuleType;
use Illuminate\Foundation\Testing\WithFaker;
use Lucid\Foundation\Validator;
use Tests\TestCase;

class ValidateCreateServerRamModulesInputJobTest extends TestCase
{
    use WithFaker;

    public function test_validate_create_server_ram_modules_input_job()
    {
        $validationJob = new ValidateCreateServerRamModulesInputJob($this->generateFakeValidInputData());
        $this->assertTrue($validationJob->handle(app(Validator::class)));
    }

    /**
     * @dataProvider serverInputValidationProvider
     */
    public function test_validating_server_input_job_rules($ramModules) :void
    {
        $this->expectException('\Lucid\Foundation\InvalidInputException');
        $job = new ValidateCreateServerRamModulesInputJob($ramModules);
        $job->handle(app(Validator::class));
    }

    public function serverInputValidationProvider() : array
    {
        return [
            'without size' => [
                'ram_modules' => [
                    [
                        'type' => 'DDR3',
                    ],
                ],
            ],
            'non bitstream size' => [
                'ram_modules' => [
                    [
                        'size' => 5,
                        'type' => 'DDR3',
                    ],
                ],
            ],
            'size 0' => [
                'ram_modules' => [
                    [
                        'size' => 0,
                        'type' => 'DDR3',
                    ],
                ],
            ],
            'without type' => [
                'ram_modules' => [
                    [
                        'size' => 4,
                    ],
                ],
            ],
            'type non string' => [
                'ram_modules' => [
                    [
                        'size' => 8,
                        'type' => 5,
                    ],
                ],
            ],
            'type lentgth min' => [
                'ram_modules' => [
                    [
                        'size' => 8,
                        'type' => 'DD',
                    ],
                ],
            ],
            'not in types type' => [
                'ram_modules' => [
                    [
                        'size' => 8,
                        'type' => 'DDR10',
                    ],
                ],
            ],
        ];
    }
    private function generateFakeValidInputData() : array
    {
        return [
            [
                'type' => $this->faker->randomElement(RamModuleType::TYPES),
                'size' => $this->faker->randomElement([1, 2, 4, 8, 16, 32, 64]),
            ],
        ];
    }
}
