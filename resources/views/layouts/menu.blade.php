    {{-- <li class="side-menus {{ Request::is('*') ? 'active' : '' }}"> --}}
    {{-- <style>
        .prubb:hover {
            color: #fff !important;
            background-color: #00628c !important;
        }
    </style> --}}
    <li class="side-menus">
        <a class="nav-link menu-hover" href="/">
            <i class="fas fa-home"></i><span>Cambre S.A.</span>
        </a>
    </li>

    @can('VER-MENU-SOLICITUDES')
        <li class="dropdown ">
            <a href="" class="nav-link has-dropdown menu-hover">
                <i class="fas fa-clipboard-list"></i><span>Solicitudes</span>
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
            <a href="" class="nav-link has-dropdown menu-hover">
                <i class="fas fa-project-diagram"></i><span>Servicios</span>
            </a>
            
            <ul class="dropdown-menu borde-menu border border-primary border-2" style="display: none;">
                <li class="dropdown-title pt-3">
                    Servicios
                </li>
                

                <li>
                    <a class="nav-link" href="{{route('proyecto.indexprefijo', 2)}}" title="Proyectos">
                        <i class="fas fa-sitemap" style="font-size:1.2em;"></i><span>Proyectos</span>
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="{{route('proyecto.indexprefijo', 3)}}" title="Servicio de ingenieria">
                        <i class="fas fa-tape" style="font-size:1.2em;"></i><span>SI</span>
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="{{route('proyecto.indexprefijo', 4)}}" title="Mejora continua">
                        <i class="fas fa-star" style="font-size:1.2em;"></i><span>TMC</span>
                    </a>
                </li>
                
                <li>
                    <a class="nav-link" href="{{route('proyecto.indexactivo')}}" title="Mejora continua">
                        <i class="fas fa-drafting-compass" style="font-size:1.2em;"></i><span>Activos</span>
                    </a>
                </li>
                
                <li>
                    <a class="nav-link" href="{{route('proyecto.indexprefijo', 1)}}" title="Servicios">
                        <i class="fas fa-file-alt" style="font-size:1.2em;"></i><span>Mostrar todo</span>
                    </a>
                </li>
            </ul>
        </li>
    @endcan

    @can('VER-MENU-ORDENES') {{-- ORDENES --}}
        <li class="dropdown">
            <a href="" class="nav-link has-dropdown menu-hover">
                <i class="fas fa-briefcase"></i><span>Ordenes</span>
            </a>
            <ul class="dropdown-menu borde-menu border border-primary border-2" style="display: none;">
                <li class="dropdown-title pt-3">
                    Ordenes
                </li>
                <li>
                    <a class="nav-link" href="{{route('ordenes.tipo', 1)}}" title="Trabajo">
                        <i class="fas fa-tasks" style="font-size:1.2em;"></i><span>Trabajo</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('ordenes.tipo', 2)}}" title="Manufactura">
                        <i class="fas fa-ruler-combined" style="font-size:1.2em;"></i><span>Manufactura</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('ordenes.tipo', 3)}}" title="Mecanizado">
                        <i class="fas fa-screwdriver" style="font-size:1.2em;"></i><span>Mecanizado</span>
                    </a>
                </li>
                <li hidden>
                    <a class="nav-link" href="{{route('ordenes.indexhdr')}}" title="Operaciones">
                        <i class="fas fa-hammer" style="font-size:1.2em;"></i><span>Operaciones</span>
                    </a>
                </li>
            </ul>
        </li>
    @endcan

    @can('VER-MENU-PARTES') {{-- PARTES --}}
        <li class="dropdown">
            <a href="" class="nav-link has-dropdown menu-hover">
                <i class="fas fa-pencil-alt"></i><span>Partes</span>
            </a>
            <ul class="dropdown-menu borde-menu border border-primary border-2" style="display: none;">
                <li class="dropdown-title pt-3">
                    Partes
                </li>
                <li>
                    <a class="nav-link" href="{{route('partes.tipo', 1)}}" title="Trabajo">
                        <i class="fas fa-tasks" style="font-size:1.2em;"></i><span>Trabajo</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('partes.tipo', 2)}}" title="Manufactura">
                        <i class="fas fa-ruler-combined" style="font-size:1.2em;"></i><span>Manufactura</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('partes.tipo', 3)}}" title="Mecanizado">
                        <i class="fas fa-screwdriver" style="font-size:1.2em;"></i><span>Mecanizado</span>
                    </a>
                </li>
            </ul>
        </li>
    @endcan

    @can('VER-MENU-INGENIERIA')
    <li class="dropdown ">
        <a href="" class="nav-link has-dropdown menu-hover">
            <i class="fas fa-wrench"></i><span>Ingenieria</span>
        </a>
        <ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
            <li class="dropdown-title pt-3">
                Ingenieria
            </li>

            @can('VER-MENU-ACTIVOS')
            <li>
                <a class="nav-link" href="{{route('activos.index')}}" title="Activos">
                    <i class="fas fa-drafting-compass" style="font-size:1.2em; "></i><span>Activos</span>
                </a>
            </li>
            @endcan

            @can('VER-MENU-MAQUINARIA')
            <li>
                <a class="nav-link" href="{{route('maquinarias.index')}}" title="Maquinaria">
                    <i class="fas fa-cogs" style="font-size:1.2em; "></i><span>Maquinaria</span>
                </a>
            </li>
            @endcan

            @can('VER-MENU-PREFIJOS')
            <li>
                <a class="nav-link" href="{{route('prefijo_proyecto.index')}}" title="Prefijos proyecto">
                    <i class="fas fa-pencil-ruler"style="font-size:1.2em; "></i><span>Prefijos</span>
                </a>
            </li>
            @endcan

            {{-- @can('VER-MENU-OPERACION')
            <li>
                <a class="nav-link" href="{{route('operacion.index')}}" title="Operacion">
                    <i class="fas fa-pencil-ruler"style="font-size:1.2em; "></i><span>Operacion</span>
                </a>
            </li>
            @endcan --}}
            
        </ul>
    </li>
    @endcan

    @can('VER-MENU-INFORMATICA')
    <li class="dropdown ">
        <a href="" class="nav-link has-dropdown menu-hover">
            <i class="fas fa-server"></i><span>Sistema</span>
        </a>
        <ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
            <li class="dropdown-title pt-3">
                Sistema
            </li>

            <li>
                <a class="nav-link" href="{{route('usuarios.index')}}" title="Usuarios">
                    <i class="fas fa-user"style="font-size:1.2em; "></i><span>Usuarios</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('tecnicos.index')}}" title="Tecnicos">
                    <i class="fas fa-hard-hat"style="font-size:1.2em; "></i><span>Técnicos</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('roles.index')}}" title="Roles">
                    <i class="fas fa-user-cog"style="font-size:1.2em; "></i><span>Roles</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('permisos.index')}}" title="Permisos">
                    <i class="fas fa-user-shield"style="font-size:1.2em; "></i><span>Permisos</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('sectores.index')}}" title="Sectores">
                    <i class="fas fa-bezier-curve"></i><span>Sectores</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('documentacion.index')}}" title="Documentacion">
                    <i class="fas fa-scroll"style="font-size:1.2em; "></i><span>Documentacion</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('phpmyinfo')}}" title="PHPinfo">
                    <i class="fas fa-tools"style="font-size:1.2em; "></i><span>PHPinfo</span>
                </a>
            </li>
        </ul>
    </li>
    @endcan

    @can('VER-MENU-INFORMES')
    <li class="dropdown ">
        <a href="" class="nav-link has-dropdown menu-hover">
            <i class="fas fa-chart-bar"></i><span>Informes</span>
        </a>
        <ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
            <li class="dropdown-title pt-3">
                Informes
            </li>

            {{-- <li>
                <a class="nav-link" href="{{route('usuarios.index')}}" title="Usuarios">
                    <i class="fas fa-user"style="font-size:1.2em; "></i><span>Usuarios</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('tecnicos.index')}}" title="Tecnicos">
                    <i class="fas fa-hard-hat"style="font-size:1.2em; "></i><span>Técnicos</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('roles.index')}}" title="Roles">
                    <i class="fas fa-user-cog"style="font-size:1.2em; "></i><span>Roles</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('permisos.index')}}" title="Permisos">
                    <i class="fas fa-user-shield"style="font-size:1.2em; "></i><span>Permisos</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('sectores.index')}}" title="Sectores">
                    <i class="fas fa-bezier-curve"></i><span>Sectores</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('documentacion.index')}}" title="Documentacion">
                    <i class="fas fa-scroll"style="font-size:1.2em; "></i><span>Documentacion</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{route('phpmyinfo')}}" title="PHPinfo">
                    <i class="fas fa-tools"style="font-size:1.2em; "></i><span>PHPinfo</span>
                </a>
            </li> --}}
        </ul>
    </li>
    @endcan

    {{-- @role('SUPERVISOR') --}}
    <li class="side-menus">
        <a class="nav-link menu-hover" href="" target="_blank" id="ayudin" hidden>
            <i class="fas fa-question-circle"></i><span>Ayuda</span>
        </a>
    </li>
    {{-- @endrole --}}

    <div class="d-flex mx-auto justify-content-center">
        <a class="nav-link btn w-60" href="" id="volver" style="background-color: #21628d">
            <i class="fas fa-arrow-left" style="color:rgb(255, 255, 255);font-size:1.5em;"></i><span style="color:white"> Volver </span>
        </a>
    </div>
