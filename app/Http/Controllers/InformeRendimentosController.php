<?php

namespace App\Http\Controllers;

use App\Services\InformeRendimentos\BuscaArquivoPdfService;
use App\Services\InformeRendimentos\ChecaArquivoExistenteService;
use Illuminate\Http\Request;

class InformeRendimentosController extends Controller
{
    public function exibirPdf(string $ano)
    {
        $filePath = app(BuscaArquivoPdfService::class)->execute($ano);

        return response()->file($filePath,['Content-Type' => 'application/pdf']);
    }
}
