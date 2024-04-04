<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroFornecedores extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financeiro_fornecedores';

    protected $fillable = [
        'cpfcnpj',
        'nome',
        'email',
        'site',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'pais',
        'telefone',
        'celular',
        'instituicao_id'
        ];      
}
