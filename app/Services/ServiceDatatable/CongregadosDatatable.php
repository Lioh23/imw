<?php 

namespace App\Services\ServiceDatatable;

use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class CongregadosDatatable extends Datatable implements DatatableInterface
{
    use Identifiable;

    public function getQueryBuilder($parameters = []): Builder
    {
        return MembresiaMembro::with('congregacao')
            ->select('membresia_membros.*', 'congregacoes_congregacoes.nome as congregacao')
            ->leftJoin('congregacoes_congregacoes', 'congregacoes_congregacoes.id', '=', 'membresia_membros.congregacao_id')
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->where('vinculo', MembresiaMembro::VINCULO_CONGREGADO)
            ->when($parameters['search'], function ($query) use ($parameters) {
                $query->where('membresia_membros.nome', 'like', "%{$parameters['search']}%");
            })
            ->when($parameters['status'] == 'has_errors', function ($query) {
                $query->where('has_errors', 1);
            })
            ->when($parameters['status'] == 'inativo', function ($query) {
                $query->onlyTrashed();
            });
    }

    public function dataTable($queryBuilder, $requestData = [])
    {
        return DataTables::of($queryBuilder)
            ->order(function ($query) use ($requestData) {
                [ $order ] = $requestData['order'];

                $query->when($order['column'] == 0, fn ($q) => $q->orderBy('nome', $order['dir']))
                      ->when($order['column'] == 1, fn ($q) => $q->orderBy('congregacao', $order['dir']));              
            })
            ->addColumn('actions', function (MembresiaMembro $congregado) {
                return view('congregados.slice-actions', ['congregado' => $congregado]);
            })
            ->make(true);
    }
}