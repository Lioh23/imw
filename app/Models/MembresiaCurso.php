<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaCurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'membresia_cursos';

    protected $fillable = ['nome', 'descricao'];
}
