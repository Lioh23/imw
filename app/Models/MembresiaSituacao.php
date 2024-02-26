<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaSituacao extends Model
{
    const TIPO_ADESAO = 'R';
    const TIPO_EXCLUSAO = 'E';
    const TIPO_DISCIPLINA = 'D';

    use HasFactory, SoftDeletes;

    protected $table = 'membresia_situacoes';

    protected $fillable = ['descricao', 'tipo', 'nome'];
}
