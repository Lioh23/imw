<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaFormacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'membresia_formacoes';

    protected $fillable = ['descricao'];
}
