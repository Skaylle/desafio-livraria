<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LivroFactory extends Factory
{
    protected $model = \App\Models\Livro::class;

    public function definition(): array
    {
        return [
            'titulo' => fake()->sentence(3),
            'editora' => fake()->company(),
            'edicao' => fake()->numberBetween(1, 10),
            'ano_publicacao' => fake()->year(),
            'valor' => fake()->randomFloat(2, 10, 200),
        ];
    }
}