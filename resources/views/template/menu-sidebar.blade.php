   <!--  BEGIN SIDEBAR  -->

   <div class="sidebar-wrapper sidebar-theme">
       <nav id="sidebar" style="overflow: hidden;">
           <ul class="navbar-nav theme-brand flex-row  text-center">
               <li class="nav-item theme-text">
                   <a href="index.html" class="nav-link"> {{ config('app.sigla') }} </a>
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
                       <span>{{ session('session_perfil')['perfil_nome'] }}</span> <br>
                       <span>{{ session('session_perfil')['instituicao_nome'] }}</span> <br>
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
                           <a href="/membro">Membros</a>
                       </li>
                       <li>
                           <a href="/congregado">Congregados</a>
                       </li>
                       <li>
                           <a href="/visitante">Visitantes</a>
                       </li>
                   </ul>
               </li>
               <li class="menu">
                   <a href="#financeiro" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-dollar-sign">
                               <line x1="12" y1="1" x2="12" y2="23"></line>
                               <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                           </svg>
                           <span>Financeiro</span>
                       </div>
                       <div>
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-chevron-right">
                               <polyline points="9 18 15 12 9 6"></polyline>
                           </svg>
                       </div>
                   </a>
                   <ul class="collapse submenu list-unstyled" id="financeiro" data-parent="#financeiro">
                       <li>
                           <a href="{{route('movimento.caixa')}}">Movimento de Caixa</a>
                       </li>
                       <li>
                           <a href="{{route('consolidar.caixa')}}">Consolidação de Caixa</a>
                       </li>
                       <li>
                           <a href="{{route('plano.conta')}}">Plano Conta</a>
                       </li>
                       <li>
                           <a href="{{route('caixas')}}">Caixas</a>
                       </li>
                       <li>
                           <a href="{{route('fornecedores')}}">Fornecedores</a>
                       </li>
                   </ul>
               </li>

               <li class="menu">
                   <a href="#relatorios" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-printer">
                               <polyline points="6 9 6 2 18 2 18 9"></polyline>
                               <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                               </path>
                               <rect x="6" y="14" width="12" height="8"></rect>
                           </svg>
                           <span>Relatórios</span>
                       </div>
                       <div>
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-chevron-right">
                               <polyline points="9 18 15 12 9 6"></polyline>
                           </svg>
                       </div>
                   </a>
                   <ul class="collapse submenu list-unstyled" id="relatorios" data-parent="#relatorios">
                       <li>
                           <a href="relMembresia/">Membresia</a>
                       </li>
                       <li>
                           <a href="relrolAtual/">Rol Atual</a>
                       </li>
                       <li>
                           <a href="relrolPermanente/">Rol Permanente</a>
                       </li>
                       <li>
                           <a href="relrolExcluidos/">Rol Excluídos</a>
                       </li>
                       <li>
                           <a href="relCongregados/">Congregados</a>
                       </li>
                       <li>
                           <a href="relVisitantes">Visitantes</a>
                       </li>
                       <li>
                           <a href="relAniversariantes">Aniversariantes</a>
                       </li>
                   </ul>
               </li>

               <li class="menu">
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
                           <a href="/perfil"> Meu Perfil </a>
                       </li>
                       <li>
                           <a href="{{ route('selecionarPerfil') }}"> Trocar Perfil </a>
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
