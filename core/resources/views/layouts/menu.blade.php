<!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <ul class="nav side-menu">
                <br><br><br><br>
                <li><a><i class="fa fa-building-o"></i>Perfil<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><router-link :to="{name:'torres'}">Actualizar datos</router-link></li>
                    <li><router-link :to="{name:'torres'}">Cambiar contraseña</router-link></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-wrench"></i>Mis Evaluaciones<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="#">Dietas</a></li>
                    <li><a href="#">Productos</a></li>
                  </ul>
                </li>
                <li><a href="#"><i class="fa fa-child"></i>Mis Encuestas<span class=""></span></a></li>
                <li><a href="#"><i class="fa fa-sign-out"></i>Salidas<span class=""></span></a></li>
                <li><a href="#"><i class="fa fa-ticket"></i>Tickets<span class=""></span></a></li>
                <li><a><i class="fa fa-gears"></i>Configuración<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="#">Perfiles</a></li>
                    <li><a href="#">Usuarios</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
<!-- /sidebar menu -->
