<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'IPhone 17',
            'description' => 'Iphone 17',
            'price' => 0.01,
            'image_url' => 'https://www.apple.com/newsroom/images/2025/09/apple-debuts-iphone-17/geo/article/Apple-iPhone-17-hero-250909_inline.jpg.small_2x.jpg'
        ]);
    }
}
