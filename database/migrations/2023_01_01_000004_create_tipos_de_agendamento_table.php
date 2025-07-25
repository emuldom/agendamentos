<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_de_agendamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id') 
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->string('nome_servico', 255);
            $table->text('descricao')->nullable();
            $table->integer('duracao_estimada_min')->nullable();
            $table->decimal('valor', 10, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_de_agendamento');
    }
};