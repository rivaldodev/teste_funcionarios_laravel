<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/**
 * Configuração principal da aplicação Laravel.
 * 
 * Este arquivo define as configurações básicas do framework,
 * incluindo roteamento, middleware e tratamento de exceções.
 */
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php', // Rotas web da aplicação
        commands: __DIR__.'/../routes/console.php', // Comandos do console
        health: '/up', // Endpoint de health check
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Configurações de middleware podem ser adicionadas aqui
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Tratamento personalizado de exceções pode ser configurado aqui
    })->create();
