<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstituicoesTipoInstituicao extends Model
{
    use HasFactory, SoftDeletes;

    const IGREJA_GERAL = 6;
    const REGIAO = 3;
    const CONTABILIDADE = 11;
    const ESTATISTICA = 14;
    const ORGAO_GERAL = 8;
    const SECRETARIA = 9;
    const DISTRITO = 2;
    const IGREJA_LOCAL = 1;
    const CONGREGACAO = 13;

    protected $table = 'instituicoes_tiposinstituicao';

    protected $fillable = ['nome', 'cor', 'sigla', 'hierarquia'];

    public function instituicoes()
    {
        return $this->hasMany(InstituicoesInstituicao::class, 'tipo_instituicao_id');
    }
}
