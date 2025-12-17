<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bracelet',
                'slug' => 'bracelet',
                'description' => 'Handmade bracelets with beautiful beads'
            ],
            [
                'name' => 'Phone Strap',
                'slug' => 'phone-strap',
                'description' => 'Cute phone straps with various themes'
            ],
            [
                'name' => 'Necklace',
                'slug' => 'necklace',
                'description' => 'Beautiful handmade necklaces'
            ],
            [
                'name' => 'Couple Items',
                'slug' => 'couple-items',
                'description' => 'Matching accessories for couples'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}