<?php

namespace App\Services\ServicesCongregados;

use App\Exceptions\MembroNotFoundException;
use App\Models\MembresiaContato;
use App\Models\MembresiaCurso;
use App\Models\MembresiaFormacao;
use App\Models\MembresiaFuncaoEclesiastica;
use App\Models\MembresiaMembro;
use App\Models\MembresiaSetor;

class TornarCongregadoService
{

    public function execute($id): void
    {
    }

    public function findOne($id)
    {
        //With trazer relacionamentos definidos do model MembresiaMembro de forma prévia
        $pessoa = MembresiaMembro::with(['contato', 'funcoesMinisteriais', 'familiar', 'formacoesEclesiasticas'])
            ->where('id', $id)
            ->whereIn('vinculo', [MembresiaMembro::VINCULO_VISITANTE, MembresiaMembro::VINCLULO_CONGREGADO])
            ->firstOr(function () { throw new MembroNotFoundException('Visitante não encontrado', 404); });

        //Somente buscar informações do campo select
        $ministerios = MembresiaSetor::orderBy('descricao', 'asc')->get();
        $funcoes = MembresiaFuncaoEclesiastica::orderBy('descricao', 'asc')->get();
        $cursos = MembresiaCurso::orderBy('nome', 'asc')->get();
        $formacoes = MembresiaFormacao::orderBy('descricao', 'asc')->get();
        $funcoesEclesiasticas = MembresiaFuncaoEclesiastica::orderBy('descricao', 'asc')->get();

        return [
            'pessoa'               => $pessoa,
            'ministerios'          => $ministerios,
            'funcoes'              => $funcoes,
            'cursos'               => $cursos,
            'formacoes'            => $formacoes,
            'funcoesEclesiasticas' => $funcoesEclesiasticas,
        ];
    }
}
