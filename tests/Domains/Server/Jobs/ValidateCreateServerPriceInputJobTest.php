<?php

namespace Framework\Domains\Server\Tests\Jobs;

use Framework\Domains\Server\Jobs\ValidateCreateServerPriceInputJob;
use Illuminate\Foundation\Testing\WithFaker;
use Lucid\Foundation\Validator;
use Tests\TestCase;

class ValidateCreateServerPriceInputJobTest extends TestCase
{
    use WithFaker;

    public function test_validate_create_server_price_input_job()
    {
        $validationJob = new ValidateCreateServerPriceInputJob($this->generateFakeValidInputData());
        $this->assertTrue($validationJob->handle(app(Validator::class)));
    }

    /**
     * @dataProvider serverInputValidationProvider
     */
    public function test_validating_server_input_job_rules($price) :void
    {
        $this->expectException('\Lucid\Foundation\InvalidInputException');
        $job = new ValidateCreateServerPriceInputJob($price);
        $job->handle(app(Validator::class));
    }

    public function serverInputValidationProvider() : array
    {
        return [
            'without amount' => [
                'price' => [
                    'currency' => 'USD',
                ]
            ],
            'non integer amount' => [
                'price' => [
                    'amount' => 'a',
                    'currency' => 'USD',
                ],
            ],
            'amount 0' => [
                'price' => [
                    'amount' => 0,
                    'currency' => 'USD',
                ]
            ],
            'without currency' => [
                'price' => [
                    'amount' => 122,
                ]
            ],
            'currency non string' => [
                'price' => [
                    'amount' => 0,
                    'currency' => 1,
                ]
            ],
            'currency max length' => [
                'price' => [
                    'amount' => 0,
                    'currency' => 'USDDD',
                ]
            ],
            'currency min length' => [
                'price' => [
                    'amount' => 0,
                    'currency' => 'US',
                ]
            ],
        ];
    }

    private function generateFakeValidInputData() : array
    {
        return [
            'amount' => $this->faker->randomNumber(3),
            'currency' => $this->faker->randomElement(['USD', 'EUR']),
        ];
    }
}
