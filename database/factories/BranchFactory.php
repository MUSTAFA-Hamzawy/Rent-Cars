<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    protected $model = Branch::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'branch_name' => fake()->unique()->text('120'),
            'created_by' => function () {return User::inRandomOrder()->value('id');},
            'available_time' => json_encode([
                'work_days' => fake()->randomElements(['1', '2', '3', '4', '5', '6', '7'], 5),
                'work_hours_end' => fake()->time('H:i'),
                'work_hours_start' => fake()->time('H:i'),
            ])
        ];
    }
}
