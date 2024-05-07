<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesPersons;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleAndPermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleAndPermissionSeeder::class);

        $salePersons = SalesPersons::factory(10)->create();

        // for($i = 0; $i < 20; $i++) {
        //     Product::factory(50000)->create();
        // }

        $products = Product::factory(100)->create();

        for($i = 0; $i < 200; $i++) {
            $records = array_map(
                function () use ($salePersons, $products) {
                    return [
                        'ProductId' => $products->random()->id,
                        'SalesPersonId' => $salePersons->random()->id
                    ];
                },
                array_fill(0,10000, [])
            );

            Sales::factory()->createMany($records);
        }

    }
}
