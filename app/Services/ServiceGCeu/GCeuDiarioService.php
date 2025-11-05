<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Models\GCeuMembros;
use App\Traits\Identifiable;

class GCeuDiarioService
{
    public function getList($id, $data): array
    {
        $Gceus = GCeu::where(['instituicao_id' => $id])->get();
        $data['Gceus'] = $Gceus;
        $data['instituicao'] = Identifiable::fetchSessionIgrejaLocal()->nome;
        $data['instituicao_id'] = Identifiable::fetchSessionIgrejaLocal()->id;
        if(isset($data['gceu_id'])){
            $data['membros'] = GCeuMembros::select('gceu_membros.gceu_cadastro_id as gceu_id','gceu_membros.membro_id', 'membresia_membros.nome')->join('membresia_membros', 'membresia_membros.id', 'gceu_membros.membro_id')->where(['gceu_membros.gceu_cadastro_id' => $data['gceu_id']])->groupBy(['gceu_membros.gceu_cadastro_id','gceu_membros.membro_id', 'membresia_membros.nome'])->get();
        }else{
            $data['membros'] = [];
        }
        return $data;
    }
}