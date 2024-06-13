<?php

namespace App\Services\ServiceVisitantes;

use App\Models\MembresiaContato;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use Carbon\Carbon;

class StoreVisitanteService
{
    use Identifiable;

    public function execute(array $data): void
    {
        $dataMembro = [
            'nome'            => $data['nome'],
            'sexo'            => $data['sexo'],
            'data_nascimento' => isset($data['data_nascimento']) ? Carbon::createFromFormat('Y-m-d', $data['data_nascimento']) : null,
            'data_conversao'  => $data['data_conversao'],
            'congregacao_id'  => $data['congregacao_id'],
            'vinculo'         => MembresiaMembro::VINCULO_VISITANTE,
            'status'          => MembresiaMembro::STATUS_ATIVO,
            ...Identifiable::fetchSessionInstituicoesStoreMembresia()
        ];

        $dataContato = [
            'telefone_preferencial' => preg_replace('/[^0-9]/', '', $data['telefone_preferencial']),
            'email_preferencial'    => $data['email_preferencial'],
        ];

        if (isset($data['email_alternativo'])) {
            $dataContato['email_alternativo'] = $data['email_alternativo'];
        }

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
