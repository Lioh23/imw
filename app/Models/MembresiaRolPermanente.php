<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaRolPermanente extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ATIVO = 'A';
    const STATUS_INATIVO = 'I';

    protected $table = 'membresia_rolpermanente';

    protected $fillable = [
        'status',
        'numero_rol',
        'codigo_host',
        'dt_recepcao',
        'dt_exclusao',
        'clerigo_id',
        'distrito_id',
        'igreja_id',
        'membro_id',
        'modo_exclusao_id',
        'modo_recepcao_id',
        'regiao_id',
        'congregacao_id'
    ];
}
