   <!-- top navigation -->
   <div class="top_nav">

       <div class="nav_menu">
           <nav class="" role="navigation">
               <div class="nav toggle">
                   <a id="menu_toggle"><i class="fa fa-bars"></i></a>
               </div>

               <ul class="nav navbar-nav navbar-right">
                   <li class="">
                       <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                           aria-expanded="false">
                            {{-- <img src="{{ url ('/theme/images/system/user.png') }}" alt="">{{ Auth()->user()->cz1_nombres}} --}}
                           <span class=" fa fa-angle-down"></span>
                       </a>
                       <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                           <li>
                               <a href="javascript:;">
                                   <span class="badge bg-red pull-right">50%</span>
                                   <span>Perfil</span>
                               </a>
                           </li>
                           <form method="POST" action="{{ route('logout') }}">
                            @csrf
                           <li><button class="btn btn-danger btn-sm btn-block"><i class="fa fa-sign-out pull-right"></i>Salir</button>
                           </li>
                        </form>
                       </ul>
                   </li>
               </ul>
           </nav>
       </div>

   </div>
   <!-- /top navigation -->
