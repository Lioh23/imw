<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\MembresiaMembro;
use App\Models\FinanceiroGrade;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalvarLivroGradeService
{
    use Identifiable;

    public function execute($request)
    {
        // Convertendo o valor para float e substituindo ',' por '.' para manter o formato monetário correto
        $valor = (float) str_replace(['.', ','], ['', '.'], $request->value);
      
        $data = [
            'ano' => $request->ano,
            'membro_id' => $request->membro_id,
            'valor' => $valor,
        ];

        $titleToKey = [
            'JAN' => 'jan',
            'FEV' => 'fev',
            'MAR' => 'mar',
            'ABR' => 'abr',
            'MAI' => 'mai',
            'JUN' => 'jun',
            'JUL' => 'jul',
            'AGO' => 'ago',
            'SET' => 'set',
            'OUT' => 'out',
            'NOV' => 'nov',
            'DEZ' => 'dez',
            '13º' => 'o13', 
        ];

        // Verificar se o mês é válido e definir o nome do mês correspondente
        if (isset($titleToKey[$request->title])) {
            $data['mes'] = $titleToKey[$request->title];
        }
  
        return $this->handleLancamento($data);
    }

    private function handleLancamento($data) {
        // Verificar se já existe um registro para o membro_id, ano e mês específico
        $existingLancamento = FinanceiroGrade::where('membro_id', $data['membro_id'])
            ->where('ano', $data['ano'])
            ->where(function ($query) use ($data) {
                $query->where($data['mes'], '!=', null)
                    ->orWhere($data['mes'], '!=', '0.00');
            })
            ->first();
    
        if ($existingLancamento) {
            // Se o registro já existe, atualize-o
            $existingLancamento->update([$data['mes'] => $data['valor']]);
            return $existingLancamento;
        } else {
            // Se não existir, crie um novo registro
            return FinanceiroGrade::create([
                'membro_id' => $data['membro_id'],
                'ano' => $data['ano'],
                $data['mes'] => $data['valor']
            ]);
        }
    }
    
    
    

}
