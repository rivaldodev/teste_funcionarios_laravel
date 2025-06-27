<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrações para criar as tabelas padrão do Laravel.
     * 
     * Cria as tabelas 'users', 'password_reset_tokens' e 'sessions'
     * necessárias para o sistema de autenticação do Laravel.
     *
     * @return void
     */
    public function up(): void
    {
        // Tabela de usuários do sistema
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID único do usuário
            $table->string('name'); // Nome do usuário
            $table->string('email')->unique(); // Email único
            $table->timestamp('email_verified_at')->nullable(); // Data de verificação do email
            $table->string('password'); // Senha criptografada
            $table->rememberToken(); // Token para "lembrar-me"
            $table->timestamps(); // created_at e updated_at
        });

        // Tabela para tokens de redefinição de senha
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email como chave primária
            $table->string('token'); // Token de redefinição
            $table->timestamp('created_at')->nullable(); // Data de criação do token
        });

        // Tabela de sessões do usuário
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID da sessão
            $table->foreignId('user_id')->nullable()->index(); // ID do usuário logado
            $table->string('ip_address', 45)->nullable(); // Endereço IP
            $table->text('user_agent')->nullable(); // Informações do navegador
            $table->longText('payload'); // Dados da sessão
            $table->integer('last_activity')->index(); // Última atividade
        });
    }

    /**
     * Reverte as migrações removendo as tabelas criadas.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
