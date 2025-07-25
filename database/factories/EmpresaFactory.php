<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    protected $model = Empresa::class;

    public function definition(): array
    {
        return [
            'nome_empresa' => fake()->company(),
            'cnpj' => fake()->numerify('##.###.###/####-##'),
            'telefone_contato' => fake()->phoneNumber(),
            'email_contato' => fake()->unique()->companyEmail(),
            // data_cadastro é preenchido automaticamente pelo useCurrent()
        ];
    }
}