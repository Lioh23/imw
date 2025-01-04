<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PessoaFuncaoministerial extends Model
{
    protected $table = 'pessoas_funcaoministerial';

    protected $fillable = [
        'funcao',
        'ordem',
        'titulo',
        'excluido',
        'qtd_prebendas',
    ];

    // Relacionamento inverso com PessoaNomeacao
    public function nomeacoes()
    {
        return $this->hasMany(PessoaNomeacao::class, 'funcao_ministerial_id', 'id');
    }
}
