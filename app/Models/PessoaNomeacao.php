<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PessoaNomeacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pessoas_nomeacoes';

    protected $fillable = [
        'codigo_host',
        'data_nomeacao',
        'hist_distrito_id',
        'hist_geral_id',
        'hist_igreja_id',
        'hist_orgao_id',
        'hist_regiao_id',
        'hist_secretaria_id',
        'instituicao_id',
        'pessoa_id',
        'funcao_ministerial_id'
    ];

    public function pessoa()
    {
        return $this->belongsTo(PessoasPessoa::class, 'pessoa_id', 'id');
    }
}
