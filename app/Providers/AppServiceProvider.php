<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra todos os serviços da aplicação.
     * 
     * Este método é chamado durante o processo de inicialização do Laravel
     * e é usado para registrar bindings no container de serviços.
     */
    public function register(): void
    {
        //
    }

    /**
     * Inicializa todos os serviços da aplicação.
     * 
     * Este método é executado após todos os providers terem sido registrados,
     * permitindo configurações que dependem de outros serviços.
     */
    public function boot(): void
    {
        //
    }
}
