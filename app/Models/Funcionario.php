<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionarios';

    protected $fillable = [
        'nome',
        'email', 
        'cpf',
        'cargo',
        'dataAdmissao',
        'salario',
        'status'
    ];

    protected $casts = [
        'dataAdmissao' => 'date',
        'salario' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($funcionario) {
            if (empty($funcionario->status)) {
                $funcionario->status = 'ativo';
            }
        });
    }
}
