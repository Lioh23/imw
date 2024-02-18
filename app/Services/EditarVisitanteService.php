<?php

namespace App\Services;

use App\Models\MembresiaContato;
use App\Models\MembresiaMembro;

class EditarVisitanteService
{
    public function execute($id, array $data): void
    {
        $visitante = MembresiaMembro::findOrFail($id);
        $visitante->update([
            'nome'            => $data['nome'],
            'sexo'            => $data['sexo'],
            'data_nascimento' => $data['data_nascimento'],
            'data_conversao'  => $data['data_conversao']
        ]);

        $contato = MembresiaContato::where('membro_id', $id)->first();
        if ($contato) {
            $contato->update([
                'telefone_preferencial' => preg_replace('/[^0-9]/', '', $data['telefone_preferencial']),
                'telefone_alternativo'  => preg_replace('/[^0-9]/', '', $data['telefone_alternativo']),
                'telefone_whatsapp'     => preg_replace('/[^0-9]/', '', $data['telefone_whatsapp']),
                'email_preferencial'    => $data['email_preferencial'],
                'email_alternativo'     => $data['email_alternativo'],
            ]);
        }
    }

    public function listOne($id): ?MembresiaMembro
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
