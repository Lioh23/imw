<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaIr extends Model
{
    use HasFactory;

    protected $table = 'tabelas_ir';

    protected $fillable = [
        'ano',
        'faixa',
        'deducao_faixa',
        'valor_min',
        'valor_max',
        'aliquota',
        'deducao',
    ];
}
