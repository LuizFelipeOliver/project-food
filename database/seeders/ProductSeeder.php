<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categories = DB::table('categories')->pluck('id');

        $products = [];

        for ($i = 0; $i < 20; $i++) {
            $products[] = [
                'name' => $faker->words(3, true),
                'category_id' => $faker->randomElement($categories),
                'status' => $faker->randomElement(['disponível', 'indisponível']),
                'description' => $faker->sentence(),
                'price' => $faker->randomFloat(2, 1, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}
