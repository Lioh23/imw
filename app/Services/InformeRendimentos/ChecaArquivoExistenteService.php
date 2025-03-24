<?php

namespace App\Services\InformeRendimentos;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChecaArquivoExistenteService
{
    public static function execute(string $ano)
    {
        $cpf = self::handleGetCpf();
        $pdfPath = "informe_rendimentos/$ano/$cpf.pdf";

        return Storage::exists($pdfPath);
    }

    private static function handleGetCpf()
    {
        $pessoa = Auth::user()->pessoa;

        return (bool) $pessoa ? $pessoa->cpf : '';
    }
}
