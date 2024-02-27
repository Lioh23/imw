<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaDisciplina extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'membresia_disciplinas';

    protected $fillable = ['dt_inicio', 'dt_termino', 'modo_disciplina_id', 'pastor_id', 'observacao'];
}
