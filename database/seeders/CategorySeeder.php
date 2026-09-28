<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Царская Россия', 'slug' => 'tsarskaya-rossiya', 'sort_order' => 1],
            ['name' => 'РСФСР и СССР 1921–1958 гг.', 'slug' => 'rsfsr-sssr-1921-1958', 'sort_order' => 2],
            ['name' => 'СССР 1961–1991 гг.', 'slug' => 'sssr-1961-1991', 'sort_order' => 3],
            ['name' => 'РФ с 1991 г.', 'slug' => 'rf-s-1991', 'sort_order' => 4],
            ['name' => 'Юбилейные монеты', 'slug' => 'yubileynye', 'sort_order' => 5],
            ['name' => 'Иностранные монеты', 'slug' => 'inostrannye', 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
