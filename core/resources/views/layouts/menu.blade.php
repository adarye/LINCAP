<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <br><br><br><br>
            <li><a><i class="fa fa-male"></i>Perfil<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li>
                        <router-link :to="{name:''}">Actualizar datos</router-link>
                    </li>
                    <li>
                        <router-link :to="{name:''}">Cambiar contraseña</router-link>
                    </li>
                </ul>
            </li>
            <li>
                <router-link :to="{name: 'IndexEmpleado'}"><i class="fa fa-folder-open"></i>Empleados</router-link>
            </li>
            <li><a><i class="fa fa-file-text-o"></i>Evaluaciones<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="#">Administrar</a></li>
                    <li><a href="#">Pendientes</a></li>
                    <li><a href="#">Completadas</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-pencil"></i>Encuestas<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="#">Administrar</a></li>
                    <li><a href="#">Pendientes</a></li>
                    <li><a href="#">Completadas</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-gears"></i>Configuración<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li>
                        <router-link :to="{name: 'Roles'}">Roles</router-link>
                    </li>
                    <li>
                        <router-link :to="{name: 'IndexUsuario'}">Usuarios</router-link>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->
