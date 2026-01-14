<!-- TABELA -->
@if($membros_total > 0)
  <div class="col-lg-12 col-12 layout-spacing" id="conteudo-lista">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
          <div class="row">
              <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                  <h4 style="text-transform: uppercase">RELATÓRIO {{ isset($vinculos) ? $vinculos : '' }} - {{ $regiao_nome }}</h4>
                  <!-- <p class="pl-3">Registros Encontrados: {{ $membros_total }}</p>
                  <p class="pl-3">Vínculo: {{ isset($vinculos) ? $vinculos : '' }}</p>
                  <p class="pl-3">Situação: {{ $situacao }}</p>
                  <p class="pl-3">Local: {{ $ondeCongrega }}</p> -->
              </div>
          </div>
        </div>
        <div class="widget-content widget-content-area">
           <div id="conteudo">
            <div class="table-responsive">
              <div class="table_fixed_box">
                <table class="table table-bordered table-striped table-hover mb-4">
                    <thead>
                        <tr>
                            <th width=100px>
                              DISTRITO
                              <span id="distrito-order">
                                  <i class="fa-solid fa-caret-right float-right cursor-pointer-ordem ordenar" data-ordem="distrito-down"></i>
                              </span>
                            </th>
                            <th width=100px>
                              IGREJA
                              <span id="igreja-order">
                                  <i class="fa-solid fa-caret-right float-right cursor-pointer-ordem ordenar" data-ordem="igreja-down"></i>
                              </span>
                            </th>
                            <th width=55px>
                              ROL
                              <span id="rol-order">
                                  <i class="fa-solid fa-caret-right float-right cursor-pointer-ordem ordenar" data-ordem="rol-down"></i>
                              </span>
                            </th>
                            <th width=100px>
                              NOME
                              <span id="nome-order">
                                  <i class="fa-solid fa-caret-right float-right cursor-pointer-ordem ordenar" data-ordem="nome-down"></i>
                              </span>
                            </th>
                            <th width=100px>
                              TELEFONE
                              <span id="telefone-order">
                                  <i class="fa-solid fa-caret-right float-right cursor-pointer-ordem ordenar" data-ordem="telefone-down"></i>
                              </span>
                            </th>
                            <th width=100px>
                              SITUAÇÃO
                              <span id="situacao-order">
                                  <i class="fa-solid fa-caret-right float-right cursor-pointer-ordem ordenar" data-ordem="situacao-down"></i>
                              </span>
                            </th>
                            <th width=90px>
                              VÍNCULO
                              <span id="vinculo-order">
                                  <i class="fa-solid fa-caret-right float-right cursor-pointer-ordem ordenar" data-ordem="vinculo-down"></i>
                              </span>
                            </th>
                            <th width=120px>
                              NASCIMENTO
                              <span id="vinculo-order">
                                  <i class="fa-solid fa-caret-right float-right cursor-pointer-ordem ordenar" data-ordem="vinculo-down"></i>
                              </span>
                            </th>
                            <th width=110px>RECEPÇÃO
                              <span id="vinculo-order">
                                  <i class="fa-solid fa-caret-right float-right cursor-pointer-ordem ordenar" data-ordem="vinculo-down"></i>
                              </span>
                            </th>
                            <th>MODO</th>
                            <th>EXCLUSÃO</th>
                            <th>MODO</th>
                            <th>LOCAL</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($membros as $membro)
                          <tr>
                            <td>{{ $membro->distrito_nome }}</td>
                            <td>{{ $membro->igreja_nome }}</td>
                            <td>{{ $membro->rol_atual ?? 0 }}</td>
                            <td>{{ $membro->nome }}</td>
                            <td>{{ formatStr($membro->telefone, '## (##) #####-####') }}</td>
                            <td>
                              @if($membro->vinculo == 'M')
                                {{ $membro->status == 'A' ? 'ATIVO' : 'INATIVO' }}
                              @else
                                {{ $membro->statusText }}
                              @endif
                            </td>
                            <td>{{ $membro->vinculoText }}</td>
                            <td>{{ optional($membro->data_nascimento)->format('d/m/Y') }}</td>
                            <td>
                              @if($membro->vinculo == 'M')
                                  {{ $membro->dt_recepcao ? formatDate($membro->dt_recepcao) : '-' }}
                              @else
                                {{ optional($membro->created_at)->format('d/m/Y') }}
                              @endif
                            </td>
                            <td>{{ $membro->modo_recepcao ? $membro->modo_recepcao : '-' }}</td>
                            <td>
                              @if($membro->vinculo == 'M')
                                {{ $membro->dt_exclusao ? formatDate($membro->dt_exclusao) : '-'}}
                              @else
                                {{ optional($membro->deleted_at)->format('d/m/Y') }}
                              @endif
                            </td>
                            <td>{{ $membro->modo_exclusao ? $membro->modo_exclusao : '-' }}</td>
                            <td>{{ optional($membro->congregacao)->nome ?? 'SEDE' }}</td>
                          </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
            </div>
            <p style="background-color: #ececec85;">
                 Total de registros encontrados: {{ request()->totalPorPagina ? (request()->totalPorPagina > $total ? $total : request()->totalPorPagina) : 10 }} @if($total > 0)na página {{ request()->page ? request()->page : 1}} de {{ $total }}  @endif
            </p>
            <div>
               <select class="form-control " style="width: 10%; float: left;  font-size: 15px; height: 36px; padding: .0 1rem;" id="totalPorPagina">
                  @php
                      $numeros = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
                  @endphp
                  @foreach($numeros as $numero)
                      <option value='{{ $numero }}' {{ request()->input('totalPorPagina') == $numero ? 'selected' : '' }}>{{ $numero }}</option>
                  @endforeach
              </select>
              <input type="hidden" id="ordem" value="{{ request()->ordem }}">
              @if($links)
                  {{ $links->links('vendor.pagination.index') }}
              @endif
            </div>
        </div>
    </div>
  </div>
@endisset