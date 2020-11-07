<?php

namespace Framework\Domains\Server\Tests\Jobs;

use Framework\Domains\Server\Jobs\MakeServerFromInputJob;
use Framework\Data\ValueObjects\RamModuleType;
use Illuminate\Foundation\Testing\WithFaker;
use Framework\Data\ValueObjects\RamModule;
use Framework\Data\Collections\RamModules;
use Framework\Data\ValueObjects\Currency;
use Framework\Data\ValueObjects\Price;
use Lucid\Foundation\Validator;
use Framework\Data\Server;
use Framework\Data\User;
use Tests\TestCase;

class MakeServerFromInputJobTest extends TestCase
{
    use WithFaker;

    public function test_make_server_job_valid_construct()
    {
        $this->prepare();
        $input = $this->generateFakeValidInputData();
        $job = new MakeServerFromInputJob(
            $input['asset_id'],
            $input['name'],
            $input['brand_id'],
            $input['price'],
            $input['ram_modules'],
        );
        $this->assertInstanceOf(Server::class,  $job->handle());
    }

    /**
     * @dataProvider serverInputValidationProvider
     */
    public function test_validating_server_input_job_rules(array $input) :void
    {
        $this->expectException(\TypeError::class);
        $this->prepare();
        $job = new MakeServerFromInputJob(
            $input['asset_id'],
            $input['name'],
            $input['brand_id'],
            $input['price'],
            $input['ram_modules'],
        );
        $job->handle(app(Validator::class));
    }

    public function serverInputValidationProvider() : array
    {
        return [
            'invalid arg type asset_id' => [
                'input' => [
                    'asset_id' => 'a',
                    'name' => 'Server 1 Test',
                    'brand_id' => 1,
                    'price' => new Price(122, new Currency('EUR')),
                    'ram_modules' => new RamModules([
                        new RamModule(
                            64,
                            new RamModuleType('DDR3')
                        )
                    ]),
                ],
            ],
            'invalid arg type brand_id' => [
                'input' => [
                    'asset_id' => 'a',
                    'name' => 'Server 1 Test',
                    'brand_id' => 'a',
                    'price' => new Price(122, new Currency('EUR')),
                    'ram_modules' => new RamModules([
                        new RamModule(
                            64,
                            new RamModuleType('DDR3')
                        )
                    ]),
                ]
            ],
            'invalid arg type price' => [
                'input' => [
                    'asset_id' => 'a',
                    'name' => 'Server 1 Test',
                    'brand_id' => 1,
                    'price' => [],
                    'ram_modules' => new RamModules([
                        new RamModule(
                            64,
                            new RamModuleType('DDR3')
                        )
                    ]),
                ]
            ],
            'invalid arg type ram_modules' => [
                'input' => [
                    'asset_id' => 'a',
                    'name' => 'Server 1 Test',
                    'brand_id' => 1,
                    'price' => new Price(122, new Currency('EUR')),
                    'ram_modules' => [],
                ]
            ],
        ];
    }

    private function prepare()
    {
        $this->seed();
        $user = User::find(1);
        $this->actingAs($user);
    }

    private function generateFakeValidInputData() : array
    {
        return [
            'asset_id' => random_int(10000000, 99999999),
            'name' => $this->faker->domainWord,
            'brand_id' => 1,
            'price' => new Price(122, new Currency('EUR')),
            'ram_modules' => new RamModules([
                new RamModule(
                    $this->faker->randomElement([1, 2, 4, 8, 16, 32, 64]),
                    new RamModuleType($this->faker->randomElement(RamModuleType::TYPES))
                )
            ]),
        ];
    }
}
