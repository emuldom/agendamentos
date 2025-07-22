<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')            
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->string('nome_completo', 255);
            $table->string('numero_whatsapp', 20);
            $table->string('email', 255)->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['empresa_id', 'numero_whatsapp']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};