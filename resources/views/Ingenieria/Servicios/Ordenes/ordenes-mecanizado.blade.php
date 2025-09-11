@extends('layouts.app')
@section('titulo', 'Ordenes Mecanizado')
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
        <div class="d-flex flex-row col-12 align-items-center justify-content-between">
            <!-- Título -->
            <div class="col-auto">
                <h4 class="mb-0">Ordenes de Mecanizado</h4>
            </div>

            <!-- Botón y menú desplegable -->
            <div class="d-flex align-items-center">
                <div class="form-check form-switch me-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="id_selec">
                    <label class="form-check-label" for="id_selec">Seleccion<br>multiple</label>
                </div>
                <div class="form-check me-3" hidden id="chk-sel-all">
                    <input class="form-check-input" type="checkbox" value="" id="checkSelAll">
                    <label class="form-check-label" for="checkSelAll">
                    Seleccionar<br>todo
                    </label>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verCargaMulti" onclick="cargarMMultiple()" id="btn-sel-mul">
                    Carga<br>Multiple
                </button>
            </div>
        </div>
    </div>
    {!! Form::text('opcion_tipo', 3, ['class' => 'form-control', 'hidden', 'id' => 'opcion-tipo']) !!}

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
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
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
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 200px;">
                                            <div class="">
                                                <label>Manufactura:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('sup', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="sup" checked> (Seleccionar todo)</label>
                                                @foreach ($manufacturas as $man)
                                                    <label><input name="sup" type="checkbox" value="{{$man->manufactura ?? '-'}}" checked> {{$man->manufactura ?? '-'}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 200px;">
                                            <div class="">
                                                <label>Estado:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('est', this)">
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
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 200px;">
                                            <div class="">
                                                <label>Operacion:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('res', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="res" checked> (Seleccionar todo)</label>
                                                @foreach ($operaciones as $ope)
                                                    <label><input name="res" type="checkbox" value="{{$ope->ope_act ?? '-'}}" checked> {{$ope->ope_act ?? '-'}}</label>
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
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @include('layouts.loanding')
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead id="encabezado_ordenes">
                                    <th class='text-center' style="color:#fff;min-width:2vw" hidden id="enc_sel"></th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Prioridad</th>
                                    <th class='text-center' style="color:#fff; width:13vw">Proyecto</th>
                                    <th class='text-center' style="color:#fff;" hidden>Proyecto</th>
                                    <th class='text-center' style="color:#fff;min-width:14vw">Orden</th>
                                    <th class='text-center' style="color:#fff;min-width:8vw">Manufactura</th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Progreso</th>
                                    <th class='text-center' style="color:#fff;min-width:4vw">Estado</th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Operacion Actual</th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Estado Ope. Actual</th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Fecha limite</th>
                                    <th class='text-center' style="color: #fff; width:10%">Acciones</th>
                                </thead>
                                
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($ordenes as $orden)
                                        <tr data-id="{{$orden->id_orden}}">
                                            <td hidden class="chk-input" style="vertical-align: middle; padding: 0;">
                                                <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                                  <input class="form-check-input" type="checkbox" value="{{$orden->id_orden}}" id="flexCheck{{$orden->id_orden}}" name="id_ordenes[]">
                                                </div>
                                            </td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->prioridad_servicio ?? 'S/P'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->nombre_servicio ?? '-'}}" style="text-decoration:none; font-variant: none;">{{$orden->codigo_servicio ?? '-'}} <i class="fas fa-eye"></i></abbr></td>
                                            
                                            <td class='text-center' style="vertical-align: middle;" hidden>{{$orden->codigo_servicio ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_orden ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->manufactura ?? '-'}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">
                                                <div class="progress position-relative" style="background-color: #b2baf8">
                                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$orden->getProgreso()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$orden->total_ope_completo.'/'.$orden->total_ope}}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_estado ?? ''}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->ope_act ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nom_est_ope_act ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->fecha_limite ?? '-'}}</td>
        
                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes{{$idCount}}" aria-expanded="false" aria-controls="collapseOrdenes{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseOrdenes{{$idCount}}">
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden({{$orden->id_orden}}, {{$tipo_orden}})">
                                                                    Ver
                                                                </button>
                                                            </div>
                                                        </div>

                                                        @if ($tipo_orden === 3)
                                                            <div class="row my-2">
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['ordenes.hdr', $orden->id_orden], 'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('HDR', ['class' => 'btn btn-info w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, {{$tipo_orden}})">
                                                                    Partes
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            @can('EDITAR-ORDENES')
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarOrden({{$orden->id_orden}}, '{{$orden->descripcion_etapa}}')">
                                                                    Editar
                                                                </button> 
                                                            </div>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
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

    @role('SUPERVISOR')
        @php
            $es_sup = 1;
        @endphp
    @else
        @php
            $es_sup = 0;
        @endphp
    @endrole
    <script src="{{ asset('js/change-td-color.js') }}"></script>
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
    </script>
</section>

@include('Ingenieria.Servicios.Ordenes.modal.ver-orden')
@include('Ingenieria.Servicios.Ordenes.modal.editar-orden')
@include('Ingenieria.Servicios.Ordenes.modal.ver-partes')
@include('Ingenieria.Servicios.Ordenes.modal.crear-parte-multiple')

<script>
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
            
            if (positions.indexOf(searchData[5]) !== -1) {
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
            
            if (offices.indexOf(searchData[7]) !== -1) {
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
                        info: 'Mostrando pagina _PAGE_ a _PAGES_ de _TOTAL_',
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
                    order: [[1, 'asc']],
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
            // actRow();
            actualizarRowOrden();
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

        $("#npm-form-multi").on('submit', function(evt){
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
                        switch (data) {
                            case '1':
                                document.getElementById('alert-mp').innerHTML = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                                                                    Parte creado con exito
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>`;
                                document.getElementById('alert-mp').hidden = false;
                                break;
                        
                            default:
                                break;
                        }
                        setTimeout(function(){document.getElementById('alert-mp').hidden = true;},3000);
                        // html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modalOrd">
                        //                         `+data+`
                        //                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        //                             <span aria-hidden="true">&times;</span>
                        //                         </button>
                        //                     </div>`;
                        // $('#alertOrd').html(html)
                        // setTimeout(function(){document.getElementById('msj-modalOrd').hidden = true;},3000);
                    }
                });
        });

        $('#id_selec').on('change', mostrarSelec);

        document.getElementById('checkSelAll').addEventListener('change', event => {

            if (document.getElementById('checkSelAll').checked) {
                table.rows({ search: 'applied' }).nodes().to$().find('input[type="checkbox"][name="id_ordenes[]"]').prop('checked', true);
            } else {
                table.rows({ search: 'applied' }).nodes().to$().find('input[type="checkbox"][name="id_ordenes[]"]').prop('checked', false);
            }

        })

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
        let selAll = document.getElementById('chk-sel-all');

        if ($("#id_selec").is(":checked")) {
            enca.hidden = false;
            // btn.hidden = false;
            selAll.hidden = false;
            for (let index = 0; index < colum_sel.length; index++) {
                colum_sel[index].hidden = false;
            }
        } else {
            enca.hidden = true;
            // btn.hidden = true;
            selAll.hidden = true;
            for (let index = 0; index < colum_sel.length; index++) {
                colum_sel[index].hidden = true;
            }
        }

    }

    function cargarMMultiple(){
        let ids = document.getElementById('m-parte-multiple-ids');
        let valores = [...document.querySelectorAll('input[name="id_ordenes[]"]:checked')].map(input => input.value);
        ids.value = valores;
        cargarEstadosMecanizados();
        let html = '';
        $.ajax({
            type: "post",
            url: '/orden/obtener-info-orden-mul',
            data: {
                id: valores,
            },
            success: function (response) {
                response.forEach(e => {
                    html += `<tr>
                                <td class="text-center" style="vertical-align: middle;">`+e.codigo_servicio+`</td>
                                <td class="text-center" style="vertical-align: middle;">`+e.nombre_orden+`</td>
                            </tr>`;
                });

                document.getElementById('npm_body_ord').innerHTML = html;
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function cargarEstados(){
        let c_bx_estados = document.getElementById("cbx_estado") ? document.getElementById("cbx_estado") : '';
        let c_bx_estados_edit = document.getElementById("cbx_estado_edit") ? document.getElementById("cbx_estado_edit") : '';
        let html_estados = '';
        $.when($.ajax({
            type: "post",
            url: '/orden/obtener-estados', 
            data: {
                
            },
        success: function (response) {
            response.forEach(element => {
                html_estados += `
                                    <option value="`+element.id_estado+`">`+element.nombre_estado
                                    +`</option> 
                                    `
            });
            c_bx_estados != '' ? c_bx_estados.innerHTML += html_estados : '';
            c_bx_estados_edit != '' ? c_bx_estados_edit.innerHTML += html_estados : '';
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }

    function cargarEstadosMecanizados(){
        // let c_bx_estados_mec =  document.getElementById("cbx_estado_mec") ? document.getElementById("cbx_estado_mec") : '';
        // let c_bx_estados_mec_edit =  document.getElementById("cbx_estado_mec_edit") ? document.getElementById("cbx_estado_mec_edit") : '';
        let html_estados_mec = '';
        $.when($.ajax({
            type: "post",
            url: '/orden/obtener-estados-mecanizados', 
            data: {
                
            },
        success: function (response) {
            response.forEach(element => {
                html_estados_mec += `
                                    <option value="`+element.id_estado_mecanizado+`">`+element.nombre_estado_mecanizado
                                    +`</option> 
                                    `
            });
            // c_bx_estados_mec != '' ? c_bx_estados_mec.innerHTML += html_estados_mec : '';
            // c_bx_estados_mec_edit != '' ? c_bx_estados_mec_edit.innerHTML += html_estados_mec : '';
            document.getElementById('npm-m-ver-parte-estado').innerHTML += html_estados_mec;
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }

    function cargarEstadosManufacturas(){
        let c_bx_estados_man = document.getElementById("cbx_estado_man") ? document.getElementById("cbx_estado_man") : '';
        let c_bx_estados_man_edit = document.getElementById("cbx_estado_man_edit") ? document.getElementById("cbx_estado_man_edit") : '';
        let html_estados_man = '';
        $.when($.ajax({
            type: "post",
            url: '/orden/obtener-estados-manufacturas', 
            data: {
                
            },
        success: function (response) {
            response.forEach(element => {
                html_estados_man += `
                                    <option value="`+element.id_estado_manufactura+`">`+element.nombre_estado_manufactura
                                    +`</option> 
                                    `
            });
            c_bx_estados_man != '' ? c_bx_estados_man.innerHTML += html_estados_man : '';
            c_bx_estados_man_edit != '' ? c_bx_estados_man_edit.innerHTML += html_estados_man : '';
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }

    function actualizarRowOrden(){
        let valor = document.getElementById('m-ver-parte-orden').value;

        $.ajax({
            type: "post",
            url: '/orden/obtener-orden-act',
            data: {
                id: valor,
                opcion: 3,
            },
            success: function (res) {
                let fila = $('#example tbody tr[data-id="' + res.id_orden+ '"]');
                let rowIndex = table.row(fila).index();
                table.cell(rowIndex, 7).data(res.nombre_estado).draw();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
</script>
@endsection