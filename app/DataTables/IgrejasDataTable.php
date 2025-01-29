<?php 

namespace App\DataTables;

use App\Models\VwIgreja;
use App\Traits\Identifiable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class IgrejasDataTable extends AbstractDatatable
{
    use Identifiable;

    protected function getQueryBuilder(array $parameters):  Builder
    {
        return VwIgreja::where('distrito_id', Identifiable::fetchtSessionDistrito()->id)
            ->when(isset($parameters['search']) && trim($parameters['search']), function ($query) use ($parameters) {
                $query->where('nome', 'like', "%{$parameters['search']}%");
            });
    }

    protected function dataTable(Builder $queryBuilder, array $requestData): JsonResponse
    {
        return DataTables::of($queryBuilder)
            ->order(function ($query) use ($requestData) {
                [ $order ] = $requestData["order"];

                $query->when($order['column'] == 0, fn ($q) => $q->orderBy('cidade', $order['dir']));
                $query->when($order['column'] == 1, fn ($q) => $q->orderBy('nome', $order['dir']));
                $query->when($order['column'] == 2, fn ($q) => $q->orderBy('pastor', $order['dir']));
            })
            ->addColumn('actions', fn (VwIgreja $igreja) => view('igrejas.slice-actions', ['igreja' => $igreja]))
            ->make(true);
    }
}
