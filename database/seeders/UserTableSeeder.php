<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fa_IR');
        for ($i = 0; $i < 100; $i++) {
            Product::create([
                'name' => $faker->name,
                'description' => $faker->realText($max=30),
                'quantity'=> random_int(1,1000),
                'price' => random_int(100000,1000000),
                'category_id' => 1,
                'image' => Str::random(50),
                'is_available' => $faker->randomElement([true, false]),
                'created_at'=> $faker->unique()->dateTime($max = 'now'),
                'updated_at'=> $faker->unique()->dateTime($max = 'now'),
            ]);
        }

    }
}
