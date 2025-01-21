<?php

namespace App\DataTables;

use App\Models\VwIgreja;
use App\Traits\Identifiable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class IgrejasRegiaoDataTable extends AbstractDatatable
{
    use Identifiable;

    protected function getQueryBuilder($parameters): Builder
    {
        return VwIgreja::whereIn('distrito_id', Identifiable::fetchDistritosIdByRegiao(Identifiable::fetchtSessionRegiao()->id))
            ->whereNull('deleted_at')
            ->where('ativo', 1)
            ->when(isset($parameters['search']) && trim($parameters['search']), function ($query) use ($parameters) {
                $query->where('nome', 'like', "%{$parameters['search']}%");
            });
    }

    protected function dataTable(Builder $queryBuilder, array $requestData): JsonResponse
    {
        return DataTables::of($queryBuilder)
            ->order(function ($query) use ($requestData) {
                [$order] = $requestData["order"];

                $query->when($order['column'] == 0, fn($q) => $q->orderBy('distrito', $order['dir']));
                $query->when($order['column'] == 1, fn($q) => $q->orderBy('nome', $order['dir']));
                $query->when($order['column'] == 2, fn($q) => $q->orderBy('pastor', $order['dir']));
            })
            ->addColumn('actions', fn(VwIgreja $igreja) => view('igrejas-regiao.slice-actions', ['igreja' => $igreja]))
            ->make(true);
    }
}
