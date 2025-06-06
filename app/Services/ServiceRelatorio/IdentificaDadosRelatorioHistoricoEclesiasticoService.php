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
            'select'       => isset($params['membro_id']) ? $params['membro_id'] : '',
            'congregacoes' => Identifiable::fetchCongregacoes(),
            'membros'      => $this->fetchMembrosRelatorio(),
            'render'       => isset($params['action']) && $params['action'] == 'relatorio' ? 'pdf' : 'view',
            'membro_unico' => true
        ];

        if(!$params){
            if(isset($params['action'])) {
                $data['membroEclesiastico']    = Identifiable::fetchPessoa($params['membro_id'], MembresiaMembro::VINCULO_MEMBRO);
                $data['historicoEclesiastico'] = $this->fetchHistoricoEclesiastico($params);
                $data['membro_unico']          = true;
            }
        }else{
            if($params['membro_id'] == 'todos'){
                $data['todos_membros']       = [];
                foreach($data['membros'] as $membro){
                    $params['membro_id']     = $membro->id;
                    $data['todos_membros'][] = ['membro' => (object) Identifiable::fetchPessoa($params['membro_id'], MembresiaMembro::VINCULO_MEMBRO), 'historicoEclesiastico' => (object) $this->fetchHistoricoEclesiastico($params)];
                }
                $data['membro_unico'] = false;
            }else{
                if(isset($params['action'])) {
                    $data['membroEclesiastico']    = Identifiable::fetchPessoa($params['membro_id'], MembresiaMembro::VINCULO_MEMBRO);
                    $data['historicoEclesiastico'] = $this->fetchHistoricoEclesiastico($params);
                    $data['membro_unico'] = true;
                }
            }
             
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