<?php 

namespace App\Services\ServiceDatatable;

use App\Models\RolMembro;
use App\Traits\Identifiable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;

class RolMembroDatatable extends Datatable implements DatatableInterface
{
    use Identifiable;

    public function getQueryBuilder($parameters = []): Builder
    {
        return RolMembro::with('notificacaoTransferenciaAtiva.igrejaDestino')
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->when(trim($parameters['search']), function ($query) use ($parameters) {
                $query->where('membro', 'like', "%{$parameters['search']}%");
            })
            ->when((isset($parameters['status']) && $parameters['status'] == 'rol_atual' || !isset($parameters['status'])), function ($query) {
                $query->where('status', 'A');
            })
            ->when(isset($parameters['status']) && $parameters['status'] == 'inativo', function ($query) {
                $query->where('status', 'I');
            })
            ->when(isset($parameters['status']) && $parameters['status'] == 'rol_permanente', function ($query) {
                $query->whereIn('status', ['A', 'I']);
            })
            ->when(isset($parameters['status']) && $parameters['status'] == 'has_errors', function ($query) {
                $query->where('has_errors', 1);
            });
    }

    public function dataTable($queryBuilder, $requestData = [])
    {
        return DataTables::of($queryBuilder)
            ->order(function ($query) use ($requestData) {
                [ $order ] = $requestData['order'];

                $query->when($order['column'] == 0, fn ($q) => $q->orderBy('numero_rol', $order['dir']))
                      ->when($order['column'] == 1, fn ($q) => $q->orderBy('membro', $order['dir']))
                      ->when($order['column'] == 2, fn ($q) => $q->orderBy('dt_recepcao', $order['dir']))
                      ->when($order['column'] == 3, fn ($q) => $q->orderBy('dt_exclusao', $order['dir']))
                      ->when($order['column'] == 4, fn ($q) => $q->orderBy('congregacao', $order['dir']));
            })
            ->addColumn('recepcao', function (RolMembro $rolMembro) {
                return $rolMembro->dt_recepcao ? $rolMembro->dt_recepcao->format('d/m/Y') : ''; 
            })
            ->addColumn('exclusao', function (RolMembro $rolMembro) {
                return $rolMembro->dt_exclusao ? $rolMembro->dt_exclusao->format('d/m/Y') : '';
            })
            ->addColumn('actions', function (RolMembro $rolMembro) {
                return view('membros.slice-actions', ['rolMembro' => $rolMembro]);
            })
            ->addColumn('igreja_atual', function (RolMembro $rolMembro) {
                return optional($rolMembro->igrejaAtual)->nome;
            })
            ->make(true);
    }
}