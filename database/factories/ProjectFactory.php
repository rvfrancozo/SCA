<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $num = 1;
        return [
            'name' => "Project ".str($num++)->trim()->toString(),
            'description' => fake()->realText(200),
            'user_id' => 1,
        ];
    }
}
