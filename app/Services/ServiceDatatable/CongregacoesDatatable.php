<?php 

namespace App\Services\ServiceDatatable;

use App\Models\CongregacoesCongregacao;
use App\Traits\Identifiable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class CongregacoesDatatable extends Datatable implements DatatableInterface
{
    use Identifiable;

    public function getQueryBuilder($parameters = []): Builder
    {
        return CongregacoesCongregacao::query()
            ->where('instituicao_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $query->where(function ($subQuery) use ($parameters) {
                    $subQuery->where('congregacoes_congregacoes.nome', 'like', '%'.$parameters['search'].'%')
                             ->orWhere('instituicoes_instituicoes.nome', 'like', '%'.$parameters['search'].'%');
                });
            })
            ->withTrashed();
    }

    public function dataTable($queryBuilder, $requestData = [])
    {
        return DataTables::of($queryBuilder)
            ->order(function ($query) use ($requestData) {
                [ $order ] = $requestData['order'];

                $query->when($order['column'] == 0, fn ($q) => $q->orderBy('nome', $order['dir']))
                      ->when($order['column'] == 1, fn ($q) => $q->orderBy('bairro', $order['dir']));
            })
            ->addColumn('actions', function (CongregacoesCongregacao $congregacao) {
                return view('congregacoes.slice-actions', ['congregacao' => $congregacao]);
            })
            ->make(true);
    }
}