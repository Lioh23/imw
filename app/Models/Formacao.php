<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Formacao extends Model
{
    use HasFactory;

    protected $table = 'formacoes';

    protected $fillable = [
        'nivel',
    ];
}
