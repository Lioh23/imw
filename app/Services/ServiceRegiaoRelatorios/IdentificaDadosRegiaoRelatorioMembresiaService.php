<?php 

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\CongregacoesCongregacao;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class IdentificaDadosRegiaoRelatorioMembresiaService
{
    use Identifiable;

    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        $data = [
            'distritos' => Identifiable::fetchDistritosByRegiao($regiao->id),
            'render'       => isset($params['action']) && $params['action'] == 'relatorio' ? 'pdf' : 'view',
            'regiao_nome' => $regiao->nome,
        ];
        if(isset($params['action'])) {
            $data['vinculos']     = $this->fetchTextVinculo($params['vinculo']);
            $data['situacao']     = $this->fetchTextSituacao($params['situacao']);
            $data['ondeCongrega'] = $this->fetchTextCongregacao($params['congregacao_id']);
            $data['membros']      = $params['vinculo'] == 'M' 
                ? $this->fetchMembrosRelatorio($params, $data)
                : $this->fetchCongregadosVisitantesRelatorio($params);
        }
        return $data;
    }

    private function fetchMembrosRelatorio($params, $data)
    {
        
        $igrejaId = Identifiable::fetchIgrejasByDistrito($data['distritos'][0]->id);
        $igrejaId = $igrejaId[0]->id;
        if($params['vinculo'] == 'M') {
            $dtInicial = $params['dt_inicial'];
            $dtFinal = $params['dt_final'];

            $membresiaMembro =  MembresiaMembro::select('membresia_membros.*', 'recepcao_modo.nome as recepcao_modo', 'exclusao_modo.nome as exclusao_modo',
                DB::raw("DATE_FORMAT(membresia_rolpermanente.dt_recepcao, '%d/%m/%Y') dt_recepcao"),
                DB::raw("DATE_FORMAT(membresia_rolpermanente.dt_exclusao, '%d/%m/%Y') dt_exclusao"),
                DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = membresia_membros.id) AS telefone") )

            ->join('membresia_rolpermanente', 'membresia_rolpermanente.membro_id', 'membresia_membros.id')
            ->leftJoin('membresia_situacoes as recepcao_modo', 'recepcao_modo.id', 'membresia_rolpermanente.modo_recepcao_id')
            ->leftJoin('membresia_situacoes as exclusao_modo', 'exclusao_modo.id', 'membresia_rolpermanente.modo_exclusao_id')
            ->when($params['situacao'] == 'ativos', function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_rolpermanente.status', 'A');
                    $query->where('membresia_membros.status', 'A');
                });
            })
            ->when($params['situacao'] == 'inativos', function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_rolpermanente.status', 'I');
                    $query->where('membresia_membros.status', 'I');
                });
            })
            ->when($params['dt_filtro'] == 'dt_recepcao', function  ($query) use( $dtInicial, $dtFinal) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_rolpermanente.status', 'A');
                });
                $query->when($dtInicial, fn ($query) => $query->where('membresia_rolpermanente.dt_recepcao', '>=' , $dtInicial));
                $query->when($dtFinal, fn ($query) => $query->where('membresia_rolpermanente.dt_recepcao', '<=' , $dtFinal));
            })
            ->when($params['dt_filtro'] == 'dt_exclusao', function ($query) use( $dtInicial, $dtFinal) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_rolpermanente.status', 'I');
                });
                $query->when($dtInicial, fn ($query) => $query->where('membresia_rolpermanente.dt_exclusao', '>=' , $dtInicial));
                $query->when($dtFinal, fn ($query) => $query->where('membresia_rolpermanente.dt_exclusao', '<=' , $dtFinal));
            })
            ->when($params['congregacao_id'], fn ($query) => $query->where('membresia_membros.congregacao_id', $params['congregacao_id']))
            ->when($params['dt_filtro'], function ($query) use ($params) {
                if ($params['dt_filtro'] == 'data_nascimento') {
                    return $this->handleFilterDtNascimento($query, $params['dt_inicial'], $params['dt_final']);
                } else {   
                    return $this->handleRolDates($query, $params['dt_filtro'], $params['dt_inicial'], $params['dt_final']);
                }
            })
            ->where('membresia_membros.vinculo', $params['vinculo'])
            ->where('membresia_membros.igreja_id', $igrejaId)
            ->where('membresia_rolpermanente.igreja_id', $igrejaId)
            ->orderBy('nome')
            ->get();
            
        } else {
            $dtInicial = $params['dt_inicial'];
            $dtFinal = $params['dt_final'];
            $igrejaId = Identifiable::fetchSessionIgrejaLocal()->id;
            $membresiaMembro =  MembresiaMembro::select('membresia_membros.*', DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = membresia_membros.id) AS telefone") )
            ->when($params['situacao'] == 'ativos', function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_membros.status', 'A');
                });
            })
            ->when($params['situacao'] == 'inativos', function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_membros.status', 'I');
                });
            })
            ->when($params['dt_filtro'] == 'dt_recepcao', function  ($query) use( $dtInicial, $dtFinal) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_membros.status', 'A');
                });
                $query->when($dtInicial, fn ($query) => $query->where('membresia_membros.created_at', '>=' , $dtInicial));
                $query->when($dtFinal, fn ($query) => $query->where('membresia_membros.created_at', '<=' , $dtFinal));
            })
            ->when($params['dt_filtro'] == 'dt_exclusao', function ($query) use( $dtInicial, $dtFinal) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_membros.status', 'I');
                });
                $query->when($dtInicial, fn ($query) => $query->where('membresia_membros.deleted_at', '>=' , $dtInicial));
                $query->when($dtFinal, fn ($query) => $query->where('membresia_membros.deleted_at', '<=' , $dtFinal));
            })
            ->when($params['congregacao_id'], fn ($query) => $query->where('congregacao_id', $params['congregacao_id']))
            ->when($params['dt_filtro'], function ($query) use ($params) {
                if ($params['dt_filtro'] == 'data_nascimento') {
                    return $this->handleFilterDtNascimento($query, $params['dt_inicial'], $params['dt_final']);
                } 
            })
            ->where('vinculo', $params['vinculo'])
            ->where('igreja_id', $igrejaId)
            ->orderBy('nome')
            ->get();

        }
        
            return $membresiaMembro;

        // return MembresiaMembro::select('membresia_membros.*', DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
        //                       WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
        //                       ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = membresia_membros.id) AS telefone") )
        //     ->with('rolAtualSessionIgreja')
        //     ->where('vinculo', $params['vinculo'])
        //     ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
        //     ->withTrashed()
        //     ->when($params['situacao'] == 'ativos', function ($query) {
        //         $query->where(function ($query) {
        //             $query->withoutGlobalScopes();
        //             $query->orWhereRelation('rolAtualSessionIgreja', 'status', 'A');
        //             $query->orWhere('status', 'A');
        //         });
        //     })
        //     ->when($params['situacao'] == 'inativos', function ($query) {
        //         $query->where(function ($query) {
        //             $query->withoutGlobalScopes();
        //             $query->orWhereRelation('rolAtualSessionIgreja', 'status', 'I');
        //             $query->orWhere('status', 'I');
        //         });
        //     })
        //     ->when($params['congregacao_id'], fn ($query) => $query->where('congregacao_id', $params['congregacao_id']))
        //     ->when($params['dt_filtro'], function ($query) use ($params) {
        //         if ($params['dt_filtro'] == 'data_nascimento') {
        //             return $this->handleFilterDtNascimento($query, $params['dt_inicial'], $params['dt_final']);
        //         } else {   
        //             return $this->handleRolDates($query, $params['dt_filtro'], $params['dt_inicial'], $params['dt_final']);
        //         }
        //     })->orderBy('nome')
        //     ->get();

    }

    private function fetchCongregadosVisitantesRelatorio($params)
    {
        return MembresiaMembro::select('membresia_membros.*', DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
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
            })->orderBy('nome')
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