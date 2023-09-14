<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Model;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(12);
        Brand::factory(15)->create();
        Category::factory(15)->create();
        Model::factory(15)->create();
        PaymentMethod::factory(15)->create();
    }
}
