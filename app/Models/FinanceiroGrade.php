<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FinanceiroGrade extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $table = 'financeiro_grades';

    protected $fillable = [
        'ano',
        'jan',
        'fev',
        'mar',
        'abr',
        'mai',
        'jun',
        'jul',
        'ago',
        'set',
        'out',
        'nov',
        'dez',
        'o13',
        'distrito_id',
        'igreja_id',
        'membro_id',
        'regiao_id',
        'data_ano_mes'
    ];
}
