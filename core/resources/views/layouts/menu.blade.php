<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <br><br><br><br>
            <li><a><i class="fa fa-male"></i>Perfil<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li>
                        <router-link :to="{name: 'IndexEmpleado'}">Actualizar datos</router-link>
                    </li>
                    <li>
                        <router-link :to="{name: 'IndexEmpleado'}">Certificado laboral</router-link>
                    </li>
                    <li>
                        <router-link :to="{name: 'IndexEmpleado'}">Cambiar contraseña</router-link>
                    </li>                    
                </ul>
            </li>
            <li><a><i class="fa fa-folder-open"></i>Empleados<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="#">Activos</a></li>
                    <li><a href="#">Retirados</a></li>
                    <li><a href="#">Infomación corpotativa</a></li>
                </ul>
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
