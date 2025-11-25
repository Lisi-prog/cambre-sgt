@extends('layouts.app')
@section('titulo', 'Agregar mecanizado')
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
      .table {
        zoom: 100%;
    }
    table tbody td {
        padding: 0px 10px !important;
        height: 0px !important;
    }
    .col-4 {
        padding: 5px !important;
    }
</style>
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Creacion de ordenes de mecanizado para una manufactura</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Orden de manufactura</h5>
                                </div>
                                <div hidden>
                                    {{-- SOLO PARA OBTENER EL ID DE LA ORDEN --}}
                                    {!! Form::text('id_servicio', $orden_manufactura->getOrden->getEtapa->id_servicio, ['style' => 'disabled;', 'readonly'=> 'true', 'id' => 'id_servicio']) !!}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarManufactura({{$orden_manufactura->id_orden}}, '{{$orden_manufactura->getOrden->nombre_orden}}')">
                                        Editar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('nom_orden_manuf', 'ID-CONJUNTO:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_orden_manuf', $orden_manufactura->getOrden->nombre_orden, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('supervisor_orden_manuf', "Supervisor de orden:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('supervisor_manuf', $orden_manufactura->getOrden->getSupervisor(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('responsable_orden_manuf', "Responsable de orden:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('responsable_manuf', $orden_manufactura->getOrden->getNombreResponsable(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_ini_manuf', "Fecha inicio:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_inicio_manuf',$orden_manufactura->getOrden->fecha_inicio, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_limite_manuf', "Fecha limite:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_limite_manuf', $orden_manufactura->getOrden->getPartes->sortBy('id_parte')->first()->fecha_limite, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('estado_manuf', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('estado_manuf', $orden_manufactura->getOrden->getEstado(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('prioridad', "Prioridad Nº:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('prioridad', $proyecto->prioridad_servicio, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}
                
                {{-- Etapas del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Ordenes de mecanizado</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <button id="nueva_orden_meca" value="3" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearOrdenMecanizadoModal" onclick="cargarModalCrearMecanizado()">
                                        Nueva
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="tablaEtapas" class="table table-hover mt-2" class="display">
                                    <thead style="background-color: #d37c00">
                                        <th class="text-center" scope="col" style="color:#fff;width:10%">ID-PIEZA</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Cantidad</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Revision</th>
                                        {{-- <th class="text-center" scope="col" style="color:#fff;">Ruta</th> --}}
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha inicio</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Fecha limite</th>      
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Duracion estimada</th>     
                                        <th class="text-center" scope="col" style="color:#fff;width:13%;">Acciones</th>                                                   
                                    </thead>
                                    <tbody id="accordion">
                                        @php
                                            $idCount = 0;
                                        @endphp
                                        @foreach ($orden_manufactura->getOrdenesMecanizado as $orden_mecanizado)
                                            <tr>
                                                <td class= 'text-center' >{{$orden_mecanizado->getOrden->nombre_orden ?? '-'}}</td> 

                                                <td class= 'text-center' >{{$orden_mecanizado->cantidad ?? '-'}}</td>

                                                <td class= 'text-center' >{{$orden_mecanizado->revision ?? '-'}}</td>

                                                <td class= 'text-center' >{{$orden_mecanizado->getOrden->fecha_inicio ?? '-'}}</td>

                                                <td class= 'text-center' >{{$orden_mecanizado->getOrden->getPartes->sortBy('id_parte')->first()->fecha_limite ?? '-'}}</td>
                                                
                                                <td class= 'text-center' >{{$orden_mecanizado->getOrden->getduracionHoraMinuto() ?? '-'}}</td>

                                                <td>
                                                    <div class="row justify-content-center" >
                                                        <div class="row justify-content-center" >
                                                            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMecanizados{{$idCount}}" aria-expanded="false" aria-controls="collapseMecanizados{{$idCount}}">
                                                                Opciones
                                                            </button>
                                                        </div>
                                                        <div class="collapse" data-bs-parent="#accordion" id="collapseMecanizados{{$idCount}}">
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarMecanizado({{$orden_mecanizado->id_orden}}, '{{$orden_mecanizado->getOrden->getEtapa->descripcion_etapa}}')">
                                                                        Editar
                                                                    </button> 
                                                                </div>
                                                            </div>
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['orden.mec.quitar', $orden_mecanizado->id_orden_mecanizado], 'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Quitar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea QUITAR la orden de mecanizado de esta orden de manufactura?');"]) !!}
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                            <div class="row my-2 justify-content-center" hidden>
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['orden.eliminar', $orden_mecanizado->getOrden->id_orden], 'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                </div>
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

                    {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="d-flex">
                                        <div class="me-auto">
                                            
                                        </div>
                                        <div class="p-1">
                                            
                                        </div>
                                        <div class="p-1">
                                            {!! Form::open(['method' => 'GET', 'route' => ['proyectos.gestionar', $orden_manufactura->getOrden->getEtapa->getServicio->id_servicio], 'style' => '']) !!}
                                            {!! Form::submit('volver', ['class' => 'btn btn-primary']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                

        <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}">
            
        </script>

        <script>
            $(document).ready(function () {
                let id_servicio = document.getElementById('id_servicio').value;
                var url = '{{route('proyectos.gestionar', ':id_servicio')}}';
                url = url.replace(':id_servicio', id_servicio);
                document.getElementById('volver').href = url;
                //modificarFormularioConArgumentos(3, 'formulario-crear-orden-meca', false);
                $('#exampless').DataTable({
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
                        "aaSorting": []
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
                            html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modalOrd">
                                                    `+data+`
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>`;
                            $('#alertOrd').html(html)
                            setTimeout(function(){document.getElementById('msj-modalOrd').hidden = true;},3000);
                        }
                    });
                });
            });
            
        </script>
        <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
        <script type="module"> 
            import {cargarModalVerOrden, cargarModalEditarManufactura, cargarModalEditarMecanizado, cargarModalCrearMecanizado} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
            window.cargarModalVerOrden = cargarModalVerOrden;
            window.cargarModalEditarManufactura = cargarModalEditarManufactura;
            window.cargarModalEditarMecanizado = cargarModalEditarMecanizado;
            window.cargarModalCrearMecanizado = cargarModalCrearMecanizado;
        </script>
    </section>
@include('Ingenieria.Servicios.Ordenes.modal.crear-orden-mecanizado')
@include('Ingenieria.Servicios.Ordenes.modal.editar-orden')

    
@endsection

@section('js')

@endsection