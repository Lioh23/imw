<?php 

namespace App\Services\ServiceRelatorio;

use App\Models\MembresiaFuncaoMinisterial;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;

class IdentificaDadosRelatorioFuncoesEclesiasticasService
{
    use Identifiable;

    public function execute(array $params = [])
    {
        $data = [
            'select'       => isset($params['membro_id']) ? $params['membro_id'] : '',
            'congregacoes' => Identifiable::fetchCongregacoes(),
            'funcoes_eclesiasticas' => Identifiable::fetchFuncoesEclesiasticas(),
            'render'       => isset($params['action']) && $params['action'] == 'relatorio' ? 'pdf' : 'view',
            'membro_unico' => true
        ];

        if(!$params){
        }else{
            if($params['membro_id'] == 'todos'){
                $data['todos_membros']       = [];
                foreach($data['membros'] as $membro){
                    $params['membro_id']     = $membro->id;
                    $data['todos_membros'][] = ['membro' => (object) Identifiable::fetchPessoaFuncaoEclesiastica($params['membro_id'], MembresiaMembro::VINCULO_MEMBRO)];
                }
                $data['membro_unico'] = false;
            }else{
                if(isset($params['action'])) {
                    $data['membro']    = Identifiable::fetchPessoaFuncaoEclesiastica($params['membro_id'], MembresiaMembro::VINCULO_MEMBRO);
                    $data['membro_unico'] = true;
                }
            }
             
        }     

        return $data;
    }
}