<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 
        'caminho',
        'descricao',
        'lancamento_id',
    ];

    public function getMimeAttribute()
    {
        return collect(explode('.', $this->caminho))->last();
    }
}
