<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwEstatisticaEscolaridade extends Model
{
    use HasFactory;

    protected $table = 'vw_estatistica_escolidade';

    protected $casts = [
        'total' => 'integer',
    ];
}
