<?php

namespace App\Calculators\ImpostoDeRenda;

use App\Dtos\ImpostoDeRenda\ProgressaoIrDto;
use App\Dtos\ImpostoDeRenda\ResponseIrDto;
use App\Models\DeducaoIr;
use App\Models\TabelaIr;
use App\Traits\FormatterUtils;

class ImpostoDeRendaSimplificadoCalculator implements ImpostoDeRendaCalculatorInterface
{
    use FormatterUtils;

    private ResponseIrDto $responseIrDto;

    public function __construct()
    {
        $this->responseIrDto = new ResponseIrDto;
    }

    public function calculate(int $ano, float $rendimentosTributaveis, int $qtdeDependentes = 0): ResponseIrDto
    {
        $this->responseIrDto->ano = $ano;
        $this->responseIrDto->rendimentosTributaveis = $rendimentosTributaveis;
        $this->responseIrDto->qtdeDependentes = $qtdeDependentes;

        $this->handleValorDedutivelDependentes($ano, $qtdeDependentes);
        $this->handleIrCalculation($ano);

        return $this->responseIrDto;
    }

    private function handleValorDedutivelDependentes(int $ano, int $qtdeDependentes): void
    {
        $deducoes = DeducaoIr::where('ano', $ano)->where('simplificado', false)->first();
        $deducaoSimplificada = DeducaoIr::where('ano', $ano)->where('simplificado', true)->first();

        $totalDeducoes = $deducoes->valor * $qtdeDependentes;

        $this->responseIrDto->valorDedutivel = $totalDeducoes > $deducaoSimplificada->valor
            ? $totalDeducoes
            : $deducaoSimplificada->valor;

        $this->responseIrDto->valorBase = $this->responseIrDto->rendimentosTributaveis - $this->responseIrDto->valorDedutivel;
    }

    private function handleIrCalculation(int $ano): void
    {
        $faixas = TabelaIr::where('ano', $ano)->get();

        $valorBaseADeduzir = $this->responseIrDto->valorBase;
        $somaImposto = 0;

        foreach ($faixas as $faixa) {
            $valorImposto = $this->handleValorImposto($valorBaseADeduzir, $faixa);

            $this->responseIrDto->progressao->push($this->makeProgressaoIr($faixa, $valorImposto));

            $valorBaseADeduzir -= $faixa->deducao_faixa;
            $somaImposto += $valorImposto;
        }

        $this->responseIrDto->valorImposto = $somaImposto;
    }

    private function handleValorImposto($valorBaseADeduzir, TabelaIr $faixa)
    {
        if ($valorBaseADeduzir <= 0 || $faixa->faixa == 1) return 0;

        return $valorBaseADeduzir < $faixa->deducao_faixa
            ? round($valorBaseADeduzir * ($faixa->aliquota / 100), 4)
            : round($faixa->deducao_faixa * ($faixa->aliquota / 100), 4);
    }

    private function makeProgressaoIr(TabelaIr $faixa, float $valorImposto): ProgressaoIrDto
    {
        $dto = new ProgressaoIrDto();
        $dto->faixa = $faixa->faixa;
        $dto->aliquota = $faixa->aliquota;
        $dto->valorImposto = $valorImposto;

        // text aliquota
        if ($faixa->valor_min == 0) {
            $valorMaximo = $this->formatCurrencyBRL($faixa->valor_max, true);
            $dto->textBaseCalculo = "Até $valorMaximo";

        } else if (!$faixa->valor_max) {
            $valorMinimo = $this->formatCurrencyBRL($faixa->valor_min, true);
            $dto->textBaseCalculo = "$valorMinimo ou maior";

        } else {
            $valorMaximo = $this->formatCurrencyBRL($faixa->valor_max, true);
            $valorMinimo = $this->formatCurrencyBRL($faixa->valor_min, true);
            $dto->textBaseCalculo = "$valorMinimo até $valorMaximo";
        }

        return $dto;
    }
}
