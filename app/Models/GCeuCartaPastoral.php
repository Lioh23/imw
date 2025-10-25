<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GCeuCartaPastoral extends Model
{
    use HasFactory, SoftDeletes;

     // status
    const STATUS_ATIVO = 'A';
    const STATUS_INATIVO = 'I';

    protected $table = 'gceu_cartas_pastorais';
    protected $guarded = [];
}
