<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DecisionArea>
 */
class DecisionAreaFactory extends Factory
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
            'label' => "DA ".str($num++)->trim()->toString(),
            'description' => fake()->realText(200),
            'importancy' => 5,
            'urgency' => 5,
            'isFocused' => true
        ];
    }
}

