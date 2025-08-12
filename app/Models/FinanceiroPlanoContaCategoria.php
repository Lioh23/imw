<?php

namespace App\Models;

use App\Traits\Identifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroPlanoContaCategoria extends Model
{
    use HasFactory;

    protected $table = 'financeiro_plano_contas_categoria';

    protected $fillable = [
        'nome',
    ];
}
