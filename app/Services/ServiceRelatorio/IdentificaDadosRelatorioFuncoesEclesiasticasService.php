<?php 

namespace App\Services\ServiceRelatorio;

use App\Models\MembresiaFuncaoEclesiastica;
use App\Models\MembresiaFuncaoMinisterial;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;

class IdentificaDadosRelatorioFuncoesEclesiasticasService
{
    use Identifiable;

    public function execute(array $params = [])
    {
        $data = [
            'select'       => isset($params['funcao_eclesiastica_id']) ? $params['funcao_eclesiastica_id'] : '',
            'funcoes_eclesiasticas' => Identifiable::fetchFuncoesEclesiasticas(),
            'render'       =>  'view',
        ];

        if($params){
            if(isset($params['action'])) {
                if($params['funcao_eclesiastica_id'] != 'todas'){
                    $funcao_eclesiastica =  MembresiaFuncaoEclesiastica::where('id', $params['funcao_eclesiastica_id'])->first();
                    $funcao = strtoupper($funcao_eclesiastica->descricao);
                }else{
                    $funcao = 'TODAS';
                }
                $data['membros']    = Identifiable::fetchPessoaFuncaoEclesiastica($params['funcao_eclesiastica_id']);
                $data['funcao_eclesiastica'] = $funcao;
            }             
        }     

        return $data;
    }
}