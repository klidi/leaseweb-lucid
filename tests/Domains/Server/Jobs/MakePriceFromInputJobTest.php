<?php

namespace Framework\Domains\Server\Tests\Jobs;

use Framework\Domains\Server\Jobs\MakePriceFromInputJob;
use Illuminate\Foundation\Testing\WithFaker;
use Lucid\Foundation\InvalidInputException;
use Framework\Data\ValueObjects\Price;
use Tests\TestCase;

class MakePriceFromInputJobTest extends TestCase
{
    use WithFaker;

    public function test_make_price_job()
    {
        $job = new MakePriceFromInputJob($this->generateFakePriceInput());
        $this->assertInstanceOf( Price::class, $job->handle());
    }

    public function test_make_price_job_missing_input_array_keys()
    {
        $this->expectException(InvalidInputException::class);
        $job = new MakePriceFromInputJob([]);
        $job->handle();
    }

    private function generateFakePriceInput()
    {
        return [
            'amount' => $this->faker->randomNumber(3),
            'currency' => $this->faker->randomElement(['USD', 'EUR']),
        ];
    }
}
