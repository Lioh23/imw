<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\Anexo;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BuscarAnexosServices
{

    public function execute($id)
    {
        $anexos = Anexo::where('lancamento_id', $id)->get();
    
        $anexosArray = $anexos->map(function($anexo) {
            try {
                // Gerar a URL temporária usando o Storage do Laravel
                $disk = Storage::disk('s3');
                $presignedUrl = $disk->temporaryUrl('anexos/' . $anexo->nome, Carbon::now()->addMinutes(20));
        
                return [
                    'url' => $presignedUrl,
                    'nome' => $anexo->descricao
                ];
            } catch (\Exception $e) {
                \Log::error('Erro ao gerar URL assinada para o anexo ' . $anexo->nome . ': ' . $e->getMessage());
                return [
                    'error' => 'Erro ao gerar URL assinada para o anexo ' . $anexo->nome
                ];
            }
        });
    
        return $anexosArray;
    }
}