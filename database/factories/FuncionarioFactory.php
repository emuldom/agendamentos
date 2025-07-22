<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Funcionario;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionarioFactory extends Factory
{
    protected $model = Funcionario::class;

    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::factory(),
            'nome_completo' => fake()->name(),
            'cargo' => fake()->jobTitle(),
            'email_profissional' => fake()->unique()->companyEmail(),
            'telefone_contato' => fake()->phoneNumber(),
            'ativo' => true,
        ];
    }

    public function inativo(): static
    {
        return $this->state(fn (array $attributes) => [
            'ativo' => false,
        ]);
    }
}