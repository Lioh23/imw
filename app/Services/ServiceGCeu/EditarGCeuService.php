<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Traits\Identifiable;

class EditarGCeuService
{
    public function execute($id, array $data): void
    {
        $gceu = GCeu::findOrFail($id);
        $congregacaoId = $data['congregacao_id'] == 'sede' ? null : $data['congregacao_id'];
        $contato = preg_replace('/[^0-9]/', '', $data['contato']);
        $gceu->update([
            'nome' => $data['nome'],
            'anfitriao' => $data['anfitriao'],
            'email' => $data['email'],
            'contato' => $contato,
            'congregacao_id' => $congregacaoId,
            'instituicao_id' => Identifiable::fetchSessionIgrejaLocal()->id,
            'cep' => $data['cep'],
            'endereco' => $data['endereco'],
            'numero' => $data['numero'],
            'bairro' => $data['bairro'],
            'cidade' => $data['cidade'],
            'uf' => $data['estado'],
        ]);
    }

    public function findOne($id): ?GCeu
    {
        $gceu = GCeu::where('id', $id)->first();

        return $gceu;
    }
}
