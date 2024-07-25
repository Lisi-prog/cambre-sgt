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
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <button type="button" class="btn btn-primary-outline m-1 rounded" onclick="mostrarFiltro('demo')">Filtros <i class="fas fa-caret-down"></i></button> 
                        </div>
                        <div class="row" id="demo" hidden>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 200px;">
                                            <div class="">
                                                <label>Usuario:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="cod_serv" checked> (Seleccionar todo)</label>
                                                @foreach ($flt_users as $flt_user)
                                                    <label><input class="input-filter" name="cod_serv" type="checkbox" value="{{$flt_user->nombre_empleado}}" checked> {{$flt_user->nombre_empleado}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 200px;">
                                            <div class="">
                                                <label>Sector:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="sup" checked> (Seleccionar todo)</label>
                                                @foreach ($flt_sectores as $flt_sector)
                                                    <label><input name="sup" type="checkbox" value="{{$flt_sector->nombre_sector}}" checked> {{$flt_sector->nombre_sector}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- @role('SUPERVISOR') --}}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="row">
                                        <div class="d-flex flex-row align-items-start justify-content-around">
                                            <div class="card-body d-flex flex-column" style="height: 200px;">
                                                <div class="">
                                                    <label>Estado:</label>
                                                </div>
                                                <div class="d-flex flex-column overflow-auto">
                                                    <label style="font-style: italic"><input name="filter" type="checkbox" value="res" checked> (Seleccionar todo)</label>
                                                    @foreach ($flt_estados as $flt_estado)
                                                        <label><input name="res" type="checkbox" value="{{$flt_estado->nombre_estado_solicitud}}" checked> {{$flt_estado->nombre_estado_solicitud}}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{-- @endrole --}}
                            
                            {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 200px;">
                                            <div class="">
                                                <label>Prioridad:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="est" checked> (Seleccionar todo)</label>
                                                @foreach ($flt_prioridades as $flt_prioridad)
                                                    <label><input name="est" type="checkbox" value="{{$flt_prioridad->nombre_prioridad_solicitud}}" checked> {{$flt_prioridad->nombre_prioridad_solicitud}}</label>
                                                @endforeach
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>   
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead style="height:50px;">
                                    <th class='text-center' style="color:#fff;">Fecha</th>
                                    <th class='ml-3 text-center' style="color:#fff;">Codigo</th>
                                    <th class='text-center' style="color:#fff;">Titulo</th>
                                    <th class='text-center' style="color:#fff;">Proponente</th>
                                    {{-- <th class='text-center' style="color:#fff;">Sector</th> --}}
                                    <th class='text-center' style="color:#fff;">Usuario</th>
                                    
                                    {{-- <th class='text-center' style="color:#fff;">Fecha requerida</th> --}}
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    {{-- <th class='text-center' style="color:#fff;">Prioridad</th> --}}
                                    <th class='text-center' style="color: #fff;width:13vh">Acciones</th>
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $id_estado_aceptado = Config::get('myconfig.estado_solicitud_aceptado');
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($ListaPM as $Pm)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Pm->getSolicitud->fecha_carga)->format('Y-m-d H:i')}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->id_solicitud}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Pm->titulo_propuesta}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Pm->nombre_emisor}}</td>

                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$Pm->getSector->nombre_sector ?? ''}}</td> --}}

                                            <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->getEmpleado->nombre_empleado ?? 'no asignado'}}</td>

                                            
                                            
                                            {{-- <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Pm->getSolicitud->fecha_requerida)->format('d-m-Y')}}</td> --}}

                                            <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud}}</td>

                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud}}</td> --}}

                                            {{-- <td>
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePM{{$idCount}}" aria-expanded="false" aria-controls="collapsePM{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapsePM{{$idCount}}">
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
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['p_m.edit', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-warning w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td> --}}
                                            @if ($Pm->getSolicitud->getEmpleado->id_empleado ==  Auth::user()->getEmpleado->id_empleado || Auth::user()->hasRole('SUPERVISOR'))
                                            <td>
                                                <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePM{{$idCount}}" aria-expanded="false" aria-controls="collapseSSI{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapsePM{{$idCount}}">
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['p_m.show', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Ver', ['class' => 'btn btn-primary w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div> 

                                                        <div class="row my-2">
                                                            @if ($Pm->getSolicitud->id_estado_solicitud >= $id_estado_aceptado)
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>
    @include('Ingenieria.Solicitud.PM.modal.m-crear')
    @include('Ingenieria.Solicitud.layout.avance-servicio')
    <script src="{{ asset('js/Ingenieria/Solicitud/solicitud.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Solicitud/filter.js') }}"></script>
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

        /* $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
            var positions = $('input:checkbox[name="sup"]:checked').map(function() {
                return this.value;
            }).get();
        
            if (positions.length === 0) {
                return true;
            }
            
            if (positions.indexOf(searchData[3]) !== -1) {
                return true;
            }
            
            return false;
            }
        ); */

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="res"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[5]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        /* $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="est"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[7]) !== -1) {
                return true;
            }
            
            return false;
            }
        ); */

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="cod_serv"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }


            if (offices.indexOf(searchData[4]) !== -1) {
                return true;
            }
            
            return false;
            }
        );
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
            })

            $('input:checkbox').on('change', function () {
                tabla.draw();
            });
        });
    </script>
<script src="{{ asset('js/change-td-color.js') }}"></script>
@endsection
