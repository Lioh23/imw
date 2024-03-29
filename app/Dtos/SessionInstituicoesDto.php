<?php

namespace App\Dtos;

use App\Exceptions\TipoInstituicaoNotFoundException;
use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;

class SessionInstituicoesDto
{
    public $igrejaGeral;
    public $regiao;
    public $contabilidade;
    public $estatistica;
    public $orgaoGeral;
    public $secretaria;
    public $distrito;
    public $igrejaLocal;

    public function getField($tipoInstituicao)
    {
        switch ($tipoInstituicao) {
            case InstituicoesTipoInstituicao::IGREJA_GERAL:
                return 'igrejaGeral';
                
            case InstituicoesTipoInstituicao::REGIAO:
                return 'regiao';
                
            case InstituicoesTipoInstituicao::CONTABILIDADE:
                return 'contabilidade';
                
            case InstituicoesTipoInstituicao::ESTATISTICA:
                return 'estatistica';
                
            case InstituicoesTipoInstituicao::ORGAO_GERAL:
                return 'orgaoGeral';
                
            case InstituicoesTipoInstituicao::SECRETARIA:
                return 'secretaria';
                
            case InstituicoesTipoInstituicao::DISTRITO:
                return 'distrito';
                
            case InstituicoesTipoInstituicao::IGREJA_LOCAL:
                return 'igrejaLocal';
                
            default:
                throw new TipoInstituicaoNotFoundException('Tipo de instituição inexistente');
        }   
    }
}