<?php

namespace App\Services\ServiceMembrosGeral;

use App\Exceptions\MembroNotFoundException;
use App\Models\MembresiaCurso;
use App\Models\MembresiaFormacao;
use App\Models\MembresiaFuncaoEclesiastica;
use App\Models\MembresiaMembro;
use App\Models\MembresiaSetor;
use App\Models\MembresiaTipoAtuacao;
use App\Traits\Identifiable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class EditarMembroService
{
    use Identifiable;

    public function findOne($id)
    {
        $pessoa = MembresiaMembro::with(['contato', 'funcoesMinisteriais', 'familiar', 'formacoesEclesiasticas', 'notificacaoTransferenciaAtiva'])
            ->where('id', $id)
            ->firstOr(function () {
                throw new MembroNotFoundException('Registro não encontrado', 404);
            });

        // Gerar URL temporária para a foto se estiver presente e o bucket for privado
        if ($pessoa->foto) {
            $disk = Storage::disk('s3');
            $pessoa->foto = $disk->temporaryUrl($pessoa->foto, Carbon::now()->addMinutes(15));
        }


        $ministerios = MembresiaSetor::orderBy('descricao', 'asc')->get();
        $funcoes = MembresiaTipoAtuacao::orderBy('descricao', 'asc')->get();
        $cursos = MembresiaCurso::orderBy('nome', 'asc')->get();
        $formacoes = MembresiaFormacao::orderBy('id', 'asc')->get();
        $funcoesEclesiasticas = MembresiaFuncaoEclesiastica::orderBy('descricao', 'asc')->get();

        return [
            'pessoa'               => $pessoa,
            'ministerios'          => $ministerios,
            'funcoes'              => $funcoes,
            'cursos'               => $cursos,
            'formacoes'            => $formacoes,
            'funcoesEclesiasticas' => $funcoesEclesiasticas,
            'congregacoes'         => Identifiable::fetchCongregacoes()
        ];
    }
}
