<?php

namespace Database\Seeders;

use Framework\Data\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = new Brand();
        $brand->name = 'Dell';
        $brand->save();

        $brand = new Brand();
        $brand->name = 'HP';
        $brand->save();
    }
}
