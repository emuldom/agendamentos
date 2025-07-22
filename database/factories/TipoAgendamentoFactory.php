<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\TipoAgendamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoAgendamentoFactory extends Factory
{
    protected $model = TipoAgendamento::class;

    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::factory(),
            'nome_servico' => fake()->randomElement([
                'Corte de Cabelo', 
                'Manicure', 
                'Pedicure', 
                'Massagem', 
                'Limpeza de Pele',
                'Consulta Médica',
                'Avaliação Física',
                'Sessão de Fisioterapia'
            ]),
            'descricao' => fake()->paragraph(),
            'duracao_estimada_min' => fake()->randomElement([30, 45, 60, 90, 120]),
            'valor' => fake()->randomFloat(2, 50, 500),
        ];
    }
}