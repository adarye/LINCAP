<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="mmenu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <?php $name = Auth()->user()->cz1_nombres; 
                         $name_separado = explode(" ", $name)                         
                        ?>
                        <img src="/../theme/images/profile/{{ Auth()->user()->cz1_avatar }}"
                            alt="">{{$name_separado [0]}}
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <router-link  class="dropdown-item" :to="{name: 'RestartPassword'}"><span> Cambiar
                                contraseña</span></router-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item"><i class="fa fa-sign-out pull-right"></i>Salir</button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->
