<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroPlanoConta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financeiro_plano_contas';

    protected $fillable = [
        'nome',
        'posicao',
        'numeracao',
        'tipo',
        'conta_pai_id',
        'selecionavel',
        'essencial',
    ];
}
