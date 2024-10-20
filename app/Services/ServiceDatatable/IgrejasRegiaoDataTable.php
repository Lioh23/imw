<?php

namespace App\Services\ServiceDatatable;

use App\Models\VwIgreja;
use App\Traits\Identifiable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class IgrejasRegiaoDataTable extends Datatable implements DatatableInterface
{
    use Identifiable;

    public function getQueryBuilder($parameters = []): Builder
    {
        return VwIgreja::whereIn('distrito_id', Identifiable::fetchDistritosIdByRegiao(Identifiable::fetchtSessionRegiao()->id))
            ->whereNull('deleted_at')
            ->where('ativo', 1)
            ->when(isset($parameters['search']) && trim($parameters['search']), function ($query) use ($parameters) {
                $query->where('nome', 'like', "%{$parameters['search']}%");
            });
    }

    public function dataTable($queryBuilder, $requestData = [])
    {
        return DataTables::of($queryBuilder)
            ->order(function ($query) use ($requestData) {
                [$order] = $requestData["order"];

                $query->when($order['column'] == 0, fn($q) => $q->orderBy('cidade', $order['dir']));
                $query->when($order['column'] == 1, fn($q) => $q->orderBy('nome', $order['dir']));
                $query->when($order['column'] == 2, fn($q) => $q->orderBy('pastor', $order['dir']));
            })
            ->addColumn('actions', fn(VwIgreja $igreja) => view('igrejas-regiao.slice-actions', ['igreja' => $igreja]))
            ->make(true);
    }
}
