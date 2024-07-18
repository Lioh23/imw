<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroPlanoContaTipoInstituicao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financeiro_plano_conta_tipo_instituicao';

    protected $fillable = [
        'plano_conta_id',
        'tipo_instituicao_id',
    ];
}
