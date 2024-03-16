<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstituicoesInstituicao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'instituicoes_instituicoes';

    protected $fillable = [
        'nome',
        'tipo_instituicao_id',
        'instituicao_pai_id',
        'codigo_host',
        'ativo',
        'bairro',
        'caw',
        'cep',
        'cidade',
        'cnpj',
        'complemento',
        'data_abertura',
        'ddd',
        'email',
        'endereco',
        'inss',
        'nome_fantasia',
        'numero',
        'pais',
        'site',
        'telefone',
        'uf',
        'pastor',
        'tesoureiro'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'perfil_user')->withPivot('perfil_id');
    }

    public function perfils()
    {
        return $this->belongsToMany(Perfil::class, 'perfil_user')->withPivot('user_id');
    }

    public function tipoInstituicao()
    {
        return $this->belongsTo(InstituicoesTipoInstituicao::class, 'tipo_instituicao_id');
    }
}
