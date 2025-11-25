<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoasPessoa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DetalhesClerigoService
{
    public function execute($id)
    {
        // Busca o clerigo pelo ID
        $clerigo = PessoasPessoa::select('pessoas_pessoas.*', 'pessoas_status.descricao as situacao', 'formacoes.nivel as formacao')
            ->Leftjoin('pessoas_status', 'pessoas_status.id','pessoas_pessoas.situacao_id')
            ->Leftjoin('formacoes', 'formacoes.id','pessoas_pessoas.formacao_id')
            ->findOrFail($id);
        if ($clerigo->foto) {
            $disk = Storage::disk('s3');
            $clerigo->foto = $disk->temporaryUrl($clerigo->foto, Carbon::now()->addMinutes(15));
        }
        $clerigo->data_nascimento = formatDate($clerigo->data_nascimento);
        $clerigo->data_consagracao = formatDate($clerigo->data_consagracao);
        $clerigo->data_ordenacao = formatDate($clerigo->data_ordenacao);
        $clerigo->data_integralizacao = formatDate($clerigo->data_integralizacao);


        return $clerigo;
    }
}
