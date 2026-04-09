<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin BanCream',
            'email' => 'admin@bancream.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
        
        // Dummy category
        $cat = \App\Models\Category::create(['name' => 'สกินแคร์', 'slug' => 'skincare']);
        
        \App\Models\Product::create([
            'sku' => 'SKU001',
            'name' => 'ครีมหน้าใสพรีเมียม',
            'retail_price' => 590,
            'wholesale_price' => 350,
            'category_id' => $cat->id,
        ]);
    }
}
