<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Models\GCeuMembros;
use App\Traits\Identifiable;
use Illuminate\Support\Facades\DB;

class GCeuDiarioService
{
    public function getList($id, $data): array
    {
        $date = isset($data['dt_gceu']) ? $data['dt_gceu'] :  '';
        $Gceus = GCeu::where(['instituicao_id' => $id])->get();
        $data['Gceus'] = $Gceus;
        $data['instituicao'] = Identifiable::fetchSessionIgrejaLocal()->nome;
        $data['instituicao_id'] = Identifiable::fetchSessionIgrejaLocal()->id;
        $gceuId = isset($data['gceu_id']) ? $data['gceu_id'] : '';
        if($gceuId){
            $data['membros'] = GCeuMembros::select('gceu_membros.gceu_cadastro_id as gceu_id','gceu_membros.membro_id', 'membresia_membros.nome', DB::raw("(SELECT presenca FROM gceu_diario WHERE gceu_id = $gceuId AND membro_id = gceu_membros.membro_id AND data ='$date') presenca"))
                    ->join('membresia_membros', 'membresia_membros.id', 'gceu_membros.membro_id')
                    ->where(['gceu_membros.gceu_cadastro_id' => $gceuId])
                    ->groupBy(['gceu_membros.gceu_cadastro_id','gceu_membros.membro_id', 'membresia_membros.nome'])->get();
        }else{
            $data['membros'] = [];
        }
        return $data;
    }
}