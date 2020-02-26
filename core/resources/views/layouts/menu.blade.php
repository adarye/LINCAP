<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li><a><i class="fa fa-male"></i>Perfil<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li>
                        <router-link :to="{name: 'IndexNoticias'}">Noticias
                        </router-link>
                    </li>
                    <li>
                        <router-link v-bind:to="'/empleado/' +  {{ Auth()->user()->cz1_id_empleado }}">Actualizar datos
                        </router-link>
                    </li>
                    <li>
                        <a target="_blank" href="{{ url ('imprimir') }}">Certificado laboral</a>
                    </li>
                </ul>
            </li>
            
            @cannot('isDefault')
            <li><a><i class="fa fa-folder-open"></i>Empleados<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    @cannot('isJefe')
                    <li>
                        <router-link :to="{name: 'Activos'}" id="activos">Activos</router-link>
                    </li>
                    <li>
                        <router-link :to="{name: 'Retirados'}">Retirados</router-link>
                    </li>
                    @endcannot
                   
                    <li>
                        <router-link :to="{name: 'InfCorporativa'}">InfCorporativa</router-link>
                    </li>
                </ul>
            </li>
           
            @endcannot
            <li><a><i class="fa fa-file-text-o"></i>Evaluaciones<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    @cannot('isAdministrativo')
                    @cannot('isDefault')
                    <li><router-link v-bind:to="'/gestion/pruebas/2/' +  {{ Auth() -> user() -> cz1_id_empleado}} " >Administrar</router-link></li>
                    @endcannot
                    @endcannot
                    <li><router-link v-bind:to="'/pruebas/pendientes/' + 2">Pendientes</router-link></li>
                    <li> <router-link v-bind:to="'/pruebas/completadas/' + 2">Completadas</router-link></li>
                </ul>
            </li>
            <li><a><i class="fa fa-pencil"></i>Encuestas<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    @cannot('isAdministrativo')
                    @cannot('isDefault')
                    <li> <router-link v-bind:to="'/gestion/pruebas/1/' + {{ Auth() -> user() -> cz1_id_empleado}}">Administrar</router-link></li>
                    @endcannot
                    @endcannot

                <li> <router-link v-bind:to="'/pruebas/pendientes/' + 1">Pendientes</router-link></li>
                    <li><router-link v-bind:to="'/pruebas/completadas/' + 1">Completadas</router-link></li>
                </ul>
            </li>
            {{-- @cannot('isDefault') --}}
            @can('isAdmin')
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
            @endcan
            {{-- @endcannot --}}
        </ul>
    </div>
    <script type="application/javascript">
        window.user = @json(
            [
                'rol' => Auth() -> user() -> cz1_id_rol,
                'nombres' => Auth() -> user() -> cz1_nombres,
                'id' => Auth() -> user() -> cz1_id_empleado
            ]
        )
    </script>
</div>
<!-- /sidebar menu -->
