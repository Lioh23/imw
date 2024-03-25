<?php

namespace App\Services\ServiceMembrosGeral;

use App\Exceptions\MembroNotFoundException;
use App\Models\MembresiaCurso;
use App\Models\MembresiaFormacao;
use App\Models\MembresiaFuncaoEclesiastica;
use App\Models\MembresiaMembro;
use App\Models\MembresiaRolPermanente;
use App\Models\MembresiaSetor;
use App\Models\MembresiaTipoAtuacao;
use Illuminate\Support\Facades\Storage;


class EditarMembroService
{
    public function findOne($id)
    {
        $pessoa = MembresiaMembro::with(['contato', 'funcoesMinisteriais', 'familiar', 'formacoesEclesiasticas'])
            ->where('id', $id)
            ->firstOr(function () {
                throw new MembroNotFoundException('Registro não encontrado', 404);
            });

        $ministerios = MembresiaSetor::orderBy('descricao', 'asc')->get();
        $funcoes = MembresiaTipoAtuacao::orderBy('descricao', 'asc')->get();
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
