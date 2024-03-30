<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->create(['name' => 'В тренде']);
        Category::factory()->create(['name' => 'Обычн.']);
    }
}
