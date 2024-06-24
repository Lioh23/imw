<?php 

namespace App\Services\ServiceFinanceiro;

use App\Models\Anexo;

class GetAnexosByLancamentoService
{
    public function execute($lancamento)
    {
        $anexos = Anexo::where('lancamento_id', $lancamento)->get();
        
        return [
            'anexos' => $this->handleSlotsAnexo($anexos),
        ];
    }

    private function handleSlotsAnexo($anexos, $totalSlots = 3)
    {
        $result = collect();

        collect()->make(array_fill(0, $totalSlots, null))->each(function ($item, $key) use ($anexos, &$result)  {
            $result->push($anexos[$key] ?? $item);
        });

        return $result;
    }
}