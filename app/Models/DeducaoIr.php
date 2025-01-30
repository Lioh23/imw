<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeducaoIr extends Model
{
    use HasFactory;

    protected $table = 'deducoes_ir';

    protected $fillable = [
        'ano',
        'tipo',
        'valor',
        'simplificado',
    ];

    protected $casts = [
        'ano'          => 'integer',
        'simplificado' => 'boolean',
        'valor'        => 'float',
    ];
}
