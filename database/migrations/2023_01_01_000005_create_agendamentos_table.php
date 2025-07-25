<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->foreignId('cliente_id') 
                  ->constrained('clientes')
                  ->onDelete('cascade');
            $table->foreignId('funcionario_id') 
                  ->constrained('funcionarios')
                  ->onDelete('cascade');
            $table->foreignId('tipo_agendamento_id') 
                  ->constrained('tipos_de_agendamento')
                  ->onDelete('cascade');
            $table->timestampTz('data_hora_agendamento');
            $table->string('status_agendamento', 20)->default('Agendado');
            $table->string('origem_agendamento', 20)->default('Site');
            $table->text('observacoes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};