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
       // dd(Identifiable::fetchSessionIgrejaLocal()->id); 2262
        //dd($params);
        $membresiaMembro =  MembresiaMembro::select('imwpgahml.membresia_membros.*', 
                        DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = membresia_membros.id) AS telefone"),
                        DB::raw("(SELECT msr.nome FROM membresia_rolpermanente recep JOIN membresia_situacoes msr ON msr.id = recep.modo_recepcao_id WHERE recep.membro_id = membresia_membros.id AND recep.lastrec = 1 LIMIT 1) as recepcao_modo"),
                        DB::raw("(SELECT mse.nome FROM membresia_rolpermanente excl JOIN membresia_situacoes mse ON mse.id = excl.modo_exclusao_id WHERE excl.membro_id = membresia_membros.id AND excl.lastrec = 1 LIMIT 1) as exclusao_modo") )
           // ->with('rolAtualSessionIgreja')
            ->leftJoin('membresia_rolpermanente', 'membresia_rolpermanente.id', 'membresia_membros.id')
            ->when($params['situacao'] == 'ativos', function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    //$query->Where('membresia_rolpermanente.status', 'A')->where('membresia_rolpermanente.lastrec', 1)->withTrashed()->where('membresia_rolpermanente.igreja_id', Identifiable::fetchSessionIgrejaLocal()->id);
                    $query->Where('membresia_membros.status', 'A');
                });
            })
            ->when($params['situacao'] == 'inativos', function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    //$query->Where('membresia_rolpermanente.status', 'I')->where('membresia_rolpermanente.lastrec', 1)->withTrashed()->where('membresia_rolpermanente.igreja_id', Identifiable::fetchSessionIgrejaLocal()->id);
                    $query->Where('membresia_membros.status', 'I');
                });
            })

            ->when($params['dt_filtro'] == 'dt_recepcao', function ($query) {
                //$query->where('has_errors', 1);
                $query->where('membresia_rolpermanente.status', 'A')->where('membresia_rolpermanente.lastrec', 1)->withTrashed()->where('membresia_rolpermanente.igreja_id', Identifiable::fetchSessionIgrejaLocal()->id);
            })

            // ->when($params['dt_filtro'] == 'dt_recepcao', function ($query) {
            //     $query->where(function ($query) {
            //         $query->withoutGlobalScopes();
            //         $query->Where('membresia_rolpermanente.status', 'A')->where('membresia_rolpermanente.lastrec', 1)->withTrashed()->where('membresia_rolpermanente.igreja_id', Identifiable::fetchSessionIgrejaLocal()->id);
            //     });
            // })
            ->when($params['dt_filtro'] == 'dt_exclusao', function ($query) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->Where('membresia_rolpermanente.status', 'I')->where('membresia_rolpermanente.lastrec', 1)->withTrashed()->where('membresia_rolpermanente.igreja_id', Identifiable::fetchSessionIgrejaLocal()->id);
                });
            })
            ->when($params['congregacao_id'], fn ($query) => $query->where('membresia_rolpermanente.congregacao_id', $params['congregacao_id']))
            ->when($params['dt_filtro'], function ($query) use ($params) {
                if ($params['dt_filtro'] == 'data_nascimento') {
                    return $this->handleFilterDtNascimento($query, $params['dt_inicial'], $params['dt_final']);
                } else {   
                    //return $this->handleRolDates($query, $params['dt_filtro'], $params['dt_inicial'], $params['dt_final']);
                }
            })
            ->where('membresia_membros.vinculo', $params['vinculo'])
            ->where('membresia_membros.igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->orderBy('membresia_membros.nome')
            ->get();

            return $membresiaMembro;

        // return MembresiaMembro::select('imwpgahml.membresia_membros.*', DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
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

        // return MembresiaMembro::select('imwpgahml.membresia_membros.*','membresia_situacoes.nome as modo', DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
        //                       WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
        //                       ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = membresia_membros.id) AS telefone") )
        //     ->join('membresia_rolpermanente', 'membresia_rolpermanente.id', 'membresia_membros.id')
        //     ->join('membresia_situacoes', 'membresia_situacoes.id', 'membresia_rolpermanente.modo_recepcao_id')
        //     ->with('rolAtualSessionIgreja')
        //     ->where('membresia_membros.vinculo', $params['vinculo'])
        //     ->where('membresia_membros.igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
        //     ->withTrashed()
        //     ->when($params['situacao'] == 'ativos', function ($query) {
        //         $query->where(function ($query) {
        //             $query->withoutGlobalScopes();
        //             $query->orWhereRelation('rolAtualSessionIgreja', 'membresia_membros.status', 'A');
        //             $query->orWhere('membresia_membros.status', 'A');
        //         });
        //     })
        //     ->when($params['situacao'] == 'inativos', function ($query) {
        //         $query->where(function ($query) {
        //             $query->withoutGlobalScopes();
        //             $query->orWhereRelation('rolAtualSessionIgreja', 'membresia_membros.status', 'I');
        //             $query->orWhere('membresia_membros.status', 'I');
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


            // return MembresiaMembro::select('imwpgahml.membresia_membros.*','membresia_situacoes.nome as modo', DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
        //                       WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
        //                       ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = membresia_membros.id) AS telefone") )
        //     ->join('membresia_rolpermanente', 'membresia_rolpermanente.id', 'membresia_membros.id')
        //     ->leftJoin('membresia_situacoes', 'membresia_situacoes.id', 'membresia_rolpermanente.modo_recepcao_id')
        //     ->with('rolAtualSessionIgreja')
        //     ->where('membresia_membros.vinculo', $params['vinculo'])
        //     ->where('membresia_membros.igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
        //     ->withTrashed()
        //     ->when($params['situacao'] == 'ativos', function ($query) {
        //         $query->where(function ($query) {
        //             $query->withoutGlobalScopes();
        //             $query->orWhereRelation('rolAtualSessionIgreja', 'membresia_membros.status', 'A');
        //             $query->orWhere('membresia_membros.status', 'A');
        //         });
        //     })
        //     ->when($params['situacao'] == 'inativos', function ($query) {
        //         $query->where(function ($query) {
        //             $query->withoutGlobalScopes();
        //             $query->orWhereRelation('rolAtualSessionIgreja', 'membresia_membros.status', 'I');
        //             $query->orWhere('membresia_membros.status', 'I');
        //         });
        //     })
        //     ->when($params['dt_filtro'] == 'dt_recepcao', fn ($query) => $query->where('membresia_membros.status', 'A')) 
        //     ->when($params['dt_filtro'] == 'dt_exclusao', fn ($query) => $query->where('membresia_membros.status', 'I'))
        //     ->when($params['congregacao_id'], fn ($query) => $query->where('congregacao_id', $params['congregacao_id']))
        //     ->when($params['dt_filtro'], function ($query) use ($params) {
        //         if ($params['dt_filtro'] == 'data_nascimento') {
        //             return $this->handleFilterDtNascimento($query, $params['dt_inicial'], $params['dt_final']);
        //         } else {   
        //              return $this->handleRolDates($query, $params['dt_filtro'], $params['dt_inicial'], $params['dt_final']);
        //         }
        //     })->orderBy('nome')
        //     ->get();
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