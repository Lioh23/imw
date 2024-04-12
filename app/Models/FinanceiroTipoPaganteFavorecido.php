<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroTipoPaganteFavorecido extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financeiro_tipos_pagantes_favorecidos';
}
