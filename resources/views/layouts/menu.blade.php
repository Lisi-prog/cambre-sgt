<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/">
        <i class=" fas fa-building"></i><span>Cambre S.A.</span>
    </a>
</li>

@can('VER-MENU-INFORMATICA')
    <li class="dropdown ">
        <a href="" class="nav-link has-dropdown ">
            <i class="fas fa-home"></i><span>Informatica</span>
        </a>
        <ul class="dropdown-menu border border-primary border-2 borde-menu m-0" style="display: none;">
            <li class="dropdown-title pt-3">
                Informatica
            </li>
        
            <li class="dropdown ">
                <a href="" class="nav-link has-dropdown ">
                    <i class="fas fa-home"></i><span>Herramientas</span>
                </a>
                
                <ul class="dropdown-menu borde-menu m-0" style="display: none;">
                    <li class="dropdown-title pt-3">
                        Herramientas
                    </li>
                
                    <li>
                        <a class="nav-link" href="" title="Logs-app">
                            <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Logs-app</span>
                        </a>
                    </li>
            
                    <li>
                        <a class="nav-link" href="" title="Logs-audit">
                            <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Logs-audit</span>
                        </a>
                    </li>
                    
                    <li>
                        <a class="nav-link" href="" title="PHPinfo">
                            <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>PHPinfo</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a class="nav-link" href="{{route('permisos.index')}}" title="Permisos">
                    <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Permisos</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('roles.index')}}" title="Roles">
                    <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Roles</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('usuarios.index')}}" title="Usuarios">
                    <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Usuarios</span>
                </a>
            </li>
        </ul>
    </li>
@endcan

@can('VER-MENU-PLANTA')
    <li class="dropdown ">
        <a href="" class="nav-link has-dropdown ">
            <i class="fas fa-home"></i><span>Planta</span>
        </a>

        <ul class="dropdown-menu border border-primary border-2 borde-menu m-0" style="display: none;">
            <li class="dropdown-title pt-3">
                Planta
            </li>

            <li>
                <a class="nav-link" href="" title="Tareas">
                    <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Tareas</span>
                </a>
            </li>

        </ul>
    </li>
@endcan

