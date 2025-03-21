<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prebenda extends Model
{
    use HasFactory;

    protected $table = 'prebendas';

    protected $fillable = [
        'ano',
        'valor',
        'ativo'
    ];
}
