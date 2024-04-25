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

    public static function pessoasStatus($collectOld, $controle)
    {
        $collection = $collectOld->map(function ($item) {
            return [
                "id"          => $item["id"],
                'descricao'   => $item['descricao'],
                'codigo'      => $item['codigo'],
                "created_at"  => substr($item["cadastrado_em"], 0, 19),
                "updated_at"  => substr($item["modificado_em"], 0, 19),
                "deleted_at"  => $item["excluido"] == "true" ? "2001-01-01 00:00:00" : null
            ];
        });
        
        return CsvImportUtils::import($collection, $controle);
    }

    public static function pessoasPessoas($collectOld, $controle)
    {
        $collection = $collectOld->map(function ($item) {
            return [
                'id'                      => $item['id'],
                'codigo_host'             => $item['codigo_host'],
                'tipo'                    => $item['tipo'],
                'nome'                    => $item['nome'],
                'status'                  => $item['status'],
                'foto'                    => $item['foto'],
                'identidade'              => $item['identidade'],
                'orgao_emissor'           => $item['orgao_emissor'],
                'data_emissao'            => CsvImportUtils::formatDateToImport($item['data_emissao']),
                'cpf'                     => $item['cpf'],
                'inss'                    => $item['inss'],
                'endereco'                => $item['endereco'],
                'numero'                  => $item['numero'],
                'complemento'             => $item['complemento'],
                'bairro'                  => $item['bairro'],
                'cidade'                  => $item['cidade'],
                'uf'                      => $item['uf'],
                'pais'                    => $item['pais'],
                'cep'                     => $item['cep'],
                'email'                   => $item['email'],
                'estado_civil'            => $item['estado_civil'],
                'data_nascimento'         => CsvImportUtils::formatDateToImport($item['data_nascimento']),
                'situacao_id'             => $item['situacao_id'],
                'distrito_id'             => $item['distrito_id'],
                'igreja_id'               => $item['igreja_id'],
                'regiao_id'               => $item['regiao_id'],
                'sexo'                    => $item['sexo'],
                'raca'                    => $item['raca'],
                'escolaridade'            => $item['escolaridade'],
                'natural_cidade'          => $item['natural_cidade'],
                'natural_uf'              => $item['natural_uf'],
                'nome_conjuge'            => $item['nome_conjuge'],
                'nome_mae'                => $item['nome_mae'],
                'nome_pai'                => $item['nome_pai'],
                'telefone_alternativo'    => $item['telefone_alternativo'],
                'telefone_preferencial'   => $item['telefone_preferencial'],
                'certidao_civil'          => preg_replace('/[^0-9]/', '', $item['certidao_civil']),
                'ctps'                    => $item['ctps'],
                'ctps_emissao'            => CsvImportUtils::formatDateToImport($item['ctps_emissao']),
                'habilitacao'             => $item['habilitacao'],
                'habilitacao_categoria'   => $item['habilitacao_categoria'],
                'habilitacao_emissor'     => $item['habilitacao_emissor'],
                'habilitacao_uf'          => $item['habilitacao_uf'],
                'identidade_uf'           => $item['identidade_uf'],
                'pispasep'                => $item['pispasep'],
                'pispasep_emissao'        => CsvImportUtils::formatDateToImport($item['pispasep_emissao']),
                'reservista'              => $item['reservista'],
                'reservista_secao'        => $item['reservista_secao'],
                'reservista_serie'        => $item['reservista_serie'],
                'residencia_propria'      => $item['residencia_propria'],
                'residencia_propria_fgts' => $item['residencia_propria_fgts'],
                'titulo_eleitor'          => $item['titulo_eleitor'],
                'titulo_eleitor_secao'    => $item['titulo_eleitor_secao'],
                'titulo_eleitor_zona'     => $item['titulo_eleitor_zona'],
                'ficha_completa_ok'       => $item['ficha_completa_ok'],
                'ficha_skip'              => $item['ficha_skip'],
                'isento_pis'              => $item['isento_pis'],
                'isento_reservista'       => $item['isento_reservista'],
                'isento_titulo_eleitor'   => $item['isento_titulo_eleitor'],
                'created_at'              => substr($item["cadastrado_em"], 0, 19),
                'updated_at'              => substr($item["modificado_em"], 0, 19),
                'deleted_at'              => $item["excluido"] == "true" ? "2001-01-01 00:00:00" : null
            ];
        });   

        return CsvImportUtils::import($collection, $controle);
    }

    public static function pessoasNomeacoes($collectOld, $controle)
    {
        $collection = $collectOld->map(function ($item) {
            return [
                'id'                    => $item['id'],
                'codigo_host'           => $item['codigo_host'],
                'data_nomeacao'         => CsvImportUtils::formatDateToImport($item['data_nomeacao']) ?? "2001-01-01 00:00:00",
                'data_termino'          => CsvImportUtils::formatDateToImport($item['data_termino']),
                'hist_distrito_id'      => $item['hist_distrito_id'],
                'hist_geral_id'         => $item['hist_geral_id'],
                'hist_igreja_id'        => $item['hist_igreja_id'],
                'hist_orgao_id'         => $item['hist_orgao_id'],
                'hist_regiao_id'        => $item['hist_regiao_id'],
                'hist_secretaria_id'    => $item['hist_secretaria_id'],
                'instituicao_id'        => $item['instituicao_id'],
                'pessoa_id'             => $item['pessoa_id'],
                'funcao_ministerial_id' => $item['funcao_ministerial_id'],
                'created_at'            => substr($item["cadastrado_em"], 0, 19),
                'updated_at'            => substr($item["modificado_em"], 0, 19),
                'deleted_at'            => $item["excluido"] == "true" ? "2001-01-01 00:00:00" : null
            ];
        });

        return CsvImportUtils::import($collection, $controle);
    }

    public static function financeiroCaixas($collectOld, $controle)
    {
        $collection = $collectOld->map(function ($item) {
            return [
                'id'             => $item['id'],
                'descricao'      => $item['descricao'],
                'instituicao_id' => $item['instituicao_id'],
                'tipo'           => $item['tipo'],
                'created_at'     => substr($item["cadastrado_em"], 0, 19),
                'updated_at'     => substr($item["modificado_em"], 0, 19),
                'deleted_at'     => $item["excluido"] == "true" ? "2001-01-01 00:00:00" : null
            ];
        });

        return CsvImportUtils::import($collection, $controle);
    }

    public static function financeiroSaldoConsolidadoMensal($collectOld, $controle)
    {
        $collection = $collectOld->map(function ($item) {
            return [
                'id'                         => $item['id'],

                'data_hora'                  => substr($item['data_hora'], 0, 19),
                'total_entradas'             => (double) str_ireplace(',', '.', $item['total_entradas']),
                'total_saidas'               => (double) str_ireplace(',', '.', $item['total_saidas']),
                'saldo_anterior'             => (double) str_ireplace(',', '.', $item['saldo_anterior']),
                'saldo_final'                => (double) str_ireplace(',', '.', $item['saldo_final']),
                'estorno'                    => $item['estorno'],
                'auditado'                   => $item['auditado'],
                'caixa_id'                   => $item['caixa_id'],
                'instituicao_id'             => $item['instituicao_id'],
                'ano'                        => $item['ano'],
                'mes'                        => $item['mes'],
                'total_transf_entradas'      => (double) str_replace(',', '.', $item['total_transf_entradas']),
                'total_transf_saidas'        => (double) str_replace(',', '.', $item['total_transf_saidas']),
                'aux_data_hora'              => $item['aux_data_hora'],
                'aux_saldo_anterior'         => (double) str_replace(',', '.', $item['aux_saldo_anterior']),
                'aux_saldo_final'            => (double) str_replace(',', '.', $item['aux_saldo_final']),
                'aux_total_entradas'         => (double) str_replace(',', '.', $item['aux_total_entradas']),
                'aux_total_saidas'           => (double) str_replace(',', '.', $item['aux_total_saidas']),
                'aux_total_transf_entradas'  => (double) str_replace(',', '.', $item['aux_total_transf_entradas']),
                'aux_total_transf_saidas'    => (double) str_replace(',', '.', $item['aux_total_transf_saidas']),
                'created_at'                 => substr($item["cadastrado_em"], 0, 19),
                'updated_at'                 => substr($item["modificado_em"], 0, 19),
                'deleted_at'                 => $item["excluido"] == "true" ? "2001-01-01 00:00:00" : null
            ];
        });

        return CsvImportUtils::import($collection, $controle);
    }
}

