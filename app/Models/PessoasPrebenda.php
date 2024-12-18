<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoasPrebenda extends Model
{
    use HasFactory;

    protected $table = 'pessoas_prebendas';

    protected $fillable = [
        'pessoa_id',
        'ano',
        'valor'

    ];

    public function pessoas()
    {
        return $this->belongsTo(PessoasPessoa::class, 'pessoa_id');
    }

    public function nomeacoes()
    {
        return $this->hasManyThrough(
            PessoaNomeacao::class,
            PessoasPessoa::class,
            'id',
            'pessoa_id',
            'pessoa_id',
            'id'
        );
    }
}
