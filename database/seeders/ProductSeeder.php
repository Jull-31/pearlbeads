<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Bracelets
            [
                'category_id' => 1,
                'name' => 'Ilena Bracelet',
                'slug' => 'ilena-bracelet',
                'description' => 'Beautiful purple beaded bracelet',
                'price' => 35000,
                'stock' => 10,
                'is_active' => true
            ],
            [
                'category_id' => 1,
                'name' => 'Bell Bracelet',
                'slug' => 'bell-bracelet',
                'description' => 'Pink beaded bracelet with bell charm',
                'price' => 38000,
                'stock' => 8,
                'is_active' => true
            ],
            [
                'category_id' => 1,
                'name' => 'Story Bracelet',
                'slug' => 'story-bracelet',
                'description' => 'Green and white beaded story bracelet',
                'price' => 40000,
                'stock' => 12,
                'is_active' => true
            ],
            [
                'category_id' => 1,
                'name' => 'Aurora Bracelet',
                'slug' => 'aurora-bracelet',
                'description' => 'Elegant aurora-themed bracelet',
                'price' => 42000,
                'stock' => 15,
                'is_active' => true
            ],
            // Phone Straps
            [
                'category_id' => 2,
                'name' => 'Spidermine Strap',
                'slug' => 'spidermine-strap',
                'description' => 'Spider-Man themed phone strap - Special Edition',
                'price' => 26000,
                'stock' => 20,
                'is_active' => true
            ],
            [
                'category_id' => 2,
                'name' => 'Cute Bear Strap',
                'slug' => 'cute-bear-strap',
                'description' => 'Adorable bear charm phone strap',
                'price' => 28000,
                'stock' => 18,
                'is_active' => true
            ],
            [
                'category_id' => 2,
                'name' => 'Flower Garden Strap',
                'slug' => 'flower-garden-strap',
                'description' => 'Colorful flower beaded phone strap',
                'price' => 30000,
                'stock' => 15,
                'is_active' => true
            ],
            [
                'category_id' => 2,
                'name' => 'Ocean Wave Strap',
                'slug' => 'ocean-wave-strap',
                'description' => 'Blue ocean-themed phone strap',
                'price' => 32000,
                'stock' => 10,
                'is_active' => true
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}