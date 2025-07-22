<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id') 
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->string('nome_completo', 255);
            $table->string('cargo', 100)->nullable();
            $table->string('email_profissional', 255)->unique()->nullable();
            $table->string('telefone_contato', 20)->nullable();
            $table->boolean('ativo')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};