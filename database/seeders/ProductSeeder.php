<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Basic Model',
            'base_price' => 500,
        ]);

        Product::create([
            'name' => 'Mountain Bike',
            'base_price' => 800,
        ]);

        Product::create([
            'name' => 'Road Bike',
            'base_price' => 700,
        ]);

        Product::create([
            'name' => 'Electric Bike',
            'base_price' => 1200,
        ]);
    }
}
