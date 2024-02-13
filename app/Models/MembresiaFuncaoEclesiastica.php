<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaFuncaoeclesiastica extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'membresia_funcoeseclesiasticas';

    protected $fillable = ['descricao', 'titulo', 'ordem'];
}
