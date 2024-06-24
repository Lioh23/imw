<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anexo extends Model
{
    use HasFactory, SoftDeletes;

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

    public function lancamento()
    {
        return $this->belongsTo(FinanceiroLancamento::class, 'lancamento_id');
    }
}
