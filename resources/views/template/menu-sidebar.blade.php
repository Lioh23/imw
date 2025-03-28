 <style>
     #sidebar ul.menu-categories li.menu>#notificacao {
         background-color: inherit !important;
         color: inherit !important;
     }
 </style>
 <!--  BEGIN SIDEBAR  -->
 <div class="sidebar-wrapper sidebar-theme" style="overflow-y: scroll; scrollbar-width: thin; ">
     <nav id="sidebar">

         <ul class="navbar-nav theme-brand flex-row  text-center">
             <li class="nav-item theme-text">
                 <a href="/" class="nav-link"> IMWPGA </a>
             </li>
             <li class="nav-item toggle-sidebar">
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather sidebarCollapse feather-chevrons-left">
                     <polyline points="11 17 6 12 11 7"></polyline>
                     <polyline points="18 17 13 12 18 7"></polyline>
                 </svg>
             </li>
         </ul>
         <div class="shadow-bottom"></div>

         <ul class="list-unstyled menu-categories" id="accordionExample">
             <li class="menu text-center mb-2">

                 <div class="user-photo mb-2" style="text-align: center; ">
                     <img src="{{ asset('theme/assets/img/perfil.png') }}" alt="User"
                         style="width: 50px; height: 50px; border-radius: 50%;">
                 </div>
                 <div class="user-details" style="text-align: center;">
                     <b class="text-bold text-white" style="font-size: 12px ;">{{ $firstName }}
                         {{ $lastName }}</b><br>
                     @if (session('session_perfil'))
                     <span style="font-size: 12px ;">{{ session('session_perfil')->perfil_nome }}</span> <br>
                     <span style="font-size: 12px ;">{{ session('session_perfil')->instituicao_nome }}</span> <br>
                     @endif

                 </div>
             </li>

             <li class="menu active">
                 <a href="/" aria-expanded="true" class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-home">
                             <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                             <polyline points="9 22 9 12 15 12 15 22"></polyline>
                         </svg>
                         <span>Dashboard</span>
                     </div>
                 </a>
             </li>
             @if (optional($baseParams->notificacoesTransferencia)->count())
             <li class="menu container-fluid col-xs-4">
                 <a href="{{ route('notificacoes-tranferencia.index') }}" aria-expanded="false"
                     class="dropdown-toggle" id="notificacao">
                     <span class="badge badge-secondary" style="padding: 6px; border-radius: 6px;">Nova
                         Notificação
                     </span>
                 </a>
             </li>
             @endif

             <li class="menu menu-heading">
                 <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                         <circle cx="12" cy="12" r="10"></circle>
                     </svg><span>MENU PRINCIPAL</span></div>
             </li>

             @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-secretaria'))
             <li class="menu">
                 <a href="#secretaria" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-grid">
                             <rect x="3" y="3" width="7" height="7"></rect>
                             <rect x="14" y="3" width="7" height="7"></rect>
                             <rect x="14" y="14" width="7" height="7"></rect>
                             <rect x="3" y="14" width="7" height="7"></rect>
                         </svg>
                         <span>Secretaria</span>
                     </div>
                     <div>
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                             <polyline points="9 18 15 12 9 6"></polyline>
                         </svg>
                     </div>
                 </a>
                 <ul class="collapse submenu list-unstyled" id="secretaria" data-parent="#secretaria">
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('membros-index'))
                         <a href="{{ route('membro.index') }}">Membros</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('congregados-index'))
                         <a href="{{ route('congregado.index') }}">Congregados</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('visitantes-index'))
                         <a href="{{ route('visitante.index') }}">Visitantes</a>
                         @endif
                     </li>
                     <li>
                     <li class="submenu-fixo mt-3 mb-3">
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-relatorios-secretaria'))
                         <span>Relatórios</span>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('relatorio-membresia'))
                         <a href="{{ route('relatorio.membresia') }}">Membresia</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('relatorio-aniversariantes'))
                         <a href="{{ route('relatorio.aniversariantes') }}">Aniversariantes</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('relatorio-historico-eclesiastico'))
                         <a href="{{ route('relatorio.historico-eclesiastico') }}">Histórico
                             Eclesiástico</a>
                         @endif
                     </li>
                 </ul>
             </li>
             @endif





             @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-instituicoes'))
             <li class="menu">
                 <a href="/instituicoes-regiao?tipo_instituicao_id=1" class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
                             <rect x="3" y="3" width="7" height="7"></rect>
                             <rect x="14" y="3" width="7" height="7"></rect>
                             <rect x="14" y="14" width="7" height="7"></rect>
                             <rect x="3" y="14" width="7" height="7"></rect>
                         </svg>
                         <span>Instituicões</span>
                     </div>

                 </a>
             </li>
             @endif

             <li class="menu mx-3">
                 @if (auth()->check() && auth()->user()->hasPerfilRegra('instituicoes-igrejas'))
                 <a href="">Igrejas</a>
                 @endif
                 @if (auth()->check() && auth()->user()->hasPerfilRegra('instituicoes-igrejas'))
             <li class="menu">
                 <a href="{{ route('igrejas.regiao.index') }}" class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-church">
                             <path d="M12 2L8 6h8l-4-4z"></path>
                             <rect x="4" y="6" width="16" height="16" rx="2"></rect>
                             <path d="M8 12h8M12 16v4"></path>
                         </svg>
                         <span>Igrejas</span>
                     </div>
                 </a>
             </li>
             @endif
             </li>

             {{-- Menu Clérigos --}}

             <li class="menu mx-3">
                 @if (auth()->check() && auth()->user()->hasPerfilRegra('instituicoes-igrejas'))
                 <a href="">Clérigos</a>
                 @endif
                 @if (auth()->check() && auth()->user()->hasPerfilRegra('instituicoes-igrejas'))
             <li class="menu x-2">
                 <a href="#clerigos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                             <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                             <circle cx="12" cy="7" r="4"></circle>
                             <path d="M16 21v-2a4 4 0 0 0-3-3.87"></path>
                             <path d="M8 21v-2a4 4 0 0 1 3-3.87"></path>
                         </svg>

                         <span>Clérigos</span>
                     </div>
                     <div>
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                             <polyline points="9 18 15 12 9 6"></polyline>
                         </svg>
                     </div>
                 </a>
                 <ul class="collapse submenu list-unstyled" id="clerigos" data-parent="#clerigos">
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('instituicoes-igrejas'))
                         <a href="{{ route('clerigos.index') }}">Clérigos</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('instituicoes-igrejas'))
                         <a href="{{ route('clerigos.prebendas.index') }}">Prebendas</a>
                         @endif
                     </li>
                 </ul>
                 @endif


                 @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-financeiro'))
             <li class="menu">
                 <a href="#financeiro" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                             <line x1="12" y1="1" x2="12" y2="23"></line>
                             <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                         </svg>
                         <span>Financeiro</span>
                     </div>
                     <div>
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                             <polyline points="9 18 15 12 9 6"></polyline>
                         </svg>
                     </div>
                 </a>
                 <ul class="collapse submenu list-unstyled" id="financeiro" data-parent="#financeiro">
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-movimentocaixa-index'))
                         <a href="{{ route('financeiro.movimento.caixa') }}">Movimento de Caixa</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-consolidarcaixa'))
                         <a href="{{ route('financeiro.consolidar.caixa') }}">Consolidação de Caixa</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-planoconta'))
                         <a href="{{ route('financeiro.plano.conta') }}">Plano Conta</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-caixas'))
                         <a href="{{ route('financeiro.caixas') }}">Caixas</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('fornecedores-index'))
                         <a href="{{ route('fornecedor.index') }}">Fornecedores</a>
                         @endif
                     </li>


                     <li class="submenu-fixo mt-3 mb-3">
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-relatorios-financeiro'))
                         <span>Relatórios</span>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-movimento-diario'))
                         <a href="{{ route('financeiro.relatorio-movimento-diario') }}">Movimento Diário</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-livrocaixa'))
                         <a href="{{ route('financeiro.relatorio-livrocaixa') }}">Livro Caixa</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-balancete'))
                         <a href="{{ route('financeiro.relatorio-balancete') }}">Balancete</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-livrograde'))
                         <a href="{{ route('financeiro.relatorio-livrograde') }}">Livro Grade</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-livrorazao'))
                         <a href="{{ route('financeiro.relatorio-livrorazao') }}">Livro Razão</a>
                         @endif
                     </li>

                 </ul>
             </li>
             @endif

             @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-menu-relatorio'))
             <li class="menu">
                 <a href="#financeiro-distrito" data-toggle="collapse" aria-expanded="false"
                     class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                             <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                             <polyline points="14 2 14 8 20 8"></polyline>
                             <line x1="16" y1="13" x2="8" y2="13"></line>
                             <line x1="16" y1="17" x2="8" y2="17"></line>
                             <polyline points="10 9 9 9 8 9"></polyline>
                         </svg>
                         <span>Relatórios Distritais</span>
                     </div>
                     <div>
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                             <polyline points="9 18 15 12 9 6"></polyline>
                         </svg>
                     </div>
                 </a>
                 <ul class="collapse submenu list-unstyled" id="financeiro-distrito"
                     data-parent="#financeiro-distrito">
                     <li class="submenu-fixo mt-3 mb-3">
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-menu-relatorio'))
                         <span>Financeiro</span>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-relatorio-lancamento-das-igrejas'))
                         <a href="{{ route('distrito.relatorio.lancamentodasigrejas') }}">Lançamento das
                             Igrejas</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-relatorio-saldo-das-igrejas'))
                         <a href="{{ route('distrito.relatorio.saldodasigrejas') }}">Saldo das Igrejas</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-relatorio-livro-razao-geral'))
                         <a href="{{ route('distrito.relatorio.livrorazaogeral') }}">Livro Razão Geral</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-relatorio-orcamento'))
                         <a href="{{ route('distrito.relatorio.orcamento') }}">Orçamento</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-relatorio-variacao-financeira'))
                         <a href="{{ route('distrito.relatorio.variacaofinanceira') }}">Variação
                             Financeira</a>
                         @endif
                     </li>

                     <li class="submenu-fixo mt-3 mb-3">
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-menu-relatorio'))
                         <span>Membresia</span>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-relatorio-membros-ministerio'))
                         <a href="{{ route('distrito.relatorio.membrosministerio') }}">Membros por
                             Ministério</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-relatorio-quantidade-membros'))
                         <a href="{{ route('distrito.relatorio.quantidademembros') }}">Quantidade de
                             Membros</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-relatorio-estatistica-genero'))
                         <a href="{{ route('distrito.relatorio.estatisticagenero') }}">Estatística por
                             Gênero</a>
                         @endif
                     </li>
                 </ul>
             </li>
             @endif

             @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-menu-relatorio'))
             <li class="menu">
                 <a href="#financeiro-regiao" data-toggle="collapse" aria-expanded="false"
                     class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                             <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                             <polyline points="14 2 14 8 20 8"></polyline>
                             <line x1="16" y1="13" x2="8" y2="13"></line>
                             <line x1="16" y1="17" x2="8" y2="17"></line>
                             <polyline points="10 9 9 9 8 9"></polyline>
                         </svg>
                         <span>Relatórios Regionais</span>
                     </div>
                     <div>
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                             <polyline points="9 18 15 12 9 6"></polyline>
                         </svg>
                     </div>
                 </a>
                 <ul class="collapse submenu list-unstyled" id="financeiro-regiao"
                     data-parent="#financeiro-regiao">
                     <li class="submenu-fixo mt-3 mb-3">
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-menu-relatorio'))
                         <span>Financeiro</span>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-relatorio-lancamento-das-igrejas'))
                         <a href="{{ route('regiao.relatorio.lancamentodasigrejas') }}">Lançamento das
                             Igrejas</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-relatorio-saldo-das-igrejas'))
                         <a href="{{ route('regiao.relatorio.saldodasigrejas') }}">Saldo das Igrejas</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-relatorio-livro-razao-geral'))
                         <a href="{{ route('regiao.relatorio.livrorazaogeral') }}">Livro Razão Geral</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-relatorio-orcamento'))
                         <a href="{{ route('regiao.relatorio.orcamento') }}">Orçamento</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-relatorio-variacao-financeira'))
                         <a href="{{ route('regiao.relatorio.variacaofinanceira') }}">Variação Financeira</a>
                         @endif
                     </li>

                     <li class="submenu-fixo mt-3 mb-3">
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-menu-relatorio'))
                         <span>Membresia</span>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-relatorio-membros-ministerio'))
                         <a href="{{ route('regiao.relatorio.membrosministerio') }}">Membros por
                             Ministério</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-relatorio-quantidade-membros'))
                         <a href="{{ route('regiao.relatorio.quantidademembros') }}">Quantidade de Membros</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-relatorio-estatistica-genero'))
                         <a href="{{ route('regiao.relatorio.estatisticagenero') }}">Estatística por
                             Gênero</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-relatorio-estatistica-genero'))
                         <a href="{{ route('regiao.relatorio.estatisticaescolaridade') }}">Estatística por
                             Escolaridade</a>
                         @endif
                     </li>
                 </ul>
             </li>
             @endif

             @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-menu-estatistica'))
             <li class="menu">
                 <a href="#estatistica-regiao" data-toggle="collapse" aria-expanded="false"
                     class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                             <line x1="12" y1="20" x2="12" y2="10"></line>
                             <line x1="18" y1="20" x2="18" y2="4"></line>
                             <line x1="6" y1="20" x2="6" y2="16"></line>
                         </svg>

                         <span>Estatísticas</span>
                     </div>
                     <div>
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                             <polyline points="9 18 15 12 9 6"></polyline>
                         </svg>
                     </div>
                 </a>
                 <ul class="collapse submenu list-unstyled" id="estatistica-regiao"
                     data-parent="#estatistica-regiao">
                       <li class="submenu-fixo mt-3 mb-3">
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-menu-relatorio'))
                         <span>Membros</span>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-estatistica-membros-evolucao'))
                         <a href="{{ route('regiao.estatistica.evolucao') }}">Evolução</a>
                         @endif
                     </li>
                    <!--  <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-estatistica-membros-total'))
                         <a href="#">Total de Membros</a>
                         @endif
                     </li>
                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-estatistica-membros-recebimento-saida'))
                         <a href="#">Recebimento / Saída</a>
                         @endif
                     </li> -->
                    <!--  <li class="submenu-fixo mt-3 mb-3">
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-menu-relatorio'))
                         <span>Clérigos</span>
                         @endif
                     </li> -->
                     <!-- <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-estatistica-clerigo-faixa-etaria'))
                         <a href="#">Faixa Etária</a>
                         @endif
                     </li>

                     <li>
                         @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-estatistica-clerigo-recebimento-desligamento'))
                         <a href="#">Recebimento / Saída</a>
                         @endif
                     </li> -->
                 </ul>
             </li>
             @endif
             @if (auth()->check() && auth()->user()->hasPerfilRegra('congregacao-index'))
             <li class="menu">
                 <a href="/congregacao" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                         <x-bx-church />
                         <span>Congregações</span>
                     </div>
                 </a>
             </li>
             @endif

             @if (auth()->check() && auth()->user()->hasPerfilRegra('distrito-gestao-igrejas'))
             <li class="menu">
                 <a href="/igreja" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                         <x-bx-church />
                         <span>Igrejas</span>
                     </div>
                 </a>
             </li>
             @endif
             {{-- @if (auth()->check() && auth()->user()->hasPerfilRegra('regiao-gestao-igrejas'))
                 <li class="menu">
                     <a href="/igreja" aria-expanded="false" class="dropdown-toggle">
                         <div class="">
                             <x-bx-church />
                             <span>Igrejas</span>
                         </div>
                     </a>
                 </li>
             @endif --}}
             <li class="menu menu-heading">
                 <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                         <circle cx="12" cy="12" r="10"></circle>
                     </svg><span>APLICAÇÃO</span></div>
             </li>

             <li class="menu">
                 <a target="_blank" href="{{ route('selecionarPerfil') }}" aria-expanded="false"
                     class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-map">
                             <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                             <line x1="8" y1="2" x2="8" y2="18"></line>
                             <line x1="16" y1="6" x2="16" y2="22"></line>
                         </svg>
                         <span>Trocar Instituição</span>
                     </div>
                 </a>
             </li>

             <li class="menu">
                 <a href="#segurancaLocal" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                             <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                             <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                         </svg>
                         <span>Segurança</span>
                     </div>
                     <div>
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                             <polyline points="9 18 15 12 9 6"></polyline>
                         </svg>
                     </div>
                 </a>
                 <ul class="collapse submenu list-unstyled" id="segurancaLocal" data-parent="#segurancaLocal">
                     @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-usuarios-instituicao'))
                     @php
                     // Obtém o perfil_id da sessão
                     $perfilID = session('session_perfil')->perfil_id;

                     // Recupera o nível do perfil baseado no perfil_id
                     $perfilUsuario = \App\Models\Perfil::where('id', $perfilID)->first();

                     // Verifica o nível do perfil
                     $hrefRoute =
                     $perfilUsuario && $perfilUsuario->nivel === 'S'
                     ? route('admin.index')
                     : route('usuarios.index');
                     @endphp

                     <li>
                         <a href="{{ $hrefRoute }}"> Gerenciar usuários</a>
                     </li>
                     @endif

                 </ul>

                 <a href="#perfil" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                             <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                             <circle cx="12" cy="7" r="4"></circle>
                         </svg>
                         <span>Perfil</span>
                     </div>
                     <div>
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                             <polyline points="9 18 15 12 9 6"></polyline>
                         </svg>
                     </div>
                 </a>
                 <ul class="collapse submenu list-unstyled" id="perfil" data-parent="#perfil">
                     <li>
                         <a href="{{ route('perfil.index') }}"> Dados Pessoais</a>
                     </li>
                     @if(auth()->user()->pessoa_id)
                     <li>
                         <a href="{{ route('clerigos.perfil.dependentes.index') }}"> Dependentes</a>
                     </li>
                     <li>
                         <a href="{{ route('clerigos.perfil.prebendas.index') }}"> Prebendas</a>
                     </li>
                     <li>
                         <a href="{{ route('clerigos.perfil.impostoDeRenda.index') }}"> Imposto de Renda</a>
                     </li>

                        @if(App\Services\InformeRendimentos\ChecaArquivoExistenteService::execute(date('Y')))
                        <li>
                            <a href="{{ route('informe_rendimentos.exibirPdf', ['ano' => date('Y')]) }}" target="_blank">Informe de Rendimentos</a>
                        </li>
                        @endif
                     @endif
                 </ul>
             </li>

         </ul>

     </nav>
 </div>
 <!--  END SIDEBAR  -->
