@extends('layouts.app')

@section('titulo', 'Inicio')

@section('content')
<style>
    .menu-wrap {
        padding: 0;
        font-family: system-ui, -apple-system, sans-serif;

    }
 
    .menu-section {
        margin-bottom: 2rem;
    }
 
    .menu-section-label {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #9ca3af;
        margin-bottom: 10px;
        padding-left: 2px;
    }
 
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 10px;
    }
 
    .menu-tile {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px 10px 14px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }
 
    .menu-tile:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        text-decoration: none;
        color: inherit;
    }
 
    .menu-tile:active {
        transform: scale(0.97);
    }
 
    .menu-tile-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
 
    .menu-tile-label {
        font-size: 12px;
        font-weight: 500;
        color: #111827;
        text-align: center;
    }
 
    .sombra{
            box-shadow: 2px 2px 5px;
        }
</style>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">CAMBRE SGI</h3>
        </div>
        <div class="section-body">
            @include('layouts.modal.mensajes')
            <div class="menu-wrap">
 
                {{-- SERVICIOS --}}
                @can('VER-MENU-SERVICIOS')
                <div class="menu-section">
                    <h5>Servicios</h5>
                    <div class="menu-grid">
                        <a href="{{route('proyecto.indexprefijo', 2)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon">
                                <i class="fas fa-sitemap m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>Proyectos</span>
                        </a>
                        <a href="{{route('proyecto.indexprefijo', 3)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-teal">
                                <i class="fas fa-tape m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>SI</span>
                        </a>
                        <a href="{{route('proyecto.indexprefijo', 5)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-blue">
                                <i class="fas fa-wrench m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>SM</span>
                        </a>
                        <a href="{{route('proyecto.indexprefijo', 4)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-amber">
                                <i class="fas fa-star m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>TMC</span>
                        </a>
                    </div>
                </div>
                @endcan

                {{-- ÓRDENES --}}
                @can('VER-MENU-ORDENES')
                <div class="menu-section">
                    <h5>Ordenes</h5>
                    <div class="menu-grid">
                        <a href="{{route('ordenes.tipo', 1)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ">
                                <i class="fas fa-tasks m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>Trabajo</span>
                        </a>
                        @can(['VER-ORDEN-MANUFACTURA'])
                        <a href="{{route('ordenes.tipo', 2)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-teal">
                                <i class="fas fa-ruler-combined m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>Manufactura</span>
                        </a>
                        @endcan
                        @can(['VER-ORDEN-MECANIZADO'])
                        <a href="{{route('ordenes.tipo', 3)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-blue">
                                <i class="fas fa-screwdriver m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>Mecanizado</span>
                        </a>
                        @endcan
                        <a href="{{route('orden_mantenimiento.index')}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-amber">
                                <i class="fas fa-hammer m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>Operaciones</span>
                        </a>
                    </div>
                </div>
                @endcan

                @can('VER-MENU-PARTES')
                <div class="menu-section">
                    <h5>Partes</h5>
                    <div class="menu-grid">
                        <a href="{{route('partes.tipo', 1)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ">
                                <i class="fas fa-tasks m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>Trabajo</span>
                        </a>
                        @can(['VER-PARTE-MANUFACTURA'])
                        <a href="{{route('partes.tipo', 2)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-teal">
                                <i class="fas fa-ruler-combined m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>Manufactura</span>
                        </a>
                        @endcan
                        @can(['VER-PARTE-MECANIZADO'])
                        <a href="{{route('partes.tipo', 3)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-blue">
                                <i class="fas fa-screwdriver m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>Mecanizado</span>
                        </a>
                        @endcan
                        <a href="{{route('partes.tipo', 5)}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-amber">
                                <i class="fas fa-hammer m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>Operaciones</span>
                        </a>
                    </div>
                </div>
                @endcan

                @can('VER-MENU-SOLICITUDES')
                <div class="menu-section">
                    <h5>Solicitudes</h5>
                    <div class="menu-grid">
                        <a href="{{route('s_s_i.index')}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ">
                                <i class="fas fa-clipboard-list m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>S.S.I</span>
                        </a>
                        <a href="{{route('p_m.index')}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-teal">
                                <i class="fas fa-clipboard-list m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>P.M</span>
                        </a>
                        @can('VER-MENU-RI')
                        <a href="{{route('r_i.index')}}" class="menu-tile sombra menu-hover">
                            <div class="menu-tile-icon ic-blue">
                                <i class="fas fa-clipboard-list m-auto p-2" style="font-size:1em;"></i>
                            </div>
                            <span>R.I</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcan
            
            </div>
        </div>
        @role('SUPERVISOR')
            @php
                $es_sup = 1;
            @endphp
        @else
            @php
                $es_sup = 0;
            @endphp
        @endrole

        @role('EXTERNO')
            @php
                $es_ext = 1;
            @endphp
        @else
            @php
                $es_ext = 0;
            @endphp
        @endrole

        <script>
            
            $(document).ready( function () {
                let es_super = {{$es_sup}};
                let es_ext = {{$es_ext}};
                if (es_super) {
                    document.getElementById('ayudin').hidden = false;
                    let nombreArchivo = 'supervisor';
                    var url = '{{url('/')}}';
                    $.when($.ajax({
                        type: "post",
                        url: '/documentacion/obtener/'+nombreArchivo, 
                        data: {
                            nombreArchivo: nombreArchivo,
                        },
                        success: function (response) {
                            document.getElementById('ayudin').href = "{{url('/')}}"+'/'+response;
                        },
                        error: function (error) {
                            // console.log(error);
                        }
                    }));
                }

                if(es_ext){
                    document.getElementById('ayudin').hidden = false;
                    let nombreArchivo = 'externos';
                    var url = '{{url('/')}}';
                    $.when($.ajax({
                        type: "post",
                        url: '/documentacion/obtener/'+nombreArchivo, 
                        data: {
                            nombreArchivo: nombreArchivo,
                        },
                        success: function (response) {
                            document.getElementById('ayudin').href = "{{url('/')}}"+'/'+response;
                        },
                        error: function (error) {
                            // console.log(error);
                        }
                    }));
                }
            });
        </script>

    </section>
    
@endsection
