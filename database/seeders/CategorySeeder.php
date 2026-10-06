<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Родители
        $tsar = Category::updateOrCreate(
            ['slug' => 'tsarskaya-rossiya'],
            ['name' => 'Царская Россия', 'sort_order' => 1, 'parent_id' => null]
        );

        $rsfsr = Category::updateOrCreate(
            ['slug' => 'rsfsr-sssr-1921-1958'],
            ['name' => 'РСФСР и СССР 1921–1958 гг.', 'sort_order' => 2, 'parent_id' => null]
        );

        $sssr = Category::updateOrCreate(
            ['slug' => 'sssr-1961-1991'],
            ['name' => 'СССР 1961–1991 гг.', 'sort_order' => 3, 'parent_id' => null]
        );

        $rf = Category::updateOrCreate(
            ['slug' => 'rf-s-1991'],
            ['name' => 'РФ с 1991 г.', 'sort_order' => 4, 'parent_id' => null]
        );

        $foreign = Category::updateOrCreate(
            ['slug' => 'inostrannye'],
            ['name' => 'Иностранные монеты', 'sort_order' => 5, 'parent_id' => null]
        );

        // Подкатегории РСФСР и СССР 1921–1958
        Category::updateOrCreate(
            ['slug' => 'rsfsr-regulyarnyy'],
            ['name' => 'Регулярный чекан', 'parent_id' => $rsfsr->id, 'sort_order' => 1]
        );
        Category::updateOrCreate(
            ['slug' => 'rsfsr-kollektsionnye'],
            ['name' => 'Коллекционные монеты', 'parent_id' => $rsfsr->id, 'sort_order' => 2]
        );

        // Подкатегории СССР 1961–1991
        Category::updateOrCreate(
            ['slug' => 'sssr61-regulyarnyy'],
            ['name' => 'Регулярный чекан', 'parent_id' => $sssr->id, 'sort_order' => 1]
        );
        Category::updateOrCreate(
            ['slug' => 'sssr61-yubileynye'],
            ['name' => 'Юбилейные монеты', 'parent_id' => $sssr->id, 'sort_order' => 2]
        );
        Category::updateOrCreate(
            ['slug' => 'sssr61-kollektsionnye'],
            ['name' => 'Коллекционные монеты', 'parent_id' => $sssr->id, 'sort_order' => 3]
        );

        // Подкатегории РФ с 1991
        Category::updateOrCreate(
            ['slug' => 'rf-regulyarnyy'],
            ['name' => 'Регулярный чекан', 'parent_id' => $rf->id, 'sort_order' => 1]
        );
        Category::updateOrCreate(
            ['slug' => 'rf-yubileynye'],
            ['name' => 'Юбилейные монеты', 'parent_id' => $rf->id, 'sort_order' => 2]
        );
    }
}
