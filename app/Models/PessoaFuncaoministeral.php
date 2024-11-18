<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaFuncaoministeral extends Model
{
    use HasFactory;

    protected $table = 'pessoas_funcaoministerial';

    protected $fillable = [
        'excluido',
        'funcao',
        'ordem',
        'titulo'
    ];
}
