<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::factory(),
            'nome_completo' => fake()->name(),
            'numero_whatsapp' => fake()->phoneNumber(),
            'email' => fake()->optional(0.8)->safeEmail(),
            // data_cadastro é preenchido automaticamente pelo useCurrent()
        ];
    }
}