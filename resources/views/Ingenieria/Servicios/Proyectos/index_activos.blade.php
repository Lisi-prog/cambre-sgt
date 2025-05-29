@extends('layouts.app')
@section('titulo', 'Ordenes')
@section('content')

<style>
    .tableFixHead {
       overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
       height: 300px; /* gives an initial height of 200px to the table */
     }
     .tableFixHead thead th {
       position: sticky; /* make the table heads sticky */
       top: 0px; /* table head will be placed from the top of the table and sticks to it */
     }
     #viv table {
       border-collapse: collapse; /* make the table borders collapse to each other */
       width: 100%;
     }
     /* #viv th,
     #viv td {
       padding: 8px 16px;
       border: 1px solid #ccc;
     }*/
     #viv th {
       background: #ee9b27;
     } 

    #example thead input {
        width: 100%;
    }

    .btn-primary-outline {
        background-color: transparent;
        border-color: transparent;
    }

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
                <h4 class="">Servicio de Activo</h5>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 m-auto">
                {{-- <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="id_selec">
                    <label class="form-check-label" for="id_selec">Seleccion multiple</label>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verCargaMulti" onclick="cargarMMultiple()" id="btn-sel-mul" hidden>
                    Carga Multiple
                </button> --}}
            </div>
        </div>
    </div>

    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])

    <div class="section-body">

        {{-- <div class="row">
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
                                                <label>Proyectos:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('cod_serv', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="cod_serv" checked> (Seleccionar todo)</label>
                                                @foreach ($servicios as $servicio)
                                                    <label><input class="input-filter" name="cod_serv" type="checkbox" value="{{$servicio->codigo_servicio}}" checked> {{$servicio->codigo_servicio}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 200px;">
                                            <div class="">
                                                <label>Supervisor:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('sup', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="sup" checked> (Seleccionar todo)</label>
                                                @foreach ($supervisores as $supervisor)
                                                    <label><input name="sup" type="checkbox" value="{{$supervisor->nombre_empleado}}" checked> {{$supervisor->nombre_empleado}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @role('SUPERVISOR')
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="row">
                                        <div class="d-flex flex-row align-items-start justify-content-around">
                                            <div class="card-body d-flex flex-column" style="height: 200px;">
                                                <div class="">
                                                    <label>Responsable:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('res', this)">
                                                </div>
                                                <div class="d-flex flex-column overflow-auto">
                                                    <label style="font-style: italic"><input name="filter" type="checkbox" value="res" checked> (Seleccionar todo)</label>
                                                    @foreach ($responsables as $responsable)
                                                        <label><input name="res" type="checkbox" value="{{$responsable->nombre_empleado}}" checked> {{$responsable->nombre_empleado}}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endrole
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 200px;">
                                            <div class="">
                                                <label>Estados:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('est', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="est" checked> (Seleccionar todo)</label>
                                                @foreach ($estados as $estado)
                                                    @switch($tipo_orden)
                                                        @case(1)
                                                            @if ($estado->id_estado < 9 && $estado->id_estado != 5)
                                                                <label><input name="est" type="checkbox" value="{{$estado->nombre}}" checked> {{$estado->nombre}}</label>
                                                            @else
                                                                <label><input name="est" type="checkbox" value="{{$estado->nombre}}"> {{$estado->nombre}}</label>
                                                            @endif
                                                            @break
                                                        @case(2)
                                                            @if ($estado->id_estado < 5)
                                                                <label><input name="est" type="checkbox" value="{{$estado->nombre}}" checked> {{$estado->nombre}}</label>
                                                            @else
                                                                <label><input name="est" type="checkbox" value="{{$estado->nombre}}"> {{$estado->nombre}}</label>
                                                            @endif
                                                            @break
                                                        @case(3)
                                                            @if ($estado->id_estado < 6)
                                                                <label><input name="est" type="checkbox" value="{{$estado->nombre}}" checked> {{$estado->nombre}}</label>
                                                            @else
                                                                <label><input name="est" type="checkbox" value="{{$estado->nombre}}"> {{$estado->nombre}}</label>
                                                            @endif
                                                            @break
                                                            
                                                    @endswitch
                                                        
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Centramos la paginacion a la derecha -->
                            {{-- @if (count($proyectos) != 0)
                                <div class="pagination justify-content-end">
                                    {!! $proyectos->links() !!}
                                </div>
                            @endif --}}
                        <div class="table-responsive">
                            <div id="tableFixHead">
                                <table class="table table-striped mt-2" id="example">
                                    <thead style="height:50px;background-color:#28587d;">
                                        <th class='text-center' style="color:#fff;width: 1vw">Prioridad</th>
                                        {{-- @if ($opcion == 3)
                                            <th class='text-center' style="color:#fff;width: 2vw">SSI</th>
                                        @endif --}}
                                        {{-- <th class='text-center' style="color:#fff;">Fecha</th> --}}
                                        <th class='ml-3 text-center' style="color:#fff;width: 10vw">ID</th>
                                        <th class='text-center' style="color:#fff;width: 8vw">Nombre</th>
                                        <th class='text-center' style="color:#fff;">Tipo</th>
                                        {{-- <th class='text-center' style="color:#fff;">Tipo proyecto</th> --}}
                                        <th class='text-center' style="color:#fff;width: 5vw">Lider</th>
                                        <th class='text-center' style="color:#fff;">Progreso</th>
                                        {{-- <th class='text-center' style="color:#fff;">Ordenes</th> --}}
                                        <th class='text-center' style="color:#fff;">Estado</th>
                                        <th class='text-center' style="color:#fff;width: 5vw">Fecha inicio</th>
                                        <th class='text-center' style="color:#fff;width: 5vw">Fecha limite</th>
                                        <th class='text-center' style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody  id="accordion">
                                        @php
                                            $idCount = 0;
                                        @endphp
                                        @foreach ($proyectos as $proyecto)
                                            <tr>
                                                <td class='text-center' style="vertical-align: middle;" data-order={{$proyecto->prioridad_servicio ?? 9999999999999}}>{{$proyecto->prioridad_servicio ?? 'S/P'}}</td>

                                                {{-- @if ($opcion == 3)
                                                    <td class='text-center' style="vertical-align: middle;">{{$proyecto->getSolicitud->id_solicitud ?? '-'}}</td>
                                                @endif --}}

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->codigo_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->nombre_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->nombre_subtipo_servicio}}</td>

                                                {{-- <td class='text-center' style="vertical-align: middle;"><abbr title="{{$proyecto->lider ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($proyecto->lider, 0, 10) ?? "-"}} <i class="fas fa-eye"></i></abbr></td> --}}
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->lider ?? '-'}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">
                                                    <div class="progress position-relative" style="background-color: #b2baf8">
                                                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$proyecto->progreso}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$proyecto->total_ord_completa.'/'.$proyecto->total_ord}}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$proyecto->nombre_estado}}</td>

                                                <td class= 'text-center'style="vertical-align: middle;">{{$proyecto->fecha_inicio}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$proyecto->fecha_limite}}</td>

                                                <td>
                                                    <div class="row justify-content-center">
                                                        <div class="row justify-content-center" >
                                                            <button class="btn btn-primary w-100 my-auto" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProyectos{{$idCount}}" aria-expanded="false" aria-controls="collapseProyectos{{$idCount}}">
                                                                Opciones <i class="fas fa-chevron-down m-auto"></i>
                                                            </button>
                                                        </div>
                                                        <div class="collapse" data-bs-parent="#accordion" id="collapseProyectos{{$idCount}}">
                                                            @can('MODIFICAR-PRIORIDAD-PROYECTO')
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modificarPrioridadModal" onclick="cargarModalModif({{$proyecto->id_servicio}}, this)">
                                                                        Prioridad
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            @endcan
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['proyectos.gestionar', $proyecto->id_servicio], 'style' => 'display:inline']) !!}
                                                                        {{-- {!! Form::text('prefijo', $prefijo, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!}
                                                                        {!! Form::text('tipo', $tipo, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!} --}}
                                                                        {{-- {!! Form::text('opcion', $opcion, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!} --}}
                                                                    {!! Form::submit('Gestionar', ['class' => 'btn btn-success w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->prioridad_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->codigo_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->nombre_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->nombre_subtipo_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;"><abbr title="{{$proyecto->lider ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($proyecto->lider, 0, 10) ?? "-"}} <i class="fas fa-eye"></i></abbr></td>

                                                <td class= 'text-center' style="vertical-align: middle;">
                                                    <div class="progress position-relative" style="background-color: #b2baf8">
                                                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$proyecto->getOrdenesRealizadasPorcentaje()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$proyecto->getOrdenesRealizadas()}}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$proyecto->nombre_estado}}</td>

                                                <td class= 'text-center'style="vertical-align: middle;">{{$proyecto->fecha_inicio}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$proyecto->fecha_limite}}</td>
                                                <td>
                                                    <div class="row justify-content-center">
                                                        <div class="row justify-content-center" >
                                                            <button class="btn btn-primary w-100 my-auto" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProyectos{{$idCount}}" aria-expanded="false" aria-controls="collapseProyectos{{$idCount}}">
                                                                Opciones <i class="fas fa-chevron-down m-auto"></i>
                                                            </button>
                                                        </div>
                                                        <div class="collapse" data-bs-parent="#accordion" id="collapseProyectos{{$idCount}}">
                                                            @can('MODIFICAR-PRIORIDAD-PROYECTO')
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modificarPrioridadModal" onclick="cargarModalModif({{$proyecto->id_servicio}}, this)">
                                                                        Prioridad
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            @endcan
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['proyectos.gestionar', $proyecto->id_servicio], 'style' => 'display:inline']) !!}
                                                                        {!! Form::text('prefijo', $prefijo, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!}
                                                                        {!! Form::text('tipo', $tipo, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!}
                                                                    {!! Form::submit('Gestionar', ['class' => 'btn btn-success w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr> --}}
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
    </div>
    
    <script src="{{ asset('js/change-td-color.js') }}"></script>
    
    {{-- <script src="{{ asset('js/change-td-color.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/filter.js') }}"></script>
    <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/ordenes.js') }}"></script>
    <script src="{{ asset('js/filter-to-filter.js') }}"></script>
    <script type="module" > 
        import {crearCuadrOrdenes, cargarModalVerOrden, obtenerPartes, modificarFormularioConArgumentos, cargarModalEditarOrden, colorEncabezadoPorTipoDeOrden} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
        window.crearCuadrOrdenes = crearCuadrOrdenes;
        window.cargarModalVerOrden = cargarModalVerOrden;
        window.obtenerPartes = obtenerPartes;
        window.modificarFormularioConArgumentos= modificarFormularioConArgumentos;
        window.cargarModalEditarOrden = cargarModalEditarOrden;
        window.colorEncabezadoPorTipoDeOrden = colorEncabezadoPorTipoDeOrden;
    </script> --}}
</section>

<script>
    $(document).ready( function () {
        table = $('#example').DataTable({
                    language: {
                            lengthMenu: 'Mostrar _MENU_ registros por pagina',
                            zeroRecords: 'No se ha encontrado registros',
                            info: 'Mostrando pagina _PAGE_ a _PAGES_ de _TOTAL_ ',
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
                        "aaSorting": [],
                        "pageLength": 100
                });
    });
    
</script>

{{-- @include('Ingenieria.Servicios.Ordenes.modal.crear-parte-multiple') --}}

{{-- <script>
    let x = '';
    let ind_rw = '';
    let id_emp = {{Auth::user()->getEmpleado->id_empleado}};
    let es_super = {{$es_sup}};
    var table;
    $("#loading").show();
    $(document).ready( function () {
        
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        //dudoso
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'orden';

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
                console.log(error);
            }
        }));
        
        let tipo_orden = window.location.pathname.substring(9, 10);
        modificarFormularioConArgumentos(tipo_orden, 'formulario-editar-orden', true);
        document.getElementById('encabezado_ordenes').style.backgroundColor = colorEncabezadoPorTipoDeOrden(tipo_orden);
        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
            var positions = $('input:checkbox[name="sup"]:checked').map(function() {
                return this.value;
            }).get();
        
            if (positions.length === 0) {
                return true;
            }
            
            if (positions.indexOf(searchData[7]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="res"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[8]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="est"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[6]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="cod_serv"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }


            if (offices.indexOf(searchData[3]) !== -1) {
                return true;
            }
            
            return false;
            }
        );
    table = $('#example').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ a _PAGES_ de _TOTAL_ ',
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
                "aaSorting": [],
                "pageLength": 100
        });
        
    $('input:checkbox').on('change', function () {
        table.draw();
    });
    
    table.on('draw', function () {
        changeTdColor();
    })

    $('#example tbody').on('click', 'tr', function () {
        ind_rw = table.row(this).index();
        // let a = table.row(this).index();
        // var temp = table.row(a).data();
        // temp[0] = 'Tom';
        // table.row(this)
        // .data(temp)
        // .draw();
   });

    $('#verPartesModal').on('hidden.bs.modal', function (e) {
        nuevoParte();
        actRow();
    })

    $('#editarOrdenModal').on('hidden.bs.modal', function (e) {
        actRow();
    })


    $(".nuevo-editar-parte").on('submit', function(evt){
            evt.preventDefault();     
            var url_php = $(this).attr("action"); 
            var type_method = $(this).attr("method"); 
            var form_data = $(this).serialize();
            let html = '';
            let id_orden = document.getElementById('m-ver-parte-orden').value;
            $.ajax({
                type: type_method,
                url: url_php,
                data: form_data,
                success: function(data) {
                    //console.log(data);
                    opcion = parseInt(data.resultado);
                    switch (opcion) {
                        case 1:
                            html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                            Parte creado con exito
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                            break;
                        case 2:
                            id = document.getElementById('m-id-parte').value;
                            html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                            Parte cod. `+id+` actualizado con exito
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                            break;
                        case 6:
                            html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                        No se puede actualizar un parte de la cual no eres responsable.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                            break;
                        default:
                            html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                        Ocurrio un error
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                            break;
                    }
                    $('#alert').html(html)
                    recargarPartes(id_orden, data.tipo_orden);
                    nuevoParte();
                    setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);
                }
            });
    });

    $(".nuevo-editar-orden").on('submit', function(evt){
            evt.preventDefault();     
            // console.log('hola');

            var url_php = $(this).attr("action"); 
            var type_method = $(this).attr("method"); 
            var form_data = $(this).serialize();

            $.ajax({
                type: type_method,
                url: url_php,
                data: form_data,
                success: function(data) {
                    // console.log(data);
                    html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modalOrd">
                                            `+data+`
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                    $('#alertOrd').html(html)
                    setTimeout(function(){document.getElementById('msj-modalOrd').hidden = true;},3000);
                    /*
                    opcion = parseInt(data.resultado);
                    switch (opcion) {
                        case 1:
                            html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                            Parte creado con exito
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                            break;
                        case 2:
                            id = document.getElementById('m-id-parte').value;
                            html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                            Parte cod. `+id+` actualizado con exito
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                            break;
                        case 6:
                            html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                        No se puede actualizar un parte de la cual no eres responsable.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                            break;
                        default:
                            html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                        Ocurrio un error
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                            break;
                    }
                    $('#alert').html(html)
                    recargarPartes(id_orden, data.tipo_orden);
                    nuevoParte();
                    setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);
                    */
                }
            });
            actRow();
    });
        $('#id_selec').on('change', mostrarSelec);
        $("#loading").hide();
    } );
    
</script>

<script>
    function mostrarFiltro(){
        let cuadro_filtro = document.getElementById("demo");
        if ($('#demo').is(":hidden")) {
            cuadro_filtro.hidden = false;
        }else{
            cuadro_filtro.hidden = true;
        }
    }

    function limpiarFiltro(){
        $('input[type=checkbox]').prop("checked", false);
        var table = $('#example').DataTable();
        table.draw();
    }


    function mostrarSelec() {
        let colum_sel = document.getElementsByClassName('chk-input');
        let enca = document.getElementById('enc_sel');
        let btn = document.getElementById('btn-sel-mul'); 

        if ($("#id_selec").is(":checked")) {
            enca.hidden = false;
            btn.hidden = false;
            for (let index = 0; index < colum_sel.length; index++) {
                colum_sel[index].hidden = false;
            }
        } else {
            enca.hidden = true;
            btn.hidden = true;
            for (let index = 0; index < colum_sel.length; index++) {
                colum_sel[index].hidden = true;
            }
        }

    }

    function cargarMMultiple(){
        let ids = document.getElementById('m-parte-multiple-ids');
        let valores = [...document.querySelectorAll('input[name="id_ordenes[]"]:checked')].map(input => input.value);
        ids.value = valores;
    }
</script> --}}
@endsection