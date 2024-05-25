   <!--  BEGIN SIDEBAR  -->
   <div class="sidebar-wrapper sidebar-theme" style="overflow-y: auto; scrollbar-width: thin;">
       <nav id="sidebar" style="overflow: hidden;">
           <ul class="navbar-nav theme-brand flex-row  text-center">
               {{-- <li class="nav-item theme-text">
                   <a href="index.html" class="nav-link"> {{ config('app.sigla') }} </a>
               </li> --}}
               <li class="nav-item theme-text">
                   <a href="/" class="nav-link">
                       <img src="{{ asset('auth/images/logo_branco.png') }}" alt="{{ config('app.sigla') }}"
                           class="logo">
                   </a>
               </li>

               <li class="nav-item toggle-sidebar" aria-expanded="true" class="dropdown-toggle">
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                       fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                       stroke-linejoin="round" class="feather sidebarCollapse feather-chevrons-left">
                       <polyline points="11 17 6 12 11 7"></polyline>
                       <polyline points="18 17 13 12 18 7"></polyline>
                   </svg>
               </li>
           </ul>
           {{-- <div class="shadow-bottom"></div> --}}
           <div class="user-info">
               <div class="user-photo" style="text-align: center; margin-bottom: 13px;">
                   <img src="{{ asset('theme/assets/img/perfil.png') }}" alt="User"
                       style="width: 70px; height: 70px; border-radius: 50%;">
               </div>
               <div class="user-details" style="text-align: center;">
                   <h6 class="text-bold text-white">{{ $firstName }} {{ $lastName }}</h6>
                   @if (session('session_perfil'))
                       <span>{{ session('session_perfil')->perfil_nome }}</span> <br>
                       <span>{{ session('session_perfil')->instituicao_nome }}</span> <br>
                   @endif

               </div>
           </div>
           <ul class="list-unstyled menu-categories" id="accordionExample" style="margin-top: -35px;">
               <li class="menu">
                   <a href="/" aria-expanded="false" class="dropdown-toggle">
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
             {{--   @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-financeiro'))
                   <li class="menu">
                       <a href="#financeiro" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                           <div class="">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                   stroke-linecap="round" stroke-linejoin="round"
                                   class="feather feather-dollar-sign">
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
                           {{-- <li>
                            @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-livrorazao'))
                                <a href="{{ route('financeiro.relatorio-livrorazao') }}">Livro Razão</a>
                            @endif
                        </li> --}}
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

                       </ul>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                        <span>Trocar Instituição</span>
                    </div>
                </a>
            </li>

               <li class="menu">
                   <a href="#segurancaLocal" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-lock">
                               <rect x="3" y="11" width="18" height="11" rx="2" ry="2">
                               </rect>
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
                    <li>
                        <a href="{{ route('perfil.index') }}"> Meu Perfil</a>
                    </li>

                    @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-usuarios-instituicao'))
                       <li>
                           <a href="{{ route('usuarios.index') }}"> Usuários (Local)</a>
                       </li>
                    @endif
                    @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-todos-usuarios'))
                       <li>
                          <a href="{{ route('admin.index') }}"> Usuários (Geral)</a>
                       </li>
                    @endif
                   </ul>
               </li>
           </ul>
       </nav>

   </div>
   <!--  END SIDEBAR  -->
