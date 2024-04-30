<?php 

namespace App\Services\ServiceRelatorio;

use App\Models\MembresiaFuncaoMinisterial;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;

class IdentificaDadosRelatorioHistoricoEclesiasticoService
{
    use Identifiable;

    public function execute(array $params = [])
    {
        $data = [
            'congregacoes' => Identifiable::fetchCongregacoes(),
            'membros'      => $this->fetchMembrosRelatorio(),
            'render'       => isset($params['action']) && $params['action'] == 'relatorio' ? 'pdf' : 'view'
        ];

        if(isset($params['action'])) {
            $data['membroEclesiastico']    = Identifiable::fetchPessoa($params['membro_id'], MembresiaMembro::VINCULO_MEMBRO);
            $data['historicoEclesiastico'] = $this->fetchHistoricoEclesiastico($params);
        }

        return $data;
    }

    private function fetchMembrosRelatorio()
    {
        $data = MembresiaMembro::where('vinculo', MembresiaMembro::VINCULO_MEMBRO)
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->get();
           
        return $data;
    }

    private function fetchHistoricoEclesiastico($params)
    {
        $data = MembresiaFuncaoMinisterial::where('membro_id', $params['membro_id'])
            ->when((bool) $params['nomeacao_ativa'], fn($query) => $query->whereNull('data_saida'))
            ->get();

        return $data;
    }
}