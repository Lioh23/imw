<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoasPessoa;
use Carbon\Carbon;

class StoreClerigosService
{
    public function execute($request)
    {
        $data_emissao = Carbon::createFromFormat('d/m/Y', $request->input('data_emissao'))->format('Y-m-d');
        $pispasep_emissao = Carbon::createFromFormat('d/m/Y', $request->input('pispasep_emissao'))->format('Y-m-d');
        $data = $request->safe()->only([
            'tipo',
            'nome',
            'identidade',
            'orgao_emissor',
            $data_emissao,
            'cpf',
            'endereco',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'uf',
            'pais',
            'cep',
            'email',
            'estado_civil',
            'regiao_id',
            'sexo',
            'formacao_id',
            'nome_mae',
            'nome_pai',
            'telefone_preferencial',
            'ctps',
            'ctps_emissao',
            'habilitacao',
            'habilitacao_categoria',
            'habilitacao_emissor',
            'habilitacao_uf',
            'identidade_uf',
            'pispasep',
            $pispasep_emissao,
            'residencia_propria',
            'residencia_propria_fgts',
            'titulo_eleitor',
            'titulo_eleitor_secao',
            'titulo_eleitor_zona',
            'categoria',
        ]);

        PessoasPessoa::create($data);
      
    }
}
