<?php

namespace Framework\Domains\Server\Tests\Jobs;

use Framework\Domains\Server\Jobs\ValidateCreateServerBaseInputJob;
use Framework\Data\ValueObjects\RamModuleType;
use Illuminate\Foundation\Testing\WithFaker;
use Lucid\Foundation\Validator;
use Tests\TestCase;

class ValidateCreateServerBaseInputJobTest extends TestCase
{
    use WithFaker;

    public function test_validate_create_server_base_input_job() : void
    {
        $this->seed();
        $validationJob = new ValidateCreateServerBaseInputJob($this->generateFakeValidInputData());
        $this->assertTrue($validationJob->handle(app(Validator::class)));
    }

    /**
     * @dataProvider serverInputValidationProvider
     */
    public function test_validating_server_input_job_rules($input) :void
    {
        $this->expectException('\Lucid\Foundation\InvalidInputException');
        $this->seed();
        $job = new ValidateCreateServerBaseInputJob($input);
        $job->handle(app(Validator::class));
    }

    public function serverInputValidationProvider() : array
    {
        return [
            'without asset_id' => [
                'input' => [
                    'name' => 'Server Test 1',
                    'brand_id' => 1,
                    'price' => [1,2],
                    'ram_modules' => [1],
                ]
            ],
            'non unique asset_id' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'Server Test 1',
                    'brand_id' => 1,
                    'price' => [1,2],
                    'ram_modules' => [1],
                ]
            ],
            'non integer asset_id' => [
                'input' => [
                    'asset_id' => 'asdsdsa',
                    'name' => 'Server Test 1',
                    'brand_id' => 1,
                    'price' => [1,2],
                    'ram_modules' => [1],
                ]
            ],
            'without name' => [
                'input' => [
                    'asset_id' => 12345678,
                    'brand_id' => 1,
                    'price' => [1,2],
                    'ram_modules' => [1],
                ]
            ],
            'non string name' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 122236,
                    'brand_id' => 1,
                    'price' => [1,2],
                    'ram_modules' => [1],
                ]
            ],
            'max name length' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => str_repeat('a', 40),
                    'brand_id' => 1,
                    'price' => [1,2],
                    'ram_modules' => [1],
                ]
            ],
            'min name length' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'a',
                    'brand_id' => 1,
                    'price' => [1,2],
                    'ram_modules' => [1],
                ]
            ],
            'without brand_id' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'Server Test 1',
                    'price' => [1,2],
                    'ram_modules' => [1],
                ]
            ],
            'non integer brand_id' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'Server Test 1',
                    'brand_id' => 'a',
                    'price' => [1,2],
                    'ram_modules' => [1],
                ]
            ],
            'non existent brand_id' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'Server Test 1',
                    'brand_id' => 10,
                    'price' => [1,2],
                    'ram_modules' => [1],
                ]
            ],
            'without price' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'Server Test 1',
                    'brand_id' => 1,
                    'ram_modules' => [1],
                ]
            ],
            'non array price' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'Server Test 1',
                    'brand_id' => 1,
                    'price' => 1,
                    'ram_modules' => [1],
                ]
            ],
            'price array length not 2' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'Server Test 1',
                    'brand_id' => 1,
                    'price' => [1],
                    'ram_modules' => [1],
                ]
            ],
            'without ram modules' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'Server Test 1',
                    'brand_id' => 1,
                    'price' => [1, 2],
                ]
            ],
            'ram_modules empty array' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'Server Test 1',
                    'brand_id' => 1,
                    'price' => [1],
                    'ram_modules' => [],
                ]
            ],
            'ram_modules non array' => [
                'input' => [
                    'asset_id' => 12345678,
                    'name' => 'Server Test 1',
                    'brand_id' => 1,
                    'price' => [1],
                    'ram_modules' => 1,
                ]
            ],
        ];
    }

    private function generateFakeValidInputData() : array
    {
        return [
            'asset_id' => random_int(10000000, 99999999),
            'name' => $this->faker->domainWord,
            'brand_id' => 1,
            'price' => [
                'amount' => $this->faker->randomNumber(3),
                'currency' => $this->faker->randomElement(['USD', 'EUR']),
            ],
            'ram_modules' => [
                'type' => $this->faker->randomElement(RamModuleType::TYPES),
                'size' => $this->faker->randomElement([1, 2, 4, 8, 16, 32, 64]),
            ],
        ];
    }
}
