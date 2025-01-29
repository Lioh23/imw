<?php 

namespace App\DataTables;

use App\Models\CongregacoesCongregacao;
use App\Traits\Identifiable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class CongregacoesDatatable extends AbstractDatatable
{
    use Identifiable;

    public function getQueryBuilder(array $parameters): Builder
    {
        return CongregacoesCongregacao::query()
            ->where('instituicao_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $query->where(function ($subQuery) use ($parameters) {
                    $subQuery->where('nome', 'like', '%'.$parameters['search'].'%');
                });
            })
            ->withTrashed();
    }

    public function dataTable(Builder $queryBuilder, array $requestData): JsonResponse
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