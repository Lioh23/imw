<?php 

namespace App\Services\ServicePerfil;

use App\Dtos\SessionInstituicoesDto;
use App\Exceptions\TipoInstituicaoNotFoundException;
use App\Models\InstituicoesInstituicao;

class IdentificaPerfilService
{
    public function execute($instituicaoId, $instituicaoNome, $perfilId, $perfilNome)
    {
        return (object) [
            'instituicao_id'   => $instituicaoId,
            'instituicao_nome' => $instituicaoNome,
            'perfil_id'        => $perfilId,
            'perfil_nome'      => $perfilNome,
            'instituicoes'     => $this->fetchSessionIstituicoes(new SessionInstituicoesDto(), $instituicaoId)
        ];
    }

    private function fetchSessionIstituicoes(SessionInstituicoesDto $dto, $instituicaoId)
    {
        $instituicao = InstituicoesInstituicao::findOr($instituicaoId, fn() => throw new TipoInstituicaoNotFoundException());
        $tipoInstituicao = $dto->getField($instituicao->tipo_instituicao_id);
        $dto->{$tipoInstituicao} = $instituicao;
        
        if($instituicao->instituicao_pai_id) 
            return $this->fetchSessionIstituicoes($dto, $instituicao->instituicao_pai_id);

        return $dto;
    }
}
