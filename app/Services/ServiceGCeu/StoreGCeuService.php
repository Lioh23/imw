<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Traits\Identifiable;

class StoreGCeuService
{
    use Identifiable;

    public function execute(array $data): void
    {
        $contato = preg_replace('/[^0-9]/', '', $data['contato']);
        $dataGCeu = [
            'nome' => $data['nome'],
            'anfitriao' => $data['anfitriao'],
            'email' => $data['email'],
            'contato' => $contato,
            'congregacao_id' => $data['congregacao_id'],
            'instituicao_id' => Identifiable::fetchSessionIgrejaLocal()->id,
            'cep' => $data['cep'],
            'endereco' => $data['endereco'],
            'numero' => $data['numero'],
            'bairro' => $data['bairro'],
            'cidade' => $data['cidade'],
            'uf' => $data['estado'],
            'data_de_criacao' => date('Y-m-d')
        ];

        $gceuId = $this->handleStoreGCeu($dataGCeu);
    }

    private function handleStoreGCeu($dataGCeu)
    {
        $gceu = GCeu::create($dataGCeu);
    }
}
