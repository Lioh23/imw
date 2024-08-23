<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroLancamento;
use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\Uuid;

class StoreNewAnexoService
{
    public function execute(array $data, FinanceiroLancamento $lancamento): void
    {
        $payload = $this->handleStoreAnexo($data['anexo']);
        $payload['descricao'] = $data['descricao_anexo'];

        $lancamento->anexos()->create($payload);
    }

    public function handleStoreAnexo(UploadedFile $file): array
    {
        $fileName = Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('anexos', $fileName, 's3');

        return [
            'nome'    => $fileName,
            'caminho' => $filePath,
        ];
    }
}