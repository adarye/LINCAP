
<div class="top_nav">
    <div class="nav_menu">
       
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="" >
            <ul class="navbar-right navbar  ">
            <li  class="nav-item dropdown open"  style="padding-left: 53px;">
                    <a role="button" href="javascript:;" id="navbarDropdown" class="  user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <?php $name = Auth()->user()->cz1_nombres; 
                         $name_separado = explode(" ", $name)                         
                        ?>
                        <img src="/../theme/images/profile/{{ Auth()->user()->cz1_avatar }}"
                            alt="">
                            {{ $name_separado[0]}}
                    </a>
                    <div class="dropdown-menu  " aria-labelledby="navbarDropdown">
                        
                        <router-link  class="dropdown-item"  :to="{name: 'RestartPassword'}" tag="button"><span>Cambiar
                                contraseña</span></router-link>
                                
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                        <button  class="dropdown-item" ><i class="fa fa-sign-out pull-right"></i>Salir</button>
                        </form>
                    
                            </div>
                    
                </li>
                
            </ul>
            
        </nav>
    </div>
</div>

