   <!--  BEGIN SIDEBAR  -->

   <div class="sidebar-wrapper sidebar-theme">
       <nav id="sidebar" style="overflow: hidden;">
           <ul class="navbar-nav theme-brand flex-row  text-center">
               {{-- <li class="nav-item theme-text">
                   <a href="index.html" class="nav-link"> {{ config('app.sigla') }} </a>
               </li> --}}
               <li class="nav-item theme-text">
                   <a href="/" class="nav-link">
                       <img src="{{ asset('auth/images/logo_branco.png') }}" alt="{{ config('app.sigla') }}" class="logo">
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
                       </ul>
                   </li>
               @endif
               @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-relatorios-secretaria'))
               <li class="menu">
                   <a href="#relatorios" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                               viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                               stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                               <polyline points="6 9 6 2 18 2 18 9"></polyline>
                               <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                               </path>
                               <rect x="6" y="14" width="12" height="8"></rect>
                           </svg>
                           <span>Relatórios - Secretaria</span>
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
                   <ul class="collapse submenu list-unstyled" id="relatorios" data-parent="#relatorios">
                       <li>
                           @if (auth()->check() && auth()->user()->hasPerfilRegra('relmembresia-index'))
                                <a href="{{ route('relatorio.membresia') }}">Membresia</a>
                           @endif
                       </li>
                       <li>
                           @if (auth()->check() && auth()->user()->hasPerfilRegra('relaniversariantes-index'))
                               <a href="#">Aniversariantes</a>
                           @endif
                       </li>
                   </ul>
               </li>
           @endif
               @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-financeiro'))
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
                           
                       </ul>
                   </li>
               @endif

               @if (auth()->check() && auth()->user()->hasPerfilRegra('menu-relatorios-financeiro'))
                   <li class="menu">
                       <a href="#relatorios-financeiros" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                           <div class="">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                   stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                                   <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                   <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                   </path>
                                   <rect x="6" y="14" width="12" height="8"></rect>
                               </svg>
                               <span>Relatórios - Financeiro</span>
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
                       <ul class="collapse submenu list-unstyled" id="relatorios-financeiros" data-parent="#relatorios-financeiros">
                           <li>
                            @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-movimento-diario'))
                               <a href="{{ route('financeiro.relatorio-movimento-diario') }}">Movimento Diário</a>
                            @endif
                          </li>
                          <li>
                           @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-livrorazao'))
                              <a href="{{ route('financeiro.relatorio-livrorazao') }}">Livro Razão</a>
                           @endif
                         </li>
                         <li>
                           @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-livrocaixa'))
                              <a href="{{ route('financeiro.relatorio-livrocaixa') }}">Livro Caixa</a>
                           @endif
                         </li>
                         <li>
                           @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-livrograde'))
                              <a href="{{ route('financeiro.relatorio-livrograde') }}">Livro Grade</a>
                           @endif
                         </li>
                         <li>
                           @if (auth()->check() && auth()->user()->hasPerfilRegra('financeiro-relatorio-balancete'))
                              <a href="{{ route('financeiro.relatorio-balancete') }}">Balancete</a>
                           @endif
                         </li>
                       </ul>
                   </li>
               @endif

               {{--  <li class="menu">
                   <a href="#impressos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-file-text">
                               <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                               <polyline points="14 2 14 8 20 8"></polyline>
                               <line x1="16" y1="13" x2="8" y2="13"></line>
                               <line x1="16" y1="17" x2="8" y2="17"></line>
                               <polyline points="10 9 9 9 8 9"></polyline>
                           </svg>
                           <span>Impressos</span>
                       </div>
                       <div>
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-chevron-right">
                               <polyline points="9 18 15 12 9 6"></polyline>
                           </svg>
                       </div>
                   </a>
                   <ul class="collapse submenu list-unstyled" id="impressos" data-parent="#impressos">
                       <li>
                           <a href="impTeste1/"> Impressos Teste</a>
                       </li>
                       <li>
                           <a href="impTeste2/"> Impressos Teste</a>
                       </li>
                       <li>
                           <a href="impTeste3"> Impressos Teste</a>
                       </li>
                   </ul>
               </li>
 --}}
               <li class="menu menu-heading">
                   <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                           viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                           stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                           <circle cx="12" cy="12" r="10"></circle>
                       </svg><span>APLICAÇÃO</span></div>
               </li>

               <li class="menu">
                   <a href="#seguranca" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-box">
                               <path
                                   d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                               </path>
                               <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                               <line x1="12" y1="22.08" x2="12" y2="12"></line>
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
                   <ul class="collapse submenu list-unstyled" id="seguranca" data-parent="#seguranca">
                       <li>
                           <a href="{{ route('perfil.index') }} "> Meu Perfil </a>
                       </li>
                       <li>
                           <a href="{{ route('selecionarPerfil') }}"> Trocar Instituição </a>
                       </li>
                       <li>
                           <a href="{{ route('usuarios.index') }}"> Usuários </a>
                       </li>
                   </ul>
               </li>

               <li class="menu">
                   <a target="_blank" href="https://www.brasmid.com.br/imwplus/doc" aria-expanded="false"
                       class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-book">
                               <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                               <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                           </svg>
                           <span>Documentação</span>
                       </div>
                   </a>
               </li>
           </ul>
       </nav>

   </div>
   <!--  END SIDEBAR  -->
