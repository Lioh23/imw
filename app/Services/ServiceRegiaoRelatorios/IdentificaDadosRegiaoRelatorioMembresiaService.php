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
        $params['pocesso'] = 'executar';
        $params["distritoId"] = isset($params["distritoId"]) ? $params["distritoId"] : null;
        $params["vinculo"] = isset($params["vinculo"]) ? $params["vinculo"] : 'M';
        $params["situacao"] = isset($params["situacao"]) ? $params["situacao"] : 'todos';
        $params["filtro"] = isset($params["filtro"]) ? $params["filtro"] : null;
        $params["dtInicial"] = isset($params["dtInicial"]) ? $params["dtInicial"] : null;
        $params["dtFinal"] = isset($params["dtFinal"]) ? $params["dtFinal"] : null;
        $params["ordem"] = isset($params["ordem"]) ? $params["ordem"] : null;
        $params['totalPorPagina'] = isset($params['totalPorPagina']) ? $params['totalPorPagina'] : 10;
        $regiao = Identifiable::fetchtSessionRegiao();
        $distritos = Identifiable::fetchDistritosByRegiao($regiao->id);
 
        $data = [
            'distritos' => $distritos,
            'regiao_nome' => $regiao->nome,
        ];

        $data['vinculos']     = $this->fetchTextVinculo($params['vinculo']);
        $data['situacao']     = $this->fetchTextSituacao($params['situacao']);
        $data['ondeCongrega'] = 'Todos Distritos';
        $params['igreja_id'] = 0;
        $params['congregacao_id'] = 0;
        $params['regiao_id'] = $regiao->id;

        $membros = $this->fetchMembrosRelatorio($params, $data);

        $dados =  $membros['membresiaMembro'];
        $data['membros_total'] = $membros['membresiaMembroTotal'];
        $data['total'] = $membros['membresiaMembroTotal'];
        $data['links'] = $dados;
        $data['regiao_nome'] = $regiao->nome;
        
        $data['membros'] = $dados;   
        return $data;
    }

    public function exportar(array $params = [])
    {
        $params['pocesso'] = 'exportar';
        $params["distritoId"] = isset($params["distritoId"]) ? $params["distritoId"] : null;
        $params["vinculo"] = isset($params["vinculo"]) ? $params["vinculo"] : 'M';
        $params["situacao"] = isset($params["situacao"]) ? $params["situacao"] : 'todos';
        $params["filtro"] = isset($params["filtro"]) ? $params["filtro"] : null;
        $params["dtInicial"] = isset($params["dtInicial"]) ? $params["dtInicial"] : null;
        $params["dtFinal"] = isset($params["dtFinal"]) ? $params["dtFinal"] : null;
        $params["ordem"] = isset($params["ordem"]) ? $params["ordem"] : null;
        $params['totalPorPagina'] = isset($params['totalPorPagina']) ? $params['totalPorPagina'] : 10;
        $regiao = Identifiable::fetchtSessionRegiao();
        $distritos = Identifiable::fetchDistritosByRegiao($regiao->id);
 
        $data = [
            'distritos' => $distritos,
            'regiao_nome' => $regiao->nome,
        ];

        $data['vinculos']     = $this->fetchTextVinculo($params['vinculo']);
        $data['situacao']     = $this->fetchTextSituacao($params['situacao']);
        $data['ondeCongrega'] = 'Todos Distritos';
        $params['igreja_id'] = 0;
        $params['congregacao_id'] = 0;
        $params['regiao_id'] = $regiao->id;

        $membros = $this->fetchMembrosRelatorio($params, $data);

        $dados =  $membros['membresiaMembro'];
        $data['membros_total'] = $membros['membresiaMembroTotal'];
        $data['total'] = $membros['membresiaMembroTotal'];
        $data['links'] = $dados;
        $data['regiao_nome'] = $regiao->nome;
        
        $data['membros'] = $dados;   
        return $data;
    }

    private function fetchMembrosRelatorio($params, $data)
    {
        $igrejaId = $params['igreja_id'];
        $regiaoId = $params['regiao_id'];
        $totalPorPagina = $params['totalPorPagina'];
        $distritoId = $params['distritoId'];
        //dd($params['distritoId']);
        $vinculo = $params['vinculo'];
        $situacao = $params['situacao'];
        $filtro = $params['filtro'];
        $dtInicial = $params['dtInicial'];
        $dtFinal = $params['dtFinal'];
        $ordem = $params['ordem'];
       // DB::raw("DATE_FORMAT(membresia_membros.data_nascimento, '%d/%m/%Y') data_nascimento")
        if($params['vinculo'] == 'M') {
            $dtInicial = isset($params['dt_inicial']) ? $params['dt_inicial'] : '';
            $dtFinal = isset($params['dtFinal']) ? $params['dtFinal'] : '';
            $membresiaMembro =  MembresiaMembro::select('distrito.nome as distrito_nome', 'igreja.nome as igreja_nome', 'membresia_membros.rol_atual', 'membresia_membros.nome', 
                DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = membresia_membros.id) AS telefone"), 
                'membresia_membros.status', 'membresia_membros.vinculo', 'membresia_membros.data_nascimento', 'membresia_rolpermanente.dt_recepcao', 'recepcao_modo.nome as recepcao_modo', 'membresia_rolpermanente.dt_exclusao', 'exclusao_modo.nome as exclusao_modo', 'congregacao.nome as congregacao_nome')
            ->join('instituicoes_instituicoes as distrito', 'distrito.id', 'membresia_membros.distrito_id')
            ->join('instituicoes_instituicoes as igreja', 'igreja.id', 'membresia_membros.igreja_id')
            ->leftJoin('congregacoes_congregacoes as congregacao', 'congregacao.id', 'membresia_membros.congregacao_id')
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
            ->when($params['filtro'] == 'dt_recepcao', function  ($query) use( $dtInicial, $dtFinal) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_rolpermanente.status', 'A');
                });
                $query->when($dtInicial, fn ($query) => $query->where('membresia_rolpermanente.dt_recepcao', '>=' , $dtInicial));
                $query->when($dtFinal, fn ($query) => $query->where('membresia_rolpermanente.dt_recepcao', '<=' , $dtFinal));
            })
            ->when($params['filtro'] == 'dt_exclusao', function ($query) use( $dtInicial, $dtFinal) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_rolpermanente.status', 'I');
                });
                $query->when($dtInicial, fn ($query) => $query->where('membresia_rolpermanente.dt_exclusao', '>=' , $dtInicial));
                $query->when($dtFinal, fn ($query) => $query->where('membresia_rolpermanente.dt_exclusao', '<=' , $dtFinal));
            })
            ->when($params['filtro'], function ($query) use ($params) {
                if ($params['filtro'] == 'data_nascimento') {
                    return $this->handleFilterDtNascimento($query, $params['dtInicial'], $params['dtFinal']);
                } else {   
                    return $this->handleRolDates($query, $params['filtro'], $params['dtInicial'], $params['dtFinal']);
                }
            })
            ->when($params['distritoId'], fn ($query) => $query->where('distrito.id', $params['distritoId']))
            ->where('membresia_membros.vinculo', $params['vinculo'])
            ->where('distrito.instituicao_pai_id', $regiaoId);

            if($ordem == 'distrito-down'){
                $membresiaMembro->orderBy('distrito.nome','DESC');
            }elseif($ordem == 'distrito-up'){
                $membresiaMembro->orderBy('distrito.nome','ASC');
            }elseif($ordem == 'igreja-down'){
                $membresiaMembro->orderBy('igreja.nome','DESC');
            }elseif($ordem == 'igreja-up'){
                $membresiaMembro->orderBy('igreja.nome','ASC');
            }elseif($ordem == 'rol-down'){
                $membresiaMembro->orderBy('membresia_membros.rol_atual','DESC');
            }elseif($ordem == 'rol-up'){
                $membresiaMembro->orderBy('membresia_membros.rol_atual','ASC');
            }elseif($ordem == 'nome-down'){
                $membresiaMembro->orderBy('membresia_membros.nome','DESC');
            }elseif($ordem == 'nome-up'){
                $membresiaMembro->orderBy('membresia_membros.nome','ASC');
            }elseif($ordem == 'telefone-down'){
                $membresiaMembro->orderBy('telefone','DESC');
            }elseif($ordem == 'telefone-up'){
               $membresiaMembro->orderBy('telefone','ASC');
            }elseif($ordem == 'situacao-down'){
                $membresiaMembro->orderBy('membresia_membros.status','DESC');
            }elseif($ordem == 'situacao-up'){
               $membresiaMembro->orderBy('membresia_membros.status','ASC');
            }elseif($ordem == 'vinculo-down'){
                $membresiaMembro->orderBy('membresia_membros.vinculo','DESC');
            }elseif($ordem == 'vinculo-up'){
               $membresiaMembro->orderBy('membresia_membros.vinculo','ASC');
            }elseif($ordem == 'nascimento-down'){
                $membresiaMembro->orderBy('membresia_membros.data_nascimento','DESC');
            }elseif($ordem == 'nascimento-up'){
               $membresiaMembro->orderBy('membresia_membros.data_nascimento','ASC');
            }elseif($ordem == 'recepcao-down'){
                $membresiaMembro->orderBy('membresia_rolpermanente.dt_recepcao','DESC');
            }elseif($ordem == 'recepcao-up'){
               $membresiaMembro->orderBy('membresia_rolpermanente.dt_recepcao','ASC');
            }elseif($ordem == 'modo-recepcao-down'){
                $membresiaMembro->orderBy('recepcao_modo','DESC');
            }elseif($ordem == 'modo-recepcao-up'){
               $membresiaMembro->orderBy('recepcao_modo','ASC');
            }elseif($ordem == 'exclusao-down'){
                $membresiaMembro->orderBy('membresia_rolpermanente.dt_exclusao','DESC');
            }elseif($ordem == 'exclusao-up'){
               $membresiaMembro->orderBy('membresia_rolpermanente.dt_exclusao','ASC');
            }elseif($ordem == 'modo-exclusao-down'){
                $membresiaMembro->orderBy('exclusao_modo','DESC');
            }elseif($ordem == 'modo-exclusao-up'){
               $membresiaMembro->orderBy('exclusao_modo','ASC');
            }elseif($ordem == 'local-down'){
                $membresiaMembro->orderBy('congregacao_nome','DESC');
            }elseif($ordem == 'local-up'){
               $membresiaMembro->orderBy('congregacao_nome','ASC');
            }else{
                $membresiaMembro->orderBy('membresia_rolpermanente.dt_recepcao', 'DESC');
            }
            //$membresiaMembro->groupBy('membresia_membros.distrito_id', 'membresia_membros.id', 'membresia_membros.status', 'membresia_membros.nome', 'distrito.nome', 'igreja.nome', 'congregacao.nome', 'recepcao_modo.nome', 'exclusao_modo.nome', 'membresia_rolpermanente.dt_recepcao', 'membresia_rolpermanente.dt_exclusao');
           // dd($membresiaMembro->get());
           // dd($membrosTotal );
            $membrosTotal = $membresiaMembro->get()->count();
            if($params['pocesso'] == 'exportar'){
                $membros = $membresiaMembro->get();
            }else{
                $membros = $membresiaMembro->paginate($totalPorPagina)->appends([
                'distritoId' => $distritoId,
                'vinculo' => $vinculo,
                'situacao' => $situacao,
                'filtro' => $filtro,
                'dtInicial' => $dtInicial,
                'dtFinal' => $dtFinal,
                'ordem' => $ordem,
                'totalPorPagina' => $totalPorPagina,
                ]);
            }
            return ['membresiaMembro' =>  $membros, 'membresiaMembroTotal' => $membrosTotal];
        } else {
            $dtInicial = $params['dtInicial'];
            $dtFinal = $params['dtFinal'];
            $igrejaId = $params['igreja_id'];
            $membresiaMembro =  MembresiaMembro::select('membresia_membros.*', 'distrito.nome as distrito_nome', 'igreja.nome as igreja_nome', 'congregacao.nome as congregacao_nome',  DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = membresia_membros.id) AS telefone") )
            ->join('instituicoes_instituicoes as distrito', 'distrito.id', 'membresia_membros.distrito_id')
            ->join('instituicoes_instituicoes as igreja', 'igreja.id', 'membresia_membros.igreja_id')
            ->leftJoin('congregacoes_congregacoes as congregacao', 'congregacao.id', 'membresia_membros.congregacao_id')
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
            ->when($params['filtro'] == 'dt_recepcao', function  ($query) use( $dtInicial, $dtFinal) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_membros.status', 'A');
                });
                $query->when($dtInicial, fn ($query) => $query->where('membresia_membros.created_at', '>=' , $dtInicial));
                $query->when($dtFinal, fn ($query) => $query->where('membresia_membros.created_at', '<=' , $dtFinal));
            })
            ->when($params['filtro'] == 'dtExclusao', function ($query) use( $dtInicial, $dtFinal) {
                $query->where(function ($query) {
                    $query->withoutGlobalScopes();
                    $query->where('membresia_membros.status', 'I');
                });
                $query->when($dtInicial, fn ($query) => $query->where('membresia_membros.deleted_at', '>=' , $dtInicial));
                $query->when($dtFinal, fn ($query) => $query->where('membresia_membros.deleted_at', '<=' , $dtFinal));
            })
            ->when($params['filtro'], function ($query) use ($params) {
                if ($params['filtro'] == 'data_nascimento') {
                    return $this->handleFilterDtNascimento($query, $params['dtInicial'], $params['dtFinal']);
                } 
            })
            ->when($params['distritoId'], fn ($query) => $query->where('distrito.id', $params['distritoId']))
            ->where('membresia_membros.vinculo', $params['vinculo'])
            ->where('distrito.instituicao_pai_id', $regiaoId);
            //->orderBy('nome');

            if($ordem == 'distrito-down'){
                $membresiaMembro->orderBy('distrito.nome','DESC');
            }elseif($ordem == 'distrito-up'){
                $membresiaMembro->orderBy('distrito.nome','ASC');
            }elseif($ordem == 'igreja-down'){
                $membresiaMembro->orderBy('igreja.nome','DESC');
            }elseif($ordem == 'igreja-up'){
                $membresiaMembro->orderBy('igreja.nome','ASC');
            }elseif($ordem == 'rol-down'){
                $membresiaMembro->orderBy('membresia_membros.rol_atual','DESC');
            }elseif($ordem == 'rol-up'){
                $membresiaMembro->orderBy('membresia_membros.rol_atual','ASC');
            }elseif($ordem == 'nome-down'){
                $membresiaMembro->orderBy('membresia_membros.nome','DESC');
            }elseif($ordem == 'nome-up'){
                $membresiaMembro->orderBy('membresia_membros.nome','ASC');
            }elseif($ordem == 'telefone-down'){
                $membresiaMembro->orderBy('telefone','DESC');
            }elseif($ordem == 'telefone-up'){
               $membresiaMembro->orderBy('telefone','ASC');
            }elseif($ordem == 'situacao-down'){
                $membresiaMembro->orderBy('membresia_membros.status','DESC');
            }elseif($ordem == 'situacao-up'){
               $membresiaMembro->orderBy('membresia_membros.status','ASC');
            }elseif($ordem == 'vinculo-down'){
                $membresiaMembro->orderBy('membresia_membros.vinculo','DESC');
            }elseif($ordem == 'vinculo-up'){
               $membresiaMembro->orderBy('membresia_membros.vinculo','ASC');
            }elseif($ordem == 'nascimento-down'){
                $membresiaMembro->orderBy('membresia_membros.data_nascimento','DESC');
            }elseif($ordem == 'nascimento-up'){
               $membresiaMembro->orderBy('membresia_membros.data_nascimento','ASC');
            }elseif($ordem == 'recepcao-down'){
                $membresiaMembro->orderBy('membresia_membros.created_at','DESC');
            }elseif($ordem == 'recepcao-up'){
               $membresiaMembro->orderBy('membresia_membros.created_at','ASC');
            }elseif($ordem == 'modo-recepcao-down'){
                //$membresiaMembro->orderBy('recepcao_modo','DESC');
            }elseif($ordem == 'modo-recepcao-up'){
               //$membresiaMembro->orderBy('recepcao_modo','ASC');
            }elseif($ordem == 'exclusao-down'){
                $membresiaMembro->orderBy('membresia_membros.deleted_at','DESC');
            }elseif($ordem == 'exclusao-up'){
               $membresiaMembro->orderBy('membresia_membros.deleted_at','ASC');
            }elseif($ordem == 'modo-exclusao-down'){
                //$membresiaMembro->orderBy('exclusao_modo','DESC');
            }elseif($ordem == 'modo-exclusao-up'){
               //$membresiaMembro->orderBy('exclusao_modo','ASC');
            }elseif($ordem == 'local-down'){
                $membresiaMembro->orderBy('congregacao_nome','DESC');
            }elseif($ordem == 'local-up'){
               $membresiaMembro->orderBy('congregacao_nome','ASC');
            }else{
                $membresiaMembro->orderBy('membresia_membros.created_at', 'DESC');
            }

          ///  dd($membresiaMembro->get());

            $membrosTotal = $membresiaMembro->get()->count();
            
            $membros = $membresiaMembro->paginate($totalPorPagina)->appends([
                'distritoId' => $distritoId,
                'vinculo' => $vinculo,
                'situacao' => $situacao,
                'filtro' => $filtro,
                'dtInicial' => $dtInicial,
                'dtFinal' => $dtFinal,
                'totalPorPagina' => $totalPorPagina,
            ]);
            return ['membresiaMembro' =>  $membros, 'membresiaMembroTotal' => $membrosTotal];

        }
    

    }

    private function handleRolDates($query, $field, $dtInicial, $dtFinal)
    {
       // dd($field, $dtInicial, $dtFinal);
        return $query->whereHas('rolAtualSessionIgrejaId', function ($query) use ($field, $dtInicial, $dtFinal) {
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