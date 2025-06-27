<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrações para criar as tabelas de jobs/filas.
     * 
     * Cria as tabelas necessárias para o sistema de filas do Laravel:
     * - jobs: trabalhos pendentes
     * - job_batches: lotes de trabalhos
     * - failed_jobs: trabalhos que falharam
     */
    public function up(): void
    {
        // Tabela principal de jobs/trabalhos
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index(); // Nome da fila
            $table->longText('payload'); // Dados do trabalho
            $table->unsignedTinyInteger('attempts'); // Tentativas de execução
            $table->unsignedInteger('reserved_at')->nullable(); // Timestamp de reserva
            $table->unsignedInteger('available_at'); // Disponível em
            $table->unsignedInteger('created_at'); // Criado em
        });

        // Tabela de lotes de jobs
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // ID do lote
            $table->string('name'); // Nome do lote
            $table->integer('total_jobs'); // Total de jobs
            $table->integer('pending_jobs'); // Jobs pendentes
            $table->integer('failed_jobs'); // Jobs que falharam
            $table->longText('failed_job_ids'); // IDs dos jobs que falharam
            $table->mediumText('options')->nullable(); // Opções do lote
            $table->integer('cancelled_at')->nullable(); // Cancelado em
            $table->integer('created_at'); // Criado em
            $table->integer('finished_at')->nullable(); // Finalizado em
        });

        // Tabela de jobs que falharam
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique(); // UUID único
            $table->text('connection'); // Conexão utilizada
            $table->text('queue'); // Fila utilizada
            $table->longText('payload'); // Dados do job
            $table->longText('exception'); // Exceção que causou a falha
            $table->timestamp('failed_at')->useCurrent(); // Data da falha
        });
    }

    /**
     * Reverte as migrações removendo as tabelas de jobs.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
