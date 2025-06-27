<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrações para criar as tabelas de cache.
     * 
     * Cria as tabelas 'cache' e 'cache_locks' necessárias para o
     * sistema de cache do Laravel.
     */
    public function up(): void
    {
        // Tabela principal de cache
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // Chave do cache
            $table->mediumText('value'); // Valor armazenado
            $table->integer('expiration'); // Tempo de expiração
        });

        // Tabela de locks do cache (para sincronização)
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // Chave do lock
            $table->string('owner'); // Proprietário do lock
            $table->integer('expiration'); // Tempo de expiração do lock
        });
    }

    /**
     * Reverte as migrações removendo as tabelas de cache.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
