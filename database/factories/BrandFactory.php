<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Brand::class;
    public function definition(): array
    {
        return [
            'brand_name' => fake()->unique()->text('120'),
            'brand_slug' => fake()->unique()->text('120'),
            'brand_logo' => fake()->name(),
            'brand_description' => fake()->paragraph(2),
            'created_at' => now()
        ];
    }
}
