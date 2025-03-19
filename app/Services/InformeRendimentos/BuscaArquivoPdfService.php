<?php

namespace App\Services\InformeRendimentos;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BuscaArquivoPdfService
{
    public function execute(string $ano)
    {
        $cpf = $this->handleGetCpf();
        $pdfPath = "informe_rendimentos/$ano/$cpf.pdf";

        return Storage::path($pdfPath);
    }

    private function handleGetCpf()
    {
        $pessoa = Auth::user()->pessoa;

        return (bool) $pessoa ? $pessoa->cpf : '';
    }
}
