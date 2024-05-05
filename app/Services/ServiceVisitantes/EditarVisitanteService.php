<?php

namespace App\Services\ServiceVisitantes;

use App\Models\MembresiaContato;
use App\Models\MembresiaMembro;
use Carbon\Carbon;

class EditarVisitanteService
{
    public function execute($id, array $data): void
    {
        $visitante = MembresiaMembro::findOrFail($id);
        $visitante->update([
            'nome'            => $data['nome'],
            'sexo'            => $data['sexo'],
            'data_nascimento' => isset($data['data_nascimento']) ? Carbon::createFromFormat('Y-m-d', $data['data_nascimento']) : null,
            'congregacao_id'  => $data['congregacao_id'],
            'data_conversao'  => $data['data_conversao']
        ]);

        $contato = MembresiaContato::where('membro_id', $id)->first();
        if ($contato) {
            $updateData = [
                'telefone_preferencial' => preg_replace('/[^0-9]/', '', $data['telefone_preferencial']),
                'telefone_whatsapp'     => preg_replace('/[^0-9]/', '', $data['telefone_whatsapp']),
                'email_preferencial'    => $data['email_preferencial'],
            ];
        
            // Verifica se a chave 'email_alternativo' existe no array $data antes de adicioná-la aos dados de atualização
            if (array_key_exists('email_alternativo', $data)) {
                $updateData['email_alternativo'] = $data['email_alternativo'];
            }
        
            $contato->update($updateData);
        }
    }

    public function findOne($id): ?MembresiaMembro
    {
        $visitante = MembresiaMembro::select(
            'membresia_membros.*',
            'membresia_contatos.*'
        )
        ->join('membresia_contatos', 'membresia_membros.id', '=', 'membresia_contatos.membro_id')
        ->where('membresia_membros.id', $id)
        ->where('membresia_membros.vinculo', MembresiaMembro::VINCULO_VISITANTE)
        ->first();

        return $visitante;
    }
}
