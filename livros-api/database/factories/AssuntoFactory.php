<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AssuntoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'descricao' => fake()->word()
        ];
    }
}