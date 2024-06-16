<?php 

namespace App\Services\ServiceDatatable;

use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class VisitantesDatatable extends Datatable implements DatatableInterface
{
    use Identifiable;

    public function getQueryBuilder($parameters = []): Builder
    {
        return MembresiaMembro::with('contato')
            ->leftJoin('membresia_contatos', 'membresia_contatos.membro_id', '=', 'membresia_membros.id')
            ->select('membresia_membros.*', 'membresia_contatos.telefone_preferencial', 'membresia_contatos.email_preferencial')
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->where('vinculo', MembresiaMembro::VINCULO_VISITANTE)
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $query->where('nome', 'like', "%{$parameters['search']}%");
            })
            ->when($parameters['excluido'] == 1, function ($query) { 
                $query->onlyTrashed();
            });
    }

    public function dataTable($queryBuilder, $requestData = [])
    {
        return DataTables::of($queryBuilder)
            ->order(function ($query) use ($requestData) {
                [ $order ] = $requestData['order'];

                $query->when($order['column'] == 0, fn ($q) => $q->orderBy('nome', $order['dir']))
                      ->when($order['column'] == 1, fn ($q) => $q->orderBy('telefone_preferencial', $order['dir']))
                      ->when($order['column'] == 2, fn ($q) => $q->orderBy('email_preferencial', $order['dir']))
                      ->when($order['column'] == 3, fn ($q) => $q->orderBy('updated_at', $order['dir']));

            })
            ->editColumn('updated_at', function (MembresiaMembro $visitante) {
                return $visitante->updated_at->format('d/m/Y H:i:s');
            })
            ->editColumn('telefone_preferencial', function (MembresiaMembro $visitante) {
                return formatarTelefone($visitante->telefone_preferencial);
            })
            ->addColumn('actions', function (MembresiaMembro $visitante) {
                return view('visitantes.slice-actions', ['visitante' => $visitante]);
            })
            ->make(true);
    }
}