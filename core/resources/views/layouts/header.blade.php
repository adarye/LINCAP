<div class="top_nav">
    <div class="nav_menu">
        <nav>
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        
            <ul class=" navbar  navbar-right">
                <li>
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?php $name = Auth()->user()->cz1_nombres; 
                         $name_separado = explode(" ", $name)                         
                        ?>
                        <img src="/../theme/images/profile/{{ Auth()->user()->cz1_avatar }}"
                            alt="">{{Auth()->user()->cz1_nombres}} 
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li class="dropdown-item">
                        <router-link   :to="{name: 'RestartPassword'}"><span>Cambiar
                                contraseña</span></router-link></li>
                                <li >
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" ><i class="fa fa-sign-out pull-right"></i>Salir</button>
                        </form>
                                </li>
                    </ul>
                    
                </li>
                
            </ul>
            
        </nav>
    </div>
</div>
<!-- /top navigation -->
