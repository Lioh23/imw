<style>
    .bold {
        font-weight: bold;
    }
</style>

<div>
    <div class="mt-5">
        <h3 class="fs-6 my-3">Calculo do Imposto de Renda {{ $data->ano }}</h3>
        <table class="table table-bordered table-striped table-hover mb-4" id="datatable">
            <tbody>
                <tr class="d-flex flex-column">
                    <td class="d-flex justify-content-between bold">
                        <p>Redimento Tributáveis:</p>
                        R$ {{ number_format($data->rendimentosTributaveis, 2, ',', '.') ?? 'Não informado' }}
                    </td>
                    <td class="d-flex justify-content-between">
                        <p>Número de dependentes:</p>
                        {{ $data->qtdeDependentes }}
                    </td>
                    <td class="d-flex justify-content-between">
                        <p>Valor dedútivel:</p>
                        R$ {{ number_format($data->valorDedutivel, 2, ',', '.') ?? 'Não informado' }}
                    </td>
                    <td class="d-flex justify-content-between">
                        <p>Valor Base:</p>
                        R$ {{ number_format($data->valorBase, 2, ',', '.') ?? 'Não informado' }}
                    </td>
                    <td class="d-flex justify-content-between bold">
                        <p>Valor de Imposto:</p>
                        R$ {{ number_format($data->valorImposto, 2, ',', '.') ?? 'Não informado' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <table class="table table-bordered table-striped table-hover mb-4" id="datatable">
            <thead>
                <tr>
                    <th>Faixa</th>
                    <th>Base Calculo</th>
                    <th>Aliquota</th>
                    <th>Valor do Imposto</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($data->progressao as $faixa)
                    <tr>
                        <td>{{ $faixa->faixa }}</td>
                        <td>{{ $faixa->textBaseCalculo }}</td>
                        <td>{{ number_format($faixa->aliquota, 1, ',') }}%</td>
                        <td>R$ {{ number_format($faixa->valorImposto, 2, ',', '.') }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
