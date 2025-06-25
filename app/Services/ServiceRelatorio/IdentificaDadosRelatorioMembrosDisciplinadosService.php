<?php 

namespace App\Services\ServiceRelatorio;

use App\Models\MembresiaFuncaoMinisterial;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;

class IdentificaDadosRelatorioMembrosDisciplinadosService
{
    use Identifiable;

    public function execute(array $params = [])
    {
        $data = [
            'select'       => isset($params['membro_id']) ? $params['membro_id'] : '',
            'congregacoes' => Identifiable::fetchCongregacoes(),
            'membros'      => $this->fetchMembrosDisciplinadosRelatorio(),
            'render'       => isset($params['action']) && $params['action'] == 'relatorio' ? 'pdf' : 'view',
            'membro_unico' => true
        ];

        if(!$params){
            if(isset($params['action'])) {
                $data['membroEclesiastico']    = Identifiable::fetchPessoaDisciplina($params['membro_id'], MembresiaMembro::VINCULO_MEMBRO);
                $data['membro_unico']          = true;
            }
        }else{
            if($params['membro_id'] == 'todos'){
                $data['todos_membros']       = [];
                foreach($data['membros'] as $membro){
                    $params['membro_id']     = $membro->id;
                    $data['todos_membros'][] = ['membro' => (object) Identifiable::fetchPessoaDisciplina($params['membro_id'], MembresiaMembro::VINCULO_MEMBRO)];
                }
                $data['membro_unico'] = false;
            }else{
                if(isset($params['action'])) {
                    $data['membroEclesiastico']    = Identifiable::fetchPessoaDisciplina($params['membro_id'], MembresiaMembro::VINCULO_MEMBRO);
                    $data['membro_unico'] = true;
                }
            }
             
        }     

        return $data;
    }

    private function fetchMembrosDisciplinadosRelatorio()
    {
        $data = MembresiaMembro::select('membresia_membros.*')->Join('membresia_disciplinas as md', 'md.membro_id', 'membresia_membros.id')->where('vinculo', MembresiaMembro::VINCULO_MEMBRO)
            ->where('membresia_membros.igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->whereNull('dt_termino')
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