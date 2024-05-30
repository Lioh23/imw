<?php 

namespace App\Services\ServiceRelatorio;

use App\Models\CongregacoesCongregacao;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use Carbon\Carbon;

class IdentificaDadosRelatorioMembresiaService
{
    use Identifiable;

    public function execute(array $params = [])
    {
        $data = [
            'congregacoes' => Identifiable::fetchCongregacoes(),
            'render'       => isset($params['action']) && $params['action'] == 'relatorio' ? 'pdf' : 'view'
        ];

        if(isset($params['action'])) {
            $data['membros']      = $this->fetchMembrosRelatorio($params);
            $data['vinculos']     = $this->fetchTextVinculos($params['vinculo']);
            $data['situacao']     = $this->fetchTextSituacao(isset($params['situacao']) ? $params['situacao'] : 'rol_permanente');
            $data['ondeCongrega'] = $this->fetchTextCongregacao($params['congregacao_id']);
        }

        return $data;
    }

    private function fetchMembrosRelatorio($params)
    {
        $data = MembresiaMembro::with('ultimaAdesao', 'ultimaExclusao', 'rolAtual')
            ->withTrashed()
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->when($params['vinculo'], fn($query) => $query->whereIn('vinculo', $params['vinculo']))
            // desligados
            ->when(isset($params['situacao']) && ($params['situacao'] == 'desligados'), function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->orWhereRelation('rolAtual', 'status', 'I');
                    $query->orWhere('status', 'I');
                });
            })

            // ativos
            ->when((isset($params['situacao']) && $params['situacao'] == 'rol_atual'), function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->orWhereRelation('rolAtual', 'status', 'A');
                    $query->orWhere('status', 'A');
                });
            })

            ->when($params['congregacao_id'], fn ($query) => $query->where('congregacao_id', $params['congregacao_id']))
            ->when($params['dt_filtro'], function ($query) use ($params) {
                if ($params['dt_filtro'] == 'data_nascimento') {
                    return $this->handleFilterDtNascimento($query, $params['dt_inicial'], $params['dt_final']);
                } else if ($params['dt_filtro'] == 'dt_recepcao') {
                    return $this->handleFilterDtRecepcao($query, $params['dt_inicial'], $params['dt_final']);
                } else if ($params['dt_filtro'] == 'dt_exclusao') {
                    return $this->handleFilterDtExclusao($query, $params['dt_inicial'], $params['dt_final']);
                }
            })
            ->get();
        
        return $data;
    }

    private function handleFilterDtNascimento($query, $dtInicial, $dtFinal) 
    {
        if ($dtInicial) {
            $query->where('data_nascimento', '>=' , $dtInicial);
        }

        if ($dtFinal) {
            $query->where('data_nascimento', '<=' , $dtFinal);
        }

        return $query;
    }

    private function handleFilterDtRecepcao($query, $dtInicial, $dtFinal) 
    {
        $query->where(function ($query) use ($dtInicial, $dtFinal) {
            $query->withoutGlobalScopes();
            if ($dtInicial) {
                $query->whereDate('created_at', '>=', $dtInicial);
                $query->orWhereRelation('rolAtual', 'dt_recepcao', '>=', $dtInicial);
            }
    
            if ($dtFinal) {
                $query->whereDate('created_at', '<=', $dtFinal);
                $query->orWhereRelation('rolAtual', 'dt_recepcao', '<=', $dtFinal);
            }
        });

        return $query;
    }

    private function handleFilterDtExclusao($query, $dtInicial, $dtFinal) 
    {
        $query->where(function ($query) use ($dtInicial, $dtFinal) {
            $query->withoutGlobalScopes();
            if ($dtInicial) {
                $query->whereDate('deleted_at', '>=', $dtInicial);
                $query->orWhereRelation('rolAtual', 'dt_exclusao', '>=', $dtInicial);
            }
    
            if ($dtFinal) {
                $query->whereDate('deleted_at', '<=', $dtFinal);
                $query->orWhereRelation('rolAtual', 'dt_exclusao', '<=', $dtFinal);
            }
        });

        return $query;
    }

    private function fetchTextVinculos($vinculos)
    {
        if (!$vinculos) 
            return 'MEMBROS, CONGREGADOS, VISITANTES';

        $result = [];

        if(in_array('M', $vinculos)) {
            $result[] = 'MEMBROS';
        }

        if(in_array('C', $vinculos)) {
            $result[] = 'CONGREGADOS';
        }

        if(in_array('V', $vinculos)) {
            $result[] = 'VISITANTES';
        }

        return implode(', ', $result);
    }

    private function fetchTextSituacao($situacao) 
    {
        switch ($situacao) {
            case 'rol_atual':
                return 'ROL ATUAL';

            case 'rol_permanente':
                return 'ROL PERMANENTE';

            case 'desligados':
                return 'DESLIGADOS';   

            default:
                return 'ROL ATUAL';
        }
    }

    private function fetchTextCongregacao($congregacaoId)
    {
        if (!$congregacaoId) 
            return 'TODOS';

        return CongregacoesCongregacao::find($congregacaoId)->nome;
    }
}