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
@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 my-auto">
                <h4 class="">Ordenes de {{$tipo}}</h5>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
            </div>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {{-- <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['method' => 'GET', 'route' => ['ordenes.tipo', $tipo_orden], 'style' => 'display:inline']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-11">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Proyectos:</label>
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        @foreach ($codigos_servicio as $codigo_servicio)
                                                            <label><input name="cod_serv[]" type="checkbox" value="{{$codigo_servicio->id_servicio}}"> {{$codigo_servicio->codigo_servicio}}</label>
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
                                                        <label>Supervisor:</label>
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        @foreach ($supervisores as $supervisor)
                                                            <label><input name="supervisores[]" type="checkbox" value="{{$supervisor->id_empleado}}"> {{$supervisor->nombre_empleado}}</label>
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
                                                        <label>Responsable:</label>
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        @foreach ($responsables as $responsable)
                                                            <label><input name="responsables[]" type="checkbox" value="{{$responsable->id_empleado}}"> {{$responsable->nombre_empleado}}</label>
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
                                                        <label>Estados:</label>
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        @foreach ($estados as $estado)
                                                            <label><input name="estados[]" type="checkbox" value="{{$estado->id_estado}}"> {{$estado->nombre}}</label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1 my-auto">
                                
                                {!! Form::submit('Filtrar', ['class' => 'btn btn-success w-100']) !!}
                                {!! Form::close() !!}
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
                        <div class="row">
                            <button type="button" class="btn btn-primary-outline m-1 rounded" onclick="mostrarFiltro()">Filtros <i class="fas fa-caret-down"></i></button> 
                        </div>
                        <div class="row" id="demo" hidden>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 200px;">
                                            <div class="">
                                                <label>Proyectos:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                @foreach ($servicios as $servicio)
                                                    <label><input name="cod_serv" type="checkbox" value="{{$servicio->codigo_servicio}}"> {{$servicio->codigo_servicio}}</label>
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
                                                <label>Supervisor:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                @foreach ($supervisores as $supervisor)
                                                    <label><input name="sup" type="checkbox" value="{{$supervisor->nombre_empleado}}"> {{$supervisor->nombre_empleado}}</label>
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
                                                <label>Responsable:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                @foreach ($responsables as $responsable)
                                                    <label><input name="res" type="checkbox" value="{{$responsable->nombre_empleado}}"> {{$responsable->nombre_empleado}}</label>
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
                                                <label>Estados:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                @foreach ($estados as $estado)
                                                    <label><input name="est" type="checkbox" value="{{$estado->nombre}}"> {{$estado->nombre}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <button type="button" class="btn btn-primary-outline rounded" onclick="limpiarFiltro()">Limpiar</i></button> 
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
                        <!-- Centramos la paginacion a la derecha -->
                        {{-- <div class="pagination justify-content-end">
                                {!! $CategoriasLaborales->links() !!}
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead id="encabezado_ordenes">
                                    <th class='text-center' style="color:#fff;width:7%">Prioridad</th>
                                    <th class='text-center' style="color:#fff; width:13vw">Proyecto</th>
                                    <th class='text-center' style="color:#fff;" hidden>Proyecto</th>
                                    <th class='text-center' style="color:#fff;">Etapa</th>
                                    <th class='text-center' style="color:#fff;">Orden</th>
                                    <th class='text-center' style="color:#fff;width:10%">Estado</th>
                                    <th class='text-center' style="color:#fff;">Supervisor</th>
                                    <th class='text-center' style="color:#fff;">Responsable</th>
                                    <th class='text-center' style="color:#fff;">Fecha limite</th>
                                    <th class='text-center' style="color:#fff;">Fecha finalizacion</th>
                                    <th class='text-center' style="color: #fff; width:10%">Acciones</th>
                                </thead>
                                
                                <tbody>
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($ordenes as $orden)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->getEtapa->getServicio->prioridad_servicio ?? '-'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->getEtapa->getServicio->nombre_servicio ?? '-'}}" style="text-decoration:none; font-variant: none;">{{$orden->getEtapa->getServicio->codigo_servicio ?? '-'}} <i class="fas fa-eye"></i></abbr></td>

                                            <td class='text-center' style="vertical-align: middle;" hidden>{{$orden->getEtapa->getServicio->codigo_servicio ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->getEtapa->descripcion_etapa ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->nombre_orden ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($orden->nombre_orden, 0, 13) ?? '-'}} <i class="fas fa-eye"></i></abbr></td>

                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$orden->getOrdenDe->getNombreTipoOrden()}}</td> --}}
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->getPartes->sortByDesc('id_parte')->first()->getParteDe->getNombreEstado() ?? ''}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->getSupervisor() ?? '-'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->getNombreResponsable() ?? '-'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{ $orden->getPartes->sortByDesc('id_orden')->first()->fecha_limite ? \Carbon\Carbon::parse($orden->getPartes->sortByDesc('id_orden')->first()->fecha_limite ?? '')->format('d-m-Y') : '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->getFechaFinalizacion()}}</td>
        
                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes{{$idCount}}" aria-expanded="false" aria-controls="collapseOrdenes{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" id="collapseOrdenes{{$idCount}}">
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden({{$orden->id_orden}}, {{$orden->getOrdenDe->getTipoOrden()}})">
                                                                    Ver
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['orden.partes', base64url_encode($orden->id_orden), $tipo_orden], 'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Parte', ['class' => 'btn btn-warning w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            @can('EDITAR-ORDENES')
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarOrden({{$orden->id_orden}}, '{{$orden->getEtapa->descripcion_etapa}}')">
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
    <script src="{{ asset('js/change-td-color.js') }}"></script>
    <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
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

<script>
    let x = '';
    $(document).ready( function () {
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        //dudoso
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
            
            if (positions.indexOf(searchData[6]) !== -1) {
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
            
            if (offices.indexOf(searchData[7]) !== -1) {
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
            
            if (offices.indexOf(searchData[5]) !== -1) {
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


            if (offices.indexOf(searchData[2]) !== -1) {
                return true;
            }
            
            return false;
            }
        );
    var table = $('#example').DataTable();
  
    $('input:checkbox').on('change', function () {
        table.draw();
    });

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
</script>

@endsection