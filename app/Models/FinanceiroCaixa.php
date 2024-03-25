<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroCaixa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financeiro_caixas';

    protected $fillable = ['descricao', 'instituicao_id', 'tipo'];
}
