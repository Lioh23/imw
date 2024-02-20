   <!--  BEGIN SIDEBAR  -->
   <div class="sidebar-wrapper sidebar-theme">
       <nav id="sidebar" style="overflow: hidden;">
           <ul class="navbar-nav theme-brand flex-row  text-center">
               <li class="nav-item theme-text">
                   <a href="index.html" class="nav-link"> {{ config('app.sigla') }} </a>
               </li>
               <li class="nav-item toggle-sidebar" aria-expanded="true" class="dropdown-toggle">
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather sidebarCollapse feather-chevrons-left">
                       <polyline points="11 17 6 12 11 7"></polyline>
                       <polyline points="18 17 13 12 18 7"></polyline>
                   </svg>
               </li>
           </ul>
           {{-- <div class="shadow-bottom"></div> --}}
           <div class="user-info">
               <div class="user-photo" style="text-align: center; margin-bottom: 13px;">
                   <img src="https://via.placeholder.com/40" alt="User" style="width: 40px; height: 40px; border-radius: 50%;">
               </div>
               <div class="user-details" style="text-align: center;">
                   <span>Vinicius Almeida</span><br>
                   <span>Administrador</span>
               </div>
           </div>
           <ul class="list-unstyled menu-categories" id="accordionExample" style="margin-top: -35px;">
               <li class="menu">
                   <a href="/" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                               <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                               <polyline points="9 22 9 12 15 12 15 22"></polyline>
                           </svg>
                           <span>Dashboard</span>
                       </div>
                   </a>
               </li>

               <li class="menu menu-heading">
                   <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                           <circle cx="12" cy="12" r="10"></circle>
                       </svg><span>SECRETARIA</span></div>
               </li>

               <li class="menu">
                   <a href="/membro" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                               <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                               <circle cx="9" cy="7" r="4"></circle>
                               <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                               <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                           </svg>
                           <span>Membros</span>
                       </div>
                   </a>
               </li>

               <li class="menu">
                   <a href="/congregado" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                               <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                               <circle cx="9" cy="7" r="4"></circle>
                               <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                               <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                           </svg>
                           <span>Congregados</span>
                       </div>
                   </a>
               </li>

               <li class="menu">
                   <a href="/visitante" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                               <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                               <circle cx="9" cy="7" r="4"></circle>
                               <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                               <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                           </svg>
                           <span>Visitantes</span>
                       </div>
                   </a>
               </li>

               <li class="menu">
                   <a href="#" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open">
                               <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                               <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                           </svg>
                           <span>Livro Grade</span>
                       </div>
                   </a>
               </li>

               <li class="menu">
                   <a href="#invoice" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                               <polyline points="6 9 6 2 18 2 18 9"></polyline>
                               <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                               <rect x="6" y="14" width="12" height="8"></rect>
                           </svg>
                           <span>Relatórios</span>
                       </div>
                       <div>
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                               <polyline points="9 18 15 12 9 6"></polyline>
                           </svg>
                       </div>
                   </a>
                   <ul class="collapse submenu list-unstyled" id="invoice" data-parent="#accordionExample">
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
                   <a href="#componentes" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                               <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                               <polyline points="14 2 14 8 20 8"></polyline>
                               <line x1="16" y1="13" x2="8" y2="13"></line>
                               <line x1="16" y1="17" x2="8" y2="17"></line>
                               <polyline points="10 9 9 9 8 9"></polyline>
                           </svg>
                           <span>Impressos</span>
                       </div>
                       <div>
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                               <polyline points="9 18 15 12 9 6"></polyline>
                           </svg>
                       </div>
                   </a>
                   <ul class="collapse submenu list-unstyled" id="componentes" data-parent="#accordionExample">
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
                   <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                           <circle cx="12" cy="12" r="10"></circle>
                       </svg><span>APLICAÇÃO</span></div>
               </li>

               <li class="menu">
                   <a href="#components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box">
                               <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                               <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                               <line x1="12" y1="22.08" x2="12" y2="12"></line>
                           </svg>
                           <span>Segurança</span>
                       </div>
                       <div>
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                               <polyline points="9 18 15 12 9 6"></polyline>
                           </svg>
                       </div>
                   </a>
                   <ul class="collapse submenu list-unstyled" id="components" data-parent="#accordionExample">
                       <li>
                           <a href="/usuarios"> Usuários </a>
                       </li>
                       <li>
                           <a href="/cargos"> Cargos </a>
                       </li>
                   </ul>
               </li>

               <li class="menu">
                   <a target="_blank" href="https://www.brasmid.com.br/imwplus/doc" aria-expanded="false" class="dropdown-toggle">
                       <div class="">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book">
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