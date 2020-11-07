<?php

namespace Database\Seeders;

use Framework\Data\ValueObjects\RamModuleType;
use Framework\Data\ValueObjects\RamModule;
use Framework\Data\Collections\RamModules;
use Framework\Data\ValueObjects\Currency;
use Framework\Data\ValueObjects\Price;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Framework\Data\Server;
use Framework\Data\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create();

        $user = new User([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $user->save();

        $server = new Server([
            'asset_id' => 12345678,
            'name' => $faker->domainWord,
            'brand_id' => 1,
            'user_id' => $user->id,
            'price' => new Price(122, new Currency('EUR')),
            'ram_modules' => new RamModules([
                new RamModule(
                    $faker->randomElement([1, 2, 4, 8, 16, 32, 64]),
                    new RamModuleType($faker->randomElement(RamModuleType::TYPES))
                )
            ]),
        ]);
        $server->save();

        $this->call(BrandSeeder::class);
    }
}
