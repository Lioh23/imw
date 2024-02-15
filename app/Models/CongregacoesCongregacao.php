<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CongregacoesCongregacao extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'congregacoes_congregacoes';

    protected $fillable = [
        'nome',
        'instituicao_id',
        'ativo',
        'bairro',
        'cep',
        'cidade',
        'codigo_host',
        'codigo_host_igreja',
        'complemento',
        'data_abertura',
        'ddd',
        'email',
        'endereco',
        'host_dirigente',
        'numero',
        'pais',
        'site',
        'telefone',
        'uf',
        'data_extincao',
    ];
}
