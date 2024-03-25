<?php 

namespace App\Services\ServiceImportacao;

use App\Traits\CsvImportUtils;

class ImportacaoService
{
    use CsvImportUtils;

    public static function instituicoes($collectOld, $controle)
    {   
        $collection = $collectOld->map(function ($item) {
                return [
                    "id"                  => $item["id"],
                    "nome"                => $item["nome"],
                    "tipo_instituicao_id" => $item["tipo_instituicao_id"],
                    "instituicao_pai_id"  => $item["instituicao_pai_id"],
                    "codigo_host"         => $item["codigo_host"],
                    "ativo"               => $item["ativo"],
                    "bairro"              => $item["bairro"],
                    "caw"                 => $item["caw"],
                    "cep"                 => $item["cep"],
                    "cidade"              => $item["cidade"],
                    "cnpj"                => $item["cnpj"],
                    "complemento"         => $item["complemento"],
                    "data_abertura"       => CsvImportUtils::formatDateToImport($item["data_abertura"]),
                    "ddd"                 => $item["ddd"],
                    "email"               => $item["email"],
                    "endereco"            => $item["endereco"],
                    "inss"                => $item["inss"],
                    "nome_fantasia"       => $item["nome_fantasia"],
                    "numero"              => $item["numero"],
                    "pais"                => $item["pais"],
                    "site"                => $item["site"],
                    "telefone"            => $item["telefone"],
                    "uf"                  => $item["uf"],
                    "pastor"              => $item["pastor"],
                    "tesoureiro"          => $item["tesoureiro"],
                    "created_at"          => substr($item["cadastrado_em"], 0, 19),
                    "updated_at"          => substr($item["modificado_em"], 0, 19),
                    "deleted_at"          => $item["excluido"] == "true" ? "2001-01-01 00:00:00" : null
                ];
            });

        return CsvImportUtils::import($collection, $controle);
    }

    public static function congregacoes($collectOld, $controle)
    {
        $collection = $collectOld->map(function ($item) {
            return [
                "id"                  => $item["id"],
                'nome'                => $item['nome'],
                'instituicao_id'      => $item['instituicao_id'],
                'ativo'               => $item['ativo'],
                'bairro'              => $item['bairro'],
                'cep'                 => $item['cep'],
                'cidade'              => $item['cidade'],
                'codigo_host'         => $item['codigo_host'],
                'codigo_host_igreja'  => $item['codigo_host_igreja'],
                'complemento'         => $item['complemento'],
                'data_abertura'       => CsvImportUtils::formatDateToImport($item['data_abertura']),
                'ddd'                 => $item['ddd'],
                'email'               => $item['email'],
                'endereco'            => $item['endereco'],
                'host_dirigente'      => $item['host_dirigente'],
                'numero'              => $item['numero'],
                'pais'                => $item['pais'],
                'site'                => $item['site'],
                'telefone'            => $item['telefone'],
                'uf'                  => $item['uf'],
                'data_extincao'       => CsvImportUtils::formatDateToImport($item['data_extincao']),
                "created_at"          => substr($item["cadastrado_em"], 0, 19),
                "updated_at"          => substr($item["modificado_em"], 0, 19),
                "deleted_at"          => $item["excluido"] == "true" ? "2001-01-01 00:00:00" : null
            ];
        });

        return CsvImportUtils::import($collection, $controle);
    }

    public static function planoContas($collectOld, $controle)
    {
        $collection = $collectOld->map(function ($item) {
            return [
                "id"                  => $item["id"],
                'nome'                => $item['nome'],
                'posicao'             => $item['posicao'],
                'numeracao'           => $item['numeracao'],
                'tipo'                => $item['tipo'],
                'conta_pai_id'        => $item['conta_pai_id'],
                'selecionavel'        => $item['selecionavel'],
                'essencial'           => $item['essencial'],
                "created_at"          => substr($item["cadastrado_em"], 0, 19),
                "updated_at"          => substr($item["modificado_em"], 0, 19),
                "deleted_at"          => $item["excluido"] == "true" ? "2001-01-01 00:00:00" : null
            ];
        });
        
        return CsvImportUtils::import($collection, $controle);
    }
}

