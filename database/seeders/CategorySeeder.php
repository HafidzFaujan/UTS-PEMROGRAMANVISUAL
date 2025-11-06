<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Makanan Pembuka',
            'Makanan Utama',
            'Makanan Penutup',
            'Minuman',
            'Camilan',
            'Makanan Tradisional',
            'Makanan Cepat Saji',
            'Salad',
            'Sup',
            'Kue dan Roti'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category)
            ]);
        }
    }
}