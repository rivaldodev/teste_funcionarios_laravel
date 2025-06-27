# Sistema de Cadastro de Funcionários

Este projeto é um sistema simples e direto para cadastro e gestão de funcionários, feito com Laravel e Alpine.js. O objetivo é ser fácil de rodar, fácil de entender e útil para quem precisa de um CRUD funcional e moderno.

## Funcionalidades

- Cadastro, edição e inativação/reativação de funcionários
- Filtros por nome, email, CPF, cargo e status
- Validação de dados (CPF e email únicos)
- Interface responsiva (Bootstrap 5)
- Formatação automática de CPF, datas e salários
- Mensagens de sucesso e erro em tempo real
- Modal para cadastro/edição
- Confirmação para ações destrutivas

## Tecnologias

- **Backend:** Laravel 12.x (PHP 8.1+)
- **Frontend:** Alpine.js 3.x, Bootstrap 5.3
- **Banco de Dados:** MySQL 8+
- **Outros:** Composer, XAMPP, Font Awesome

## Pré-requisitos

- XAMPP com Apache e MySQL ativos
- PHP 8.1 ou superior
- Composer instalado

## Como rodar o projeto

### 1. Baixe o projeto

Clone ou baixe o repositório e coloque em `c:\xampp\htdocs\teste_tecnico\sistema-funcionarios`.

```bash
cd c:\xampp\htdocs\teste_tecnico\sistema-funcionarios
```

### 2. Instale as dependências

```bash
composer install
```

### 3. Configure o banco de dados

- Crie um banco chamado `sistema_funcionarios` no MySQL.
- O arquivo `.env` já está pronto para XAMPP (usuário root, sem senha):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_funcionarios
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Rode as migrations e seeders

```bash
php artisan migrate --seed
```

### 5. Inicie o servidor

```bash
php artisan serve
```

Acesse em: [http://localhost:8000](http://localhost:8000)

## Estrutura da tabela `funcionarios`

| Coluna         | Tipo                      | Detalhes                        |
| -------------- | ------------------------- | ------------------------------- |
| id             | BIGINT UNSIGNED           | Chave primária auto-incremental |
| nome           | VARCHAR(150)              | Obrigatório                     |
| email          | VARCHAR(150)              | Obrigatório, único              |
| cpf            | VARCHAR(11)               | Obrigatório, único              |
| cargo          | VARCHAR(100)              | Opcional                        |
| dataAdmissao   | DATE                      | Opcional                        |
| salario        | DECIMAL(10,2)             | Opcional                        |
| status         | ENUM('ativo','inativo')   | Padrão: 'ativo'                 |
| created_at     | TIMESTAMP                 |                                 |
| updated_at     | TIMESTAMP                 |                                 |

> **Nota:** Ao "excluir" um funcionário, ele apenas muda para status `inativo` (soft delete). Você pode reativar a qualquer momento.

## Comandos úteis

```bash
# Resetar e popular o banco de dados
php artisan migrate:fresh --seed

# Limpar caches do Laravel
php artisan optimize:clear

# Ver rotas
php artisan route:list
```

## Dicas rápidas

- Para acessar o phpMyAdmin: http://localhost/phpmyadmin
- Para resetar o banco rapidamente: `reset-banco.bat`
- Para iniciar tudo de uma vez (Windows): `iniciar.bat`

## Estrutura do projeto

```
sistema-funcionarios/
├── app/
│   ├── Http/Controllers/FuncionarioController.php
│   └── Models/Funcionario.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── layouts/app.blade.php
│   └── funcionarios/index.blade.php
├── routes/web.php
├── iniciar.bat
├── reset-banco.bat
└── README.md
```

## Sobre

Este sistema foi feito pensando em clareza, simplicidade e boas práticas. O código é limpo, sem comentários desnecessários, e a interface é amigável. Se quiser adaptar, fique à vontade!

---

**Desenvolvido por Rivaldo Freitas de Carvalho para fins de avaliação técnica.**
