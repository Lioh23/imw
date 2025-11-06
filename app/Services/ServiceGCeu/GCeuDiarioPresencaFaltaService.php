<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeuDiario;
use Illuminate\Support\Facades\Redirect;

class GCeuDiarioPresencaFaltaService
{
    public function salvarDiario($data)
    {
        $existeDiario = GCeuDiario::where([
                    'gceu_id' => $data['gceu_id'],
                    'membro_id' => $data['membro_id'],
                    'data' => $data['dt_gceu'],
                ])->first();
        if($existeDiario){
            GCeuDiario::where([
                'gceu_id' => $data['gceu_id'],
                'membro_id' => $data['membro_id'],
                'data' => $data['dt_gceu'],
            ])->update(['presenca' => $data['valor']]);
        }else{
            $diario = [
                'gceu_id' => $data['gceu_id'],
                'membro_id' => $data['membro_id'],
                'presenca' => $data['valor'],
                'data' => $data['dt_gceu'],
            ];
            GCeuDiario::create($diario);
        }
        return [];
        
    }
}