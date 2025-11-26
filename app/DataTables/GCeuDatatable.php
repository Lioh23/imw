<?php 

namespace App\DataTables;

use App\Models\GCeu;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class GCeuDatatable extends AbstractDatatable
{
    use Identifiable;

    public function getQueryBuilder($parameters = []): Builder
    {
        $instituicao_id = Identifiable::fetchSessionIgrejaLocal()->id;
        return GCeu::select('gceu_cadastros.*', 'instituicoes_instituicoes.nome as instituicao')
            ->join('instituicoes_instituicoes', 'instituicoes_instituicoes.id', '=', 'gceu_cadastros.instituicao_id')
            ->where('gceu_cadastros.instituicao_id', $instituicao_id)
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $query->where('nome', 'like', "%{$parameters['search']}%");
            })
            ->when($parameters['excluido'] == 1, function ($query) { 
                $query->onlyTrashed();
            });
    }

    public function dataTable(Builder $queryBuilder, array $requestData): JsonResponse
    {
        return DataTables::of($queryBuilder)
            ->order(function ($query) use ($requestData) {
                [ $order ] = $requestData['order'];

                $query->when($order['column'] == 0, fn ($q) => $q->orderBy('nome', $order['dir']))
                      ->when($order['column'] == 1, fn ($q) => $q->orderBy('anfitriao', $order['dir']))
                      ->when($order['column'] == 2, fn ($q) => $q->orderBy('contato', $order['dir']))
                      ->when($order['column'] == 3, fn ($q) => $q->orderBy('instituicao', $order['dir']))
                      ->when($order['column'] == 4, fn ($q) => $q->orderBy('created_at', $order['dir']));

            })
            ->editColumn('created_at', function (GCeu $gceu) {
                return $gceu->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('contato', function (GCeu $gceu) {
                return formatarTelefone($gceu->contato);
            })
            ->addColumn('actions', function (GCeu $gceu) {
                return view('gceu.slice-actions', ['gceu' => $gceu]);
            })
            ->make(true);
    }
}
