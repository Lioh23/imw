<?php 

namespace App\Services\ServiceRelatorio;

use App\Models\CongregacoesCongregacao;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class IdentificaDadosRelatorioMembresiaService
{
    use Identifiable;

    public function execute(array $params = [])
    {
        //dd($params);
        $data = [
            'congregacoes' => Identifiable::fetchCongregacoes(),
            'render'       => isset($params['action']) && $params['action'] == 'relatorio' ? 'pdf' : 'view'
        ];

        if(isset($params['action'])) {
            $data['vinculos']     = $this->fetchTextVinculo($params['vinculo']);
            $data['situacao']     = $this->fetchTextSituacao($params['situacao']);
            $data['ondeCongrega'] = $this->fetchTextCongregacao($params['congregacao_id']);
            $data['membros']      = $params['vinculo'] == 'M' 
                ? $this->fetchMembrosRelatorio($params)
                : $this->fetchCongregadosVisitantesRelatorio($params);
        }

        return $data;
    }

    private function fetchMembrosRelatorio($params)
    {
        return MembresiaMembro::select('imwpgahml.membresia_membros.*', DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = membresia_membros.id) AS telefone") )
            ->with('rolAtualSessionIgreja')
            ->where('vinculo', $params['vinculo'])
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->withTrashed()
            ->when($params['situacao'] == 'ativos', function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->orWhereRelation('rolAtualSessionIgreja', 'status', 'A');
                    $query->orWhere('status', 'A');
                });
            })
            ->when($params['situacao'] == 'inativos', function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->orWhereRelation('rolAtualSessionIgreja', 'status', 'I');
                    $query->orWhere('status', 'I');
                });
            })
            ->when($params['congregacao_id'], fn ($query) => $query->where('congregacao_id', $params['congregacao_id']))
            ->when($params['dt_filtro'], function ($query) use ($params) {
                if ($params['dt_filtro'] == 'data_nascimento') {
                    return $this->handleFilterDtNascimento($query, $params['dt_inicial'], $params['dt_final']);
                } else {   
                    return $this->handleRolDates($query, $params['dt_filtro'], $params['dt_inicial'], $params['dt_final']);
                }
            })
            ->get();
    }

    private function fetchCongregadosVisitantesRelatorio($params)
    {
        return MembresiaMembro::select('imwpgahml.membresia_membros.*', DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = membresia_membros.id) AS telefone") )
            ->where('vinculo', $params['vinculo'])
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->withTrashed()
            ->when($params['situacao'] == 'ativos', fn ($query) => $query->where('status', 'A')) 
            ->when($params['situacao'] == 'inativos', fn ($query) => $query->where('status', 'I')) 
            ->when($params['congregacao_id'], fn ($query) => $query->where('congregacao_id', $params['congregacao_id']))
            ->when($params['dt_filtro'], function ($query) use ($params) {
                if ($params['dt_filtro'] == 'data_nascimento') {
                    return $this->handleFilterDtNascimento($query, $params['dt_inicial'], $params['dt_final']);
                } else { 
                    return $this->handleDates($query, $params['dt_filtro'], $params['dt_inicial'], $params['dt_final']);
                }
            })
            ->get();
    }

    private function handleRolDates($query, $field, $dtInicial, $dtFinal)
    {
        return $query->whereHas('rolAtualSessionIgreja', function ($query) use ($field, $dtInicial, $dtFinal) {
            $query->withoutGlobalScopes();
            $query->when($dtInicial, fn ($query) => $query->where($field, '>=', $dtInicial));
            $query->when($dtFinal, fn ($query) => $query->where($field, '<=', $dtFinal));
        });
    }

    private function handleDates($query, $field, $dtInicial, $dtFinal)
    {
        $fieldName = $field == 'dt_recepcao' ? 'created_at' : 'deleted_at';

        return $query->when($dtInicial, fn($query) => $query->where($fieldName, '>=' , $dtInicial))
                     ->when($dtFinal, fn($query) => $query->where($fieldName, '<=' , $dtFinal));
    }

    private function handleFilterDtNascimento($query, $dtInicial, $dtFinal) 
    {
        return $query->when($dtInicial, fn ($query) => $query->where('data_nascimento', '>=' , $dtInicial))
                     ->when($dtFinal, fn ($query) => $query->where('data_nascimento', '<=' , $dtFinal));
    }

    private function handleFilterDtRecepcao($query, $dtInicial, $dtFinal) 
    {
        $query->where(function ($query) use ($dtInicial, $dtFinal) {
            $query->withoutGlobalScopes();
            if ($dtInicial) {
                $query->whereDate('created_at', '>=', $dtInicial);
                $query->orWhereRelation('rolAtualSessionIgreja', 'dt_recepcao', '>=', $dtInicial);
            }
    
            if ($dtFinal) {
                $query->whereDate('created_at', '<=', $dtFinal);
                $query->orWhereRelation('rolAtualSessionIgreja', 'dt_recepcao', '<=', $dtFinal);
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
                $query->orWhereRelation('rolAtualSessionIgreja', 'dt_exclusao', '>=', $dtInicial);
            }
    
            if ($dtFinal) {
                $query->whereDate('deleted_at', '<=', $dtFinal);
                $query->orWhereRelation('rolAtualSessionIgreja', 'dt_exclusao', '<=', $dtFinal);
            }
        });

        return $query;
    }

    private function fetchTextVinculo($vinculo)
    {
        $textVinculos = [
            'M' => 'MEMBROS',
            'C' => 'CONGREGADOS',
            'V' => 'VISITANTES'
        ];
        
        return $textVinculos[$vinculo];
    }

    private function fetchTextSituacao($situacao) 
    {
        switch ($situacao) {
            case 'ativos':
                return 'ATIVOS';

            case 'inativos':
                return 'INATIVOS';

            case 'todos':
                return 'TODOS';

            default:
                return 'ATIVOS';
        }
    }

    private function fetchTextCongregacao($congregacaoId)
    {
        if (!$congregacaoId) 
            return 'TODOS';

        return CongregacoesCongregacao::find($congregacaoId)->nome;
    }
}