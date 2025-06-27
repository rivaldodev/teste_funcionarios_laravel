<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use Illuminate\Database\Seeder;

class FuncionarioSeeder extends Seeder
{
    public function run(): void
    {
        $funcionarios = [
            [
                'nome' => 'João Silva Santos',
                'email' => 'joao.silva@empresa.com',
                'cpf' => '12345678901',
                'cargo' => 'Desenvolvedor Full Stack',
                'dataAdmissao' => '2023-01-15',
                'salario' => 8500.00,
                'status' => 'ativo'
            ],
            [
                'nome' => 'Maria Oliveira Costa',
                'email' => 'maria.oliveira@empresa.com',
                'cpf' => '98765432109',
                'cargo' => 'Gerente de Projetos',
                'dataAdmissao' => '2022-03-10',
                'salario' => 12000.00,
                'status' => 'ativo'
            ],
            [
                'nome' => 'Carlos Eduardo Ferreira',
                'email' => 'carlos.ferreira@empresa.com',
                'cpf' => '45678912301',
                'cargo' => 'Analista de Sistemas',
                'dataAdmissao' => '2023-06-01',
                'salario' => 7200.00,
                'status' => 'ativo'
            ],
            [
                'nome' => 'Ana Paula Mendes',
                'email' => 'ana.mendes@empresa.com',
                'cpf' => '78912345602',
                'cargo' => 'UX/UI Designer',
                'dataAdmissao' => '2023-08-20',
                'salario' => 6800.00,
                'status' => 'ativo'
            ],
            [
                'nome' => 'Roberto Lima Souza',
                'email' => 'roberto.lima@empresa.com',
                'cpf' => '32165498703',
                'cargo' => 'DevOps Engineer',
                'dataAdmissao' => '2022-11-05',
                'salario' => 9500.00,
                'status' => 'ativo'
            ]
        ];

        // Cria cada funcionário no banco de dados.
        foreach ($funcionarios as $funcionario) {
            Funcionario::create($funcionario);
        }
    }
}
