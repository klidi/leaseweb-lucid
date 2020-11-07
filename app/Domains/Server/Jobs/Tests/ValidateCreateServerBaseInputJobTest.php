<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 6.11.20
 * Time: 9:39 PM
 */

namespace Framework\Domains\Server\Jobs\Tests;

use Framework\Domains\Server\Jobs\ValidateCreateServerBaseInputJob;
use Framework\Data\ValueObjects\RamModuleType;
use Lucid\Foundation\Validator;
use Faker\Generator as Faker;
use Tests\TestCase;

class ValidateCreateServerBaseInputJobTest extends TestCase
{
    private $faker;

    public function __construct()
    {
        $this->faker = new Faker();
        $this->seed();
    }

    public function test_validate_create_server_base_input()
    {
        $this->generateFakeValidInputData();
        $validationJob = new ValidateCreateServerBaseInputJob($this->generateFakeValidInputData());
        $validationJob->handle(app(Validator::class));
    }

    private function generateFakeValidInputData()
    {
        return [
            'asset_id' => $this->faker->ean8,
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
