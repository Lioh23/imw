<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\Anexo;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class BuscarAnexosServices
{

    public function execute($id)
    {
        $anexos = Anexo::where('lancamento_id', $id)->get();
    
        $anexosArray = $anexos->map(function($anexo) {
            $credentials = new Credentials(
                env('MINIO_ACCESS_KEY'),
                env('MINIO_SECRET_KEY')
            );
    
            $s3Client = new S3Client([
                'version' => 'latest',
                'region'  => 'us-east-1', // Sua região do MinIO
                'endpoint' => env('MINIO_ENDPOINT'),
                'use_path_style_endpoint' => true,
                'credentials' => $credentials,
                'http' => [
                    'verify' => true
                ],
            ]);
    
            try {
                $bucket = env('MINIO_BUCKET');
                $key = 'anexos/' . $anexo->nome;  
    
                $command = $s3Client->getCommand('GetObject', [
                    'Bucket' => $bucket,
                    'Key'    => $key,
                ]);
    
                $request = $s3Client->createPresignedRequest($command, '+20 minutes');
                $presignedUrl = (string)$request->getUri();
    
                return [
                    'url' => $presignedUrl,
                    'nome' => $anexo->descricao
                ];
            } catch (\Exception $e) {
                dd($e->getMessage());
                Log::error('Erro ao gerar URL assinada para o anexo ' . $anexo->nome . ': ' . $e->getMessage());
                return [
                    'error' => 'Erro ao gerar URL assinada para o anexo ' . $anexo->nome
                ];
            }
        });
    
        return $anexosArray;
    }
}