<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Option::create([
            'name' => 'Frame Style',
            'description' => 'Various designs like road, mountain, or hybrid.',
            'image_url' => 'frame_style.jpg', 
            'price' => 500, 
            'item_number' => 'FRAME_STYLE_001' 
        ]);

        Option::create([
            'name' => 'Color',
            'description' => 'Multiple color choices like red, blue, or green.',
            'image_url' => 'color.jpg', 
            'price' => 200, 
            'item_number' => 'COLOR_001' 
        ]);

        Option::create([
            'name' => 'Wheel Size',
            'description' => 'Different sizing options such as 26-inch, 28-inch, or 29-inch wheels.',
            'image_url' => 'wheel_size.jpg',
            'price' => 300,
            'item_number' => 'WHEEL_SIZE_001'
        ]);

        Option::create([
            'name' => 'Accessories Package',
            'description' => 'Additional items like helmets, locks, or lights.',
            'image_url' => 'accessories_package.jpg',
            'price' => 100,
            'item_number' => 'ACCESSORIES_PACKAGE_001'
        ]);
    }
}
