@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Financeiro', 'url' => '/', 'active' => false],
    ['text' => 'Consolidação de Caixa', 'url' => '#', 'active' => true]
]"></x-breadcrumb>
@endsection
@section('content')
<div class="container-fluid">
    
</div>
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <!-- Conteúdo -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mt-3">Composição de Saldos por Caixa</h5>
                            <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                <thead class="thead-light">
                                    <tr>
            
                                        <th>CAIXA</th>
                                        <th width="80">ÚLTIMO SALDO CONSOLIDADO EM FEVEREIRO/2024</th>
                                        <th width="80">TOTAIS DE ENTRADAS</th>
                                        <th width="80">TOTAIS DE SAÍDAS</th>
                                        <th width="80">TRANSF. ENTRADAS</th>
                                        <th width="80">TRANSF. SAÍDAS</th>
                                        <th width="80">SALDO ATUAL</th>
            
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>BAZAR</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>14.446,12</td>
                                        <td>6.168,60</td>
                                        <td>15.978,32</td>
                                        <td>4.600,00</td>
                                        <td>0,00</td>
                                        <td>9.236,40</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa Comunicação</td>
                                        <td>874,20</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>874,20</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa da EBD</td>
                                        <td>671,18</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>671,18</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa Departamento de Ação Social</td>
                                        <td>448,94</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>448,94</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa Departamento Infantil</td>
                                        <td>30,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>30,00</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa Evangelismo</td>
                                        <td>546,90</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>546,90</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa Ministério de Casais</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa Ministério Homens</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa Ministério Mulheres</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa Missões (caixa bradesco)</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                    </tr>
                                    <tr>
                                        <td>Caixa Principal</td>
                                        <td>17.167,85</td>
                                        <td>10.454,13</td>
                                        <td>2.620,23</td>
                                        <td>0,00</td>
                                        <td>4.600,00</td>
                                        <td>20.401,75</td>
                                    </tr>
                                    <tr>
                                        <td>Cozinha</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                    </tr>
                                    <tr>
                                        <td>Ministério de Louvor</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                    </tr>
                                    <tr>
                                        <td>Modernização do Templo (obra)</td>
                                        <td>5.912,54</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>5.912,54</td>
                                    </tr>
                                    <tr>
                                        <th>Totais dos Caixas</th>
                                        <th>40.097,73</th>
                                        <th>16.622,73</th>
                                        <th>18.598,55</th>
                                        <th>4.600,00</th>
                                        <th>4.600,00</th>
                                        <th>38.121,91</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 mt-3">
                            <h5>Discriminação dos Lançamentos por Conta</h5>
                        </div>
            
                        <div class="col-12">
                            <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="2">CONTA / CAIXA</th>
                                        <th width="80">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th width="80">1.01.01</th>
                                        <th>Dizimo dos Membros</th>
                                        <th>14.050,30</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>6.022,60</td>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>8.027,70</td>
                                    </tr>
                                    <tr>
                                        <th width="80">1.01.07</th>
                                        <th>Dízimo dos Clérigos (100% conforme FIW 2022/2023)</th>
                                        <th>1.309,74</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>1.309,74</td>
                                    </tr>
                                    <tr>
                                        <th width="80">1.02.01</th>
                                        <th>Oferta de Culto</th>
                                        <th>807,75</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>146,00</td>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>661,75</td>
                                    </tr>
                                    <tr>
                                        <th width="80">1.02.02</th>
                                        <th>Ofertas Especiais</th>
                                        <th>100,00</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>100,00</td>
                                    </tr>
                                    <tr>
                                        <th width="80">1.07.01</th>
                                        <th>Imposto de Renda Retido - Clérigos</th>
                                        <th>354,94</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>354,94</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.01.01</th>
                                        <th>DESPESAS ADMINISTRATIVAS - Água</th>
                                        <th>1.283,55</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>1.283,55</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.01.06</th>
                                        <th>DESPESAS ADMINISTRATIVAS - Material de Escritório</th>
                                        <th>1,10</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>1,10</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.01.08</th>
                                        <th>DESPESAS ADMINISTRATIVAS - Gás (botija ou encanado)</th>
                                        <th>115,90</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>115,90</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.01.11</th>
                                        <th>DESPESAS ADMINISTRATIVAS - Impressos</th>
                                        <th>5,00</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>5,00</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.01.15</th>
                                        <th>DESPESAS ADMINISTRATIVAS - Ajuda de Custo Excedente para Clérigos</th>
                                        <th>2.890,00</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>2.890,00</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.01.16</th>
                                        <th>DESPESAS ADMINISTRATIVAS - Anuênio (verba de representação) para Clérigos</th>
                                        <th>789,00</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>789,00</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.01.21</th>
                                        <th>DESPESAS ADMINISTRATIVAS - Fotocópias</th>
                                        <th>5,00</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>5,00</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.01.99</th>
                                        <th>DESPESAS ADMINISTRATIVAS - Outras</th>
                                        <th>145,00</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>145,00</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.02.01</th>
                                        <th>DESPESAS PASTORAIS - Subsídios (prebendas)</th>
                                        <th>6.972,50</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>6.972,50</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.02.03</th>
                                        <th>DESPESAS PASTORAIS - CAW</th>
                                        <th>631,20</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>631,20</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.03.01</th>
                                        <th>AQUISIÇÕES - Equipamentos de Som</th>
                                        <th>139,94</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>139,94</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.05.01</th>
                                        <th>CONSERVAÇÃO - Material de Limpeza e Higiene</th>
                                        <th>140,00</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>140,00</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.10.02</th>
                                        <th>CONSTRUÇÕES - Materiais</th>
                                        <th>307,55</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>307,55</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.11.01</th>
                                        <th>DESPESAS FINANCEIRAS - Tarifas Bancárias</th>
                                        <th>183,68</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>183,68</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.13.07</th>
                                        <th>EVENTOS - Encontros</th>
                                        <th>768,28</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>768,28</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.17.10</th>
                                        <th>MINISTÉRIOS - Ceia do Senhor</th>
                                        <th>161,46</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>161,46</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.18.01</th>
                                        <th>SECRETARIAS - SRF - Regional de Finanças (COTA ÚNICA)</th>
                                        <th>3.704,45</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>3.704,45</td>
                                    </tr>
                                    <tr>
                                        <th width="80">2.18.11</th>
                                        <th>SECRETARIAS - SRF/SRA - IR - Repasse Imposto Retido de Clérigos</th>
                                        <th>354,94</th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>354,94</td>
                                    </tr>
                                    <tr>
                                        <th width="80">3.02</th>
                                        <th>TRANSFERÊNCIAS - Depósito em Conta Corrente</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Banco Bradesco</td>
                                        <td>4.600,00</td>
                                    </tr>
                                    <tr>
                                        <td width="80"></td>
                                        <td>Caixa Principal</td>
                                        <td>4.600,00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
            
                        <div class="col-12">
                            <div class="alert alert-warning alert-dismissible mt-3" role="alert">
                                <div class="alert-message">
                                    <strong>Atenção!</strong> A conta [ 2.01.02 - DESPESAS ADMINISTRATIVAS - Luz/Energia ]
                                    considerada essencial não possui lançamentos, tem certeza que deseja continuar a
                                    consolidação?
                                </div>
            
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
            
                        <div class="col-12">
                            <form method="post">
                                <button class="btn btn-success p-2" type="submit">CONSOLIDAR O MÊS DE MARÇO DE 2024</button>
                            </form>
                        </div>
                    </div>
                </div>
             <!-- Fim do Conteúdo -->
        </div>
    </div>
</div>
@endsection