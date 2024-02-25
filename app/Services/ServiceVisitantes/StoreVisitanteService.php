<?php

namespace App\Services\ServiceVisitantes;

use App\Models\MembresiaContato;
use App\Models\MembresiaMembro;
use Illuminate\Support\Facades\Auth;

class StoreVisitanteService
{
    public function execute(array $data): void
    {

        $dataMembro = [
            'nome'            => $data['nome'],
            'sexo'            => $data['sexo'],
            'data_nascimento' => $data['data_nascimento'],
            'data_conversao'  => $data['data_conversao'],
            'vinculo'         => MembresiaMembro::VINCULO_VISITANTE,
            'status'          => 'A', // ATIVO
            'regiao_id'       => Auth::user()->regioes->first()->id,
            'distrito_id'     => Auth::user()->distritos->first()->id,
            'igreja_id'       => Auth::user()->igrejasLocais->first()->id,
        ];

        $dataContato = [
            'telefone_preferencial' => preg_replace('/[^0-9]/', '', $data['telefone_preferencial']),
            'telefone_alternativo'  => preg_replace('/[^0-9]/', '', $data['telefone_alternativo']),
            'telefone_whatsapp'     => preg_replace('/[^0-9]/', '', $data['telefone_whatsapp']),
            'email_preferencial'     => $data['email_preferencial'],
            'email_alternativo'     => $data['email_alternativo'],
        ];

        $membroId = $this->handleStoreMembro($dataMembro);
        $this->handleStoreContato($dataContato, $membroId);
    }

    private function handleStoreMembro($data): string
    {
        $membro = MembresiaMembro::create($data);
        
        return $membro->id;
    }

    private function handleStoreContato($data, $membroId)
    {
        $data['membro_id'] = $membroId;

        MembresiaContato::create($data);
    }
}
