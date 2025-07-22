<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->foreignId('funcionario_id')
                  ->nullable()
                  ->constrained('funcionarios')
                  ->onDelete('set null');
            $table->string('nome_usuario', 100);
            $table->string('email_login', 255)->unique();
            $table->string('senha_hash');
            $table->string('nivel_acesso', 20);
            $table->boolean('ativo')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};