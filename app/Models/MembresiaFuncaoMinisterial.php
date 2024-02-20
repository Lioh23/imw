<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaFuncaoMinisterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'membresia_funcoesministeriais';
    protected $fillable = [
        'data_entrada',
        'data_saida',
        'observacoes',
        'membro_id',
        'setor_id',
        'tipoatuacao_id',
    ];
}
