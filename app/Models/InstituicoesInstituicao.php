<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstituicoesInstituicao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'instituicoes_instituicoes';
}
