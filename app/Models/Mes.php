<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Mes extends Model
{
    use HasFactory;

    protected $table = 'meses';

    protected $fillable = [
        'id', 'descricao'
    ];
}
