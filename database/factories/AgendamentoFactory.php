<?php

namespace Database\Factories;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\TipoAgendamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendamentoFactory extends Factory
{
    protected $model = Agendamento::class;

    public function definition(): array
    {
        $empresa = Empresa::factory()->create();
        $cliente = Cliente::factory()->create(['empresa_id' => $empresa->id]);
        $funcionario = Funcionario::factory()->create(['empresa_id' => $empresa->id]);
        $tipoAgendamento = TipoAgendamento::factory()->create(['empresa_id' => $empresa->id]);
        
        return [
            'empresa_id' => $empresa->id,
            'cliente_id' => $cliente->id,
            'funcionario_id' => $funcionario->id,
            'tipo_agendamento_id' => $tipoAgendamento->id,
            'data_hora_agendamento' => fake()->dateTimeBetween('now', '+2 weeks'),
            'status_agendamento' => fake()->randomElement(['Agendado', 'Confirmado', 'Concluído', 'Cancelado']),
            'origem_agendamento' => fake()->randomElement(['WhatsApp', 'Telefone', 'Site', 'Presencial']),
            'observacoes' => fake()->optional(0.7)->sentence(),
            // data_criacao e data_atualizacao são preenchidos automaticamente
        ];
    }
    
    /**
     * Configura o agendamento para usar entidades existentes em vez de criar novas.
     */
    public function comEntidadesExistentes($empresa, $cliente, $funcionario, $tipoAgendamento): static
    {
        return $this->state(fn (array $attributes) => [
            'empresa_id' => $empresa->id,
            'cliente_id' => $cliente->id,
            'funcionario_id' => $funcionario->id,
            'tipo_agendamento_id' => $tipoAgendamento->id,
        ]);
    }
    
    /**
     * Configura o agendamento com status "Agendado".
     */
    public function agendado(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_agendamento' => 'Agendado',
        ]);
    }
    
    /**
     * Configura o agendamento com status "Confirmado".
     */
    public function confirmado(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_agendamento' => 'Confirmado',
        ]);
    }
    
    /**
     * Configura o agendamento com status "Concluído".
     */
    public function concluido(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_agendamento' => 'Concluído',
            'data_hora_agendamento' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }
    
    /**
     * Configura o agendamento com status "Cancelado".
     */
    public function cancelado(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_agendamento' => 'Cancelado',
        ]);
    }
}