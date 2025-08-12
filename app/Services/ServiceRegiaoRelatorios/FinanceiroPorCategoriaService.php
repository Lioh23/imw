<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Traits\Identifiable;
use App\Traits\FinanceiroPorCategoria;
use Carbon\Carbon;

class FinanceiroPorCategoriaService
{
    use FinanceiroPorCategoria;
    use Identifiable;

    public function execute($dataInicial, $dataFinal, $categoriaId)
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        $dataInicialFormatada = formatDate($dataInicial);
        $dataFinalFormatada = formatDate($dataFinal);
        $categoria = FinanceiroPorCategoria::categoria($categoriaId);
        if(isset($dataFinal)) {
            $data =  [
                'dados' => FinanceiroPorCategoria::fetch($dataInicial, $dataFinal, $regiao, $categoriaId),
                'titulo' => "Relatório Financeiro da Categoria $categoria->nome no período $dataInicialFormatada à $dataFinalFormatada"
            ];
        }else{
            $data['titulo'] = "";
        }
        $data['categorias'] = FinanceiroPorCategoria::categorias();
        return $data ;
    }        
}
