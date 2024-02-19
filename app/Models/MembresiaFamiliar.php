<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaFamiliar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'membresia_familiares';

    protected $fillable = [
        'mae_nome', 
        'pai_nome', 
        'conjuge_nome',
        'data_casamento',
        'filhos',
        'historico_familiar',
        'membro_id'
    ];
}
