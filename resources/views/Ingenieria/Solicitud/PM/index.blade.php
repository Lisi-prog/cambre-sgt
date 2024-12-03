@extends('layouts.app')
@section('titulo', 'P.M.')
@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])

<style>
    .table {
        zoom: 100%;
    }
    table.dataTable tbody td {
        padding: 0px 10px;
    }
    .col-4 {
        padding: 5px;
    }
</style>
<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 my-auto">
                <h4 class="titulo page__heading my-auto">Propuesta de mejora</h5>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-4">
                <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearPMModal">
                    Nuevo   
                </button>
            </div>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">   
        {{-- Pm a calificar --}}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="d-flex justify-content-between">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-center my-auto">
                                <h5 class="text-center my-auto" onclick="mostrarFiltroOpc('flt_pm')" style="cursor: pointer;">P.M. a calificar <i class="fas fa-filter"></i></h5>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-2">
                            </div>
                        </div>
                    </div>
                    <div class="card-head" id="flt_pm" hidden>
                        <div class="row" id="demo" > 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 170px;">
                                            <div class="">
                                                <label>Usuario:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('usu', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input class="pmc" name="filter" type="checkbox" value="usu" checked> (Seleccionar todo)</label>
                                                @foreach ($flt_users as $usuarios)
                                                    <label><input class="pmc" name="usu" type="checkbox" value="{{$usuarios->nombre_empleado}}" checked> {{$usuarios->nombre_empleado}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 170px;">
                                            <div class="">
                                                <label>Estados:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input class="pmc" name="filter" type="checkbox" value="est" checked> (Seleccionar todo)</label>
                                                @foreach ($flt_estados_sol as $estado)
                                                    @if ($estado->id_estado_solicitud != 3)
                                                        <label><input class="pmc" name="est" type="checkbox" value="{{$estado->nombre_estado_solicitud}}" checked> {{$estado->nombre_estado_solicitud}}</label>
                                                    @else
                                                        <label><input class="pmc" name="est" type="checkbox" value="{{$estado->nombre_estado_solicitud}}"> {{$estado->nombre_estado_solicitud}}</label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>   
                    </div>
                    <div class="card-body">
                        <div class="table-responsive tableFixHead">
                            <table id="tablaPmACali" class="table table-hover mt-2">
                                <thead style="background-color: #00628c">
                                    <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:3vw">Fecha</th>
                                    <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:1vw">Codigo</th>
                                    <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:6vw">Titulo</th>
                                    <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:5vw">Proponente/s</th>
                                    <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:3vw">Usuario</th>
                                    {{-- <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">Estado</th> --}}
                                    <th class="text-center" scope="col" style="color:#fff; min-width:1vw">Acciones</th>                                                           
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $id_estado_aceptado = Config::get('myconfig.estado_solicitud_aceptado');
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($ListaPM as $Pm)
                                        @if (is_null($Pm->calificacion))
                                            <tr>
                                                <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Pm->getSolicitud->fecha_carga)->format('Y-m-d H:i')}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->id_solicitud}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->titulo_propuesta}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->nombre_emisor}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->getEmpleado->nombre_empleado ?? 'no asignado'}}</td>

                                                {{-- <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud}}</td> --}}
                                                
                                                @if ($Pm->getSolicitud->getEmpleado->id_empleado == Auth::user()->getEmpleado->id_empleado || Auth::user()->hasRole('SUPERVISOR'))
                                                    <td>
                                                        <div class="row justify-content-center">
                                                            <div class="row justify-content-center" >
                                                                <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePMA{{$idCount}}" aria-expanded="false" aria-controls="collapsePMA{{$idCount}}">
                                                                    Opciones
                                                                </button>
                                                            </div>
                                                            <div class="collapse" data-bs-parent="#accordion" id="collapsePMA{{$idCount}}">
                                                                <div class="row my-2">
                                                                    <div class="col-12">
                                                                        @role(["SUPERVISOR", "ADMIN"])
                                                                            {!! Form::open(['method' => 'GET', 'route' => ['pm.calificar', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
                                                                                {!! Form::submit('Calificar', ['class' => 'btn btn-success w-100']) !!}
                                                                            {!! Form::close() !!}
                                                                        @endrole
                                                                    </div>
                                                                </div>
                                                                <div class="row my-2">
                                                                    <div class="col-12">
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['p_m.edit', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
                                                                            {!! Form::submit('Editar', ['class' => 'btn btn-warning w-100']) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td class='text-center' style="vertical-align: middle;">-</td>
                                                @endif
                                            </tr>
                                            @php
                                                $idCount += 1;    
                                            @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ------------- --}}

        {{-- Pm calificado --}}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="d-flex justify-content-between">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-center my-auto">
                                <h5 class="text-center my-auto" onclick="mostrarFiltroOpc('flt_etapa')" style="cursor: pointer;">P.M. <i class="fas fa-filter"></i></h5>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-2">
                            </div>
                        </div>
                    </div>
                    <div class="card-head" id="flt_etapa" hidden>
                        <div class="row" id="demo" >
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 170px;">
                                            <div class="">
                                                <label>Usuario:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('usu1', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input class="pm" name="filter" type="checkbox" value="usu1" checked> (Seleccionar todo)</label>
                                                @foreach ($flt_users as $usuarios)
                                                    <label><input class="pm" name="usu1" type="checkbox" value="{{$usuarios->nombre_empleado}}" checked> {{$usuarios->nombre_empleado}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 170px;">
                                            <div class="">
                                                <label>Estados:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('est1', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input class="pm" name="filter" type="checkbox" value="est1" checked> (Seleccionar todo)</label>
                                                @foreach ($flt_estados as $estado)
                                                    @if (in_array($estado->nombre_estado_solicitud, $estados_a_buscar))
                                                        <label><input class="pm" name="est1" type="checkbox" value="{{$estado->nombre_estado_solicitud}}"> {{$estado->nombre_estado_solicitud}}</label>
                                                    @else
                                                        <label><input class="pm" name="est1" type="checkbox" value="{{$estado->nombre_estado_solicitud}}" checked> {{$estado->nombre_estado_solicitud}}</label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                    <div class="card-body">
                        <div class="table-responsive tableFixHead">
                            <table id="tablaPm" class="table table-hover mt-2">
                                <thead style="background-color: #00628c">
                                    <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:3vw">Fecha</th>
                                    <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">Interes</th>
                                    <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:1vw">Codigo</th>
                                    <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:6vw">Titulo</th>
                                    <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:5vw">Proponente/s</th>
                                    <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:3vw">Usuario</th>
                                    <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">Calificacion</th>
                                    {{-- <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">Necesidad</th> --}}
                                    {{-- <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">V. total</th> --}}  
                                    <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">Estado</th>
                                    <th class="text-center" scope="col" style="color:#fff; min-width:3vw">Acciones</th>                                                           
                                </thead>
                                <tbody id="accordionB">
                                    @php
                                        $id_estado_aceptado = Config::get('myconfig.estado_solicitud_aceptado');
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($ListaPM as $Pm)
                                        @if (!is_null($Pm->calificacion))
                                            @if (in_array($Pm->getSolicitud->getServicio ? $Pm->getSolicitud->getServicio->getEstado() : $Pm->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud ?? '-', $estados_a_buscar))
                                                <tr style="display: none">
                                            @else
                                                <tr>
                                            @endif
                                                <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Pm->getSolicitud->fecha_carga)->format('Y-m-d H:i')}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->interes ?? '-'}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->id_solicitud}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->titulo_propuesta}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->nombre_emisor}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->getEmpleado->nombre_empleado ?? 'no asignado'}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->calificacion ?? '-'}}</td>

                                                {{-- <td class='text-center' style="vertical-align: middle;">{{$Pm->necesidad ?? '-'}}</td> --}}

                                                {{-- <td class='text-center' style="vertical-align: middle;">{{$Pm->v_total ?? '-'}}</td> --}}

                                                <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->getServicio ? $Pm->getSolicitud->getServicio->getEstado() : $Pm->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud ?? '-'}}</td>
                                                
                                                @if ($Pm->getSolicitud->getEmpleado->id_empleado ==  Auth::user()->getEmpleado->id_empleado || Auth::user()->hasRole('SUPERVISOR'))
                                                <td>
                                                    <div class="row justify-content-center">
                                                        <div class="row justify-content-center" >
                                                            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePM{{$idCount}}" aria-expanded="false" aria-controls="collapseSSI{{$idCount}}">
                                                                Opciones
                                                            </button>
                                                        </div>
                                                        <div class="collapse" data-bs-parent="#accordionB" id="collapsePM{{$idCount}}">
                                                            <div class="row my-2">
                                                                <div class="col-12">
                                                                    @if ($Pm->getSolicitud->id_estado_solicitud >= $id_estado_aceptado)
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['p_m.show', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Ver', ['class' => 'btn btn-primary w-100']) !!}
                                                                        {!! Form::close() !!}
                                                                    @else
                                                                        @can('EVALUAR-SOLICITUD')
                                                                            {!! Form::open(['method' => 'GET', 'route' => ['pm.evaluar', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
                                                                            {!! Form::submit('Evaluar', ['class' => 'btn btn-success w-100']) !!}
                                                                            {!! Form::close() !!}
                                                                        @endcan
                                                                    @endif
                                                                </div>
                                                            </div> 

                                                            <div class="row my-2">
                                                                @if ($Pm->getSolicitud->id_estado_solicitud >= $id_estado_aceptado && $Pm->getSolicitud->id_estado_solicitud != 3)
                                                                    <div class="col-12">
                                                                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#avanceProyectoModal" onclick="cargarModalProgresoServicio({{$Pm->getSolicitud->id_solicitud}})">
                                                                        Avance
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            </div> 
                                                            <div class="row my-2">
                                                                @if (Auth::user()->hasRole('SUPERVISOR'))
                                                                    <div class="col-12">
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['p_m.edit', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Editar', ['class' => 'btn btn-warning w-100']) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                @else
                                                                    @if ($Pm->getSolicitud->getEmpleado->id_empleado ==  Auth::user()->getEmpleado->id_empleado && $Pm->getSolicitud->id_estado_solicitud < $id_estado_aceptado)
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['p_m.edit', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Editar', ['class' => 'btn btn-warning w-100']) !!}
                                                                        {!! Form::close() !!}
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                @else
                                                    <td class='text-center' style="vertical-align: middle;">-</td>
                                                @endif
                                            </tr>
                                            @php
                                                $idCount += 1;    
                                            @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ------------- --}}
    </div>
    
</section>
    @include('Ingenieria.Solicitud.PM.modal.m-crear')
    @include('Ingenieria.Solicitud.layout.avance-servicio')
    <script src="{{ asset('js/Ingenieria/Solicitud/solicitud.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Solicitud/filter.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Solicitud/filter-pm.js') }}"></script>
    <script>
        $(document).ready(function () {
            var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'propuesta de mejora';

        $.when($.ajax({
            type: "post",
            url: '/documentacion/obtener/'+nombreArchivo, 
            data: {
                nombreArchivo: nombreArchivo,
            },
            success: function (response) {
                document.getElementById('ayudin').href = response;
            },
            error: function (error) {
                console.log(error);
            }
        }));

        var tabla = $('#example').DataTable({
                language: {
                        lengthMenu: 'Mostrar _MENU_ registros por pagina',
                        zeroRecords: 'No se ha encontrado registros',
                        info: 'Mostrando pagina _PAGE_ de _PAGES_',
                        infoEmpty: 'No se ha encontrado registros',
                        infoFiltered: '(Filtrado de _MAX_ registros totales)',
                        search: 'Buscar',
                        paginate:{
                            first:"Prim.",
                            last: "Ult.",
                            previous: 'Ant.',
                            next: 'Sig.',
                        },
                    },
                    order: [[0, 'desc']],
                    lengthMenu: [
                        [25, 50, 100, 500, -1],
                        [25, 50, 100, 500, 'Todo']
                    ],
                    "pageLength": 100
            });

            tabla.on('draw',function () {
                changeTdColor();
                changeInteresColor();
            })

            $('input:checkbox').on('change', function () {
                tabla.draw();
            });

            

            var tables = $('#tablaPmACali').DataTable({
                paging: false,
                language: {
                        lengthMenu: 'Mostrar _MENU_ registros por pagina',
                        zeroRecords: 'No se ha encontrado registros',
                        info: 'Mostrando pagina _PAGE_ de _PAGES_',
                        infoEmpty: 'No se ha encontrado registros',
                        infoFiltered: '(Filtrado de _MAX_ registros totales)',
                        search: 'Buscar',
                        paginate:{
                            first:"Prim.",
                            last: "Ult.",
                            previous: 'Ant.',
                            next: 'Sig.',
                        },
                    },
                    order: [[0, 'desc']],
                    lengthMenu: [
                        [25, 50, 100, 500, -1],
                        [25, 50, 100, 500, 'Todo']
                    ],
                    "pageLength": 100
            });

            var tablaw = $('#tablaPm').DataTable({
                language: {
                        lengthMenu: 'Mostrar _MENU_ registros por pagina',
                        zeroRecords: 'No se ha encontrado registros',
                        info: 'Mostrando pagina _PAGE_ de _PAGES_',
                        infoEmpty: 'No se ha encontrado registros',
                        infoFiltered: '(Filtrado de _MAX_ registros totales)',
                        search: 'Buscar',
                        paginate:{
                            first:"Prim.",
                            last: "Ult.",
                            previous: 'Ant.',
                            next: 'Sig.',
                        },
                    },
                    order: [[1, 'desc']],
                    lengthMenu: [
                        [25, 50, 100, 500, -1],
                        [25, 50, 100, 500, 'Todo']
                    ],
                    "pageLength": 100
            });

            tablaw.on('draw',function () {
                changeTdColor();
                changeInteresColor();
            })

            changeInteresColor();
        });
    </script>
<script src="{{ asset('js/change-td-color.js') }}"></script>
<script src="{{ asset('js/filter-to-filter.js') }}"></script>
@endsection
