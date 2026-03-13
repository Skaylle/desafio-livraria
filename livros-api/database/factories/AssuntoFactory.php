<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AssuntoFactory extends Factory
{
    protected $model = \App\Models\Assunto::class;

    public function definition(): array
    {
        return [
            'descricao' => fake()->word()
        ];
    }
}