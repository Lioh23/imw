<?php

namespace App\Services\ServicesCongregados;

use App\Exceptions\MembroNotFoundException;
use App\Models\MembresiaContato;
use App\Models\MembresiaCurso;
use App\Models\MembresiaFamiliar;
use App\Models\MembresiaFormacao;
use App\Models\MembresiaFormacaoEclesiastica;
use App\Models\MembresiaFuncaoEclesiastica;
use App\Models\MembresiaFuncaoMinisterial;
use App\Models\MembresiaMembro;
use App\Models\MembresiaSetor;
use App\Models\MembresiaTipoAtuacao;
use Illuminate\Support\Facades\Storage;


class NovoCongregadoService
{

    public function execute()
    {
        $ministerios = MembresiaSetor::orderBy('descricao', 'asc')->get();
        $funcoes = MembresiaTipoAtuacao::orderBy('descricao', 'asc')->get();
        $cursos = MembresiaCurso::orderBy('nome', 'asc')->get();
        $formacoes = MembresiaFormacao::orderBy('descricao', 'asc')->get();
        $funcoesEclesiasticas = MembresiaFuncaoEclesiastica::orderBy('descricao', 'asc')->get();

        return [
            'ministerios'          => $ministerios,
            'funcoes'              => $funcoes,
            'cursos'               => $cursos,
            'formacoes'            => $formacoes,
            'funcoesEclesiasticas' => $funcoesEclesiasticas,
        ];
    }
}
