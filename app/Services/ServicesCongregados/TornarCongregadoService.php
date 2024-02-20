<?php

namespace App\Services\ServicesCongregados;

use App\Exceptions\MembroNotFoundException;
use App\Models\MembresiaContato;
use App\Models\MembresiaCurso;
use App\Models\MembresiaFuncaoEclesiastica;
use App\Models\MembresiaMembro;
use App\Models\MembresiaSetor;

class TornarCongregadoService
{

    public function execute(array $data): void
    {
        $dataMembro = [
            'nome'            => $data['nome'],
            'sexo'            => $data['sexo'],
            'data_nascimento' => $data['data_nascimento'],
            'data_conversao'  => $data['data_conversao'],
            'vinculo'         => MembresiaMembro::VINCULO_CONGREGADO,
            'status'          => 'A', // ATIVO
        ];

        $dataContato = [
            'telefone_preferencial' => preg_replace('/[^0-9]/', '', $data['telefone_preferencial']),
            'telefone_alternativo'  => preg_replace('/[^0-9]/', '', $data['telefone_alternativo']),
            'telefone_whatsapp'     => preg_replace('/[^0-9]/', '', $data['telefone_whatsapp']),
            'email_preferencial'     => $data['email_preferencial'],
            'email_alternativo'     => $data['email_alternativo'],
        ];
    }

    public function findOne($id)
    {
        //With trazer relacionamentos definidos do model MembresiaMembro de forma prévia
        $pessoa = MembresiaMembro::with(['contato', 'funcoesMinisteriais', 'familiar', 'formacoesEclesiasticas'])
            ->where('id', $id)
            ->whereIn('vinculo', [MembresiaMembro::VINCULO_VISITANTE, MembresiaMembro::VINCULO_CONGREGADO])
            ->firstOr(function () { throw new MembroNotFoundException('Visitante não encontrado', 404); });

        //Somente buscar informações do campo select
        $ministerios = MembresiaSetor::orderBy('descricao', 'asc')->get();
        $funcoes = MembresiaFuncaoEclesiastica::orderBy('descricao', 'asc')->get();
        $cursos = MembresiaCurso::orderBy('nome', 'asc')->get();

        return [
            'pessoa' => $pessoa,
            'ministerios' => $ministerios,
            'funcoes' => $funcoes,
            'cursos' => $cursos
        ];
    }
}
