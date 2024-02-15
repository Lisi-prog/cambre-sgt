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
        <ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
            <li class="dropdown-title pt-3">
                Informatica
            </li>
        
            <li class="dropdown ">
                <a href="" class="nav-link has-dropdown">
                    <i class="fas fa-home"></i><span>Herramientas</span>
                </a>
                
                <ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
                    <li class="dropdown-title pt-3">
                        Herramientas
                    </li>
                
                    {{-- <li>
                        <a class="nav-link" href="" title="Logs-app">
                            <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Logs-app</span>
                        </a>
                    </li> --}}
            
                    {{-- <li>
                        <a class="nav-link" href="" title="Logs-audit">
                            <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Logs-audit</span>
                        </a>
                    </li> --}}
                    
                    <li>
                        <a class="nav-link" href="{{route('phpmyinfo')}}" title="PHPinfo">
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
            <li>
                <a class="nav-link" href="{{route('empleados.index')}}" title="Empleados">
                    <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Empleados</span>
                </a>
            </li>
        </ul>
    </li>
@endcan

@can('VER-MENU-INGENIERIA')
    <li class="dropdown ">
        <a href="" class="nav-link has-dropdown ">
            <i class="fas fa-home"></i><span>Ingenieria</span>
        </a>

        
        <ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
            <li class="dropdown-title pt-3">
                Ingenieria
            </li>
            @can('VER-MENU-SOLICITUDES')
            <li class="dropdown ">
                <a href="" class="nav-link has-dropdown">
                    <i class="fas fa-home"></i><span>Solicitudes</span>
                </a>
                
                <ul class="dropdown-menu borde-menu border border-primary border-2" style="display: none;">
                    <li class="dropdown-title">
                        Solicitudes
                    </li>
                
                    {{-- <li>
                        <a class="nav-link" href="" title="Requerimientos de servicios de mantenimiento">
                            <i class="fas fa-clipboard-list" style="font-size:1.2em;"></i><span>R.S.M.</span>
                        </a>
                    </li> --}}
                    @can('VER-MENU-SSI')
                    <li>
                        <a class="nav-link" href="{{route('s_s_i.index')}}" title="Solicitud de servicios de ingenieria">
                            <i class="fas fa-clipboard-list" style="font-size:1.2em; "></i><span>S.S.I.</span>
                        </a>
                    </li>
                    @endcan
                    @can('VER-MENU-PM')
                    <li>
                        <a class="nav-link" href="{{route('p_m.index')}}" title="Propuesta de mejora">
                            <i class="fas fa-clipboard-list" style="font-size:1.2em; "></i><span>P.M.</span>
                        </a>
                    </li>
                    @endcan
                    @can('VER-MENU-RI')
                    <li>
                        <a class="nav-link" href="{{route('r_i.index')}}" title="Requerimiento de ingenieria">
                            <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>R.I.</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('VER-MENU-SERVICIOS')
            <li class="dropdown ">
                <a href="" class="nav-link has-dropdown">
                    <i class="fas fa-home"></i><span>Servicios</span>
                </a>
                
                <ul class="dropdown-menu borde-menu border border-primary border-2" style="display: none;">
                    <li class="dropdown-title pt-3">
                        Servicios
                    </li>
                    @can('VER-MENU-PROYECTO')
                    <li>
                        <a class="nav-link" href="{{route('proyectos.index')}}" title="Proyectos">
                            <i class="fas fa-clipboard-list" style="font-size:1.2em;"></i><span>Proyectos</span>
                        </a>
                    </li>
                    @endcan
                    @can('VER-MENU-ETAPA')
                    <li>
                        <a class="nav-link" href="{{route('etapas.index')}}" title="Etapas">
                            <i class="fas fa-clipboard-list" style="font-size:1.2em;"></i><span>Etapas</span>
                        </a>
                    </li>
                    @endcan
                    @can('VER-MENU-ORDENES')
                    {{-- ORDENES --}}
                    <li class="dropdown">
                        <a href="" class="nav-link has-dropdown" title="Ordenes">
                            <i class="fas fa-home" style="font-size:1.2em;"></i><span>Ordenes</span>
                        </a>
                        <ul class="dropdown-menu borde-menu border border-primary border-2" style="display: none;">
                            <li class="dropdown-title pt-3">
                                Ordenes
                            </li>
                            <li>
                                <a class="nav-link" href="{{route('ordenes.tipo', 1)}}" title="Trabajo">
                                    <i class="fas fa-clipboard-list" style="font-size:1.2em;"></i><span>Trabajo</span>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{route('ordenes.tipo', 2)}}" title="Manufactura">
                                    <i class="fas fa-clipboard-list" style="font-size:1.2em;"></i><span>Manufactura</span>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{route('ordenes.tipo', 3)}}" title="Mecanizado">
                                    <i class="fas fa-clipboard-list" style="font-size:1.2em;"></i><span>Mecanizado</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('VER-MENU-MAQUINARIA')
            <li>
                <a class="nav-link" href="{{route('maquinarias.index')}}" title="Maquinaria">
                    <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Maquinaria</span>
                </a>
            </li>
            @endcan
            @can('VER-MENU-ACTIVOS')
            <li>
                <a class="nav-link" href="{{route('activos.index')}}" title="Activos">
                    <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Activos</span>
                </a>
            </li>
            @endcan
            {{-- <li>
                <a class="nav-link" href="" title="Tareas">
                    <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Tareas</span>
                </a>
            </li> --}}

        </ul>
    </li>
@endcan

