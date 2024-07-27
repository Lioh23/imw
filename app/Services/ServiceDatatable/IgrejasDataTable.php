<?php 

namespace App\Services\ServiceDatatable;

use App\Models\VwIgreja;
use App\Traits\Identifiable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class IgrejasDataTable extends Datatable implements DatatableInterface
{
    use Identifiable;

    public function getQueryBuilder($parameters = []):  Builder
    {
        return VwIgreja::where('distrito_id', Identifiable::fetchtSessionDistrito()->id)
            ->when(isset($parameters['search']) && trim($parameters['search']), function ($query) use ($parameters) {
                $query->where('nome', 'like', "%{$parameters['search']}%");
            });
    }

    public function dataTable($queryBuilder, $requestData = [])
    {
        return DataTables::of($queryBuilder)
            ->addColumn('actions', function (VwIgreja $igreja) {
                return view('igrejas.slice-actions', ['igreja' => $igreja]);
            })
            ->make(true);
    }
}