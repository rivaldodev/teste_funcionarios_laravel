<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Comando personalizado para exibir citações inspiradoras
// Pode ser executado com: php artisan inspire
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Exibe uma citação inspiradora');
