<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Executa todos os seeders do sistema.
     *
     * Este método é chamado ao rodar o comando db:seed e garante que os dados
     * de teste necessários estejam presentes no banco de dados.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            FuncionarioSeeder::class, // Popula a tabela de funcionários
        ]);
    }
}
