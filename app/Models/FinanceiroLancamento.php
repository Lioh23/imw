<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroLancamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financeiro_lancamentos';

    public function tipoPaganteFavorecido()
    {
        return $this->belongsTo(FinanceiroTipoPaganteFavorecido::class, 'tipo_pagante_favorecido_id');
    }
}
