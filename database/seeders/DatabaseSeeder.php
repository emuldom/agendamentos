<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Usuario;
use App\Models\Funcionario;
use App\Models\Cliente;
use App\Models\TipoAgendamento;
use App\Models\Agendamento;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria uma empresa
        $empresa = Empresa::factory()->create();
        
        // Cria 5 clientes para esta empresa
        $clientes = Cliente::factory(5)
            ->create(['empresa_id' => $empresa->id]);
            
        // Cria 3 funcionários para esta empresa
        $funcionarios = Funcionario::factory(3)
            ->create(['empresa_id' => $empresa->id]);
            
        // Cria 4 tipos de agendamento para esta empresa
        $tiposAgendamento = TipoAgendamento::factory(4)
            ->create(['empresa_id' => $empresa->id]);
            
        // Cria 10 agendamentos usando as entidades criadas
        foreach ($clientes as $cliente) {
            foreach ($funcionarios as $funcionario) {
                Agendamento::factory()
                    ->create([
                        'empresa_id' => $empresa->id,
                        'cliente_id' => $cliente->id,
                        'funcionario_id' => $funcionario->id,
                        'tipo_agendamento_id' => $tiposAgendamento->random()->id
                    ]);
            }
        }
        
        // Cria um usuário administrador
        Usuario::factory()->create([
            'empresa_id' => $empresa->id,
            'funcionario_id' => $funcionarios->first()->id,
            'nome_usuario' => 'Administrador',
            'email_login' => 'admin@exemplo.com',
            'senha_hash' => bcrypt('senha123'),
            'nivel_acesso' => 'Admin',
            'ativo' => true
        ]);
    }
}
