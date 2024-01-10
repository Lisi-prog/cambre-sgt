@extends('layouts.app')
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
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarProyectoModal">
                                        Editar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('nom_orden', 'Nombre orden:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_orden', $orden_manufactura->getOrden->nombre_orden, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('supervisor_orden', "Supervisor de orden:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('supervisor', $orden_manufactura->getOrden->getSupervisor(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('responsable_orden', "Responsable de orden:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('responsable', $orden_manufactura->getOrden->getNombreResponsable(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_ini', "Fecha inicio:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_inicio',\Carbon\Carbon::parse($orden_manufactura->getOrden->fecha_inicio)->format('d-m-Y'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_limite', "Fecha limite:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_limite', \Carbon\Carbon::parse($orden_manufactura->getOrden->getPartes->sortBy('id_parte')->first()->fecha_limite)->format('d-m-Y'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('estado', $orden_manufactura->getOrden->getPartes->sortBy('id_parte')->first()->getParteManufactura->getEstadoManufactura->nombre_estado_manufactura, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
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
                                    <button id="nueva_orden_meca" value="3" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearOrdenMecanizadoModal">
                                        Nueva
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="tablaEtapas" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;">Nombre</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Cantidad</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Revision</th>
                                        {{-- <th class="text-center" scope="col" style="color:#fff;">Ruta</th> --}}
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha inicio</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Fecha limite</th>      
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Duracion estimada</th>     
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Acciones</th>                                                   
                                    </thead>
                                    <tbody>
                                        @foreach ($orden_manufactura->getOrdenesMecanizado as $orden_mecanizado)
                                            <tr>
                                                <td class= 'text-center' >{{$orden_mecanizado->getOrden->nombre_orden}}</td> 

                                                <td class= 'text-center' >{{$orden_mecanizado->cantidad}}</td>

                                                <td class= 'text-center' >{{$orden_mecanizado->revision}}</td>

                                                {{-- <td class= 'text-center' >{{$orden_mecanizado->ruta_pieza}}</td> --}}

                                                <td class= 'text-center' >{{\Carbon\Carbon::parse($orden_mecanizado->getOrden->fecha_inicio)->format('d-m-Y')}}</td>

                                                <td class= 'text-center' >{{\Carbon\Carbon::parse($orden_mecanizado->getOrden->getPartes->sortBy('id_parte')->first()->fecha_limite)->format('d-m-Y')}}</td>
                                                
                                                <td class= 'text-center' >{{$orden_mecanizado->getOrden->duracion_estimada}}</td>

                                                <td class='text-center'>
                                                    <div class="row my-2">
                                                        {{-- <div class="col-6">
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarEtapaModal" onclick="cargarModalEditar({{$etapa->id_etapa}}, {{$etapa->nombre_etapa}}, {{$etapa->fecha_inicio}}, {{$etapa->getResponsable->first()->getEmpleado->nombre_empleado}})">
                                                                Editar
                                                            </button>
                                                        </div> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   

        <script type="module"> 
            // import {crearCuadrOrdenes, cargarModalVerOrden, obtenerPartes} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
            // window.crearCuadrOrdenes = crearCuadrOrdenes;
            // window.cargarModalVerOrden = cargarModalVerOrden;
            // window.obtenerPartes = obtenerPartes;
        </script>

        <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}">
            
        </script>
        {{-- <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form2.js') }}"></script> --}}

        <script>
            $(document).ready(function () {
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
            });
            
            function cargarModalEditar(id, nombre, fecha, lider){
                let input_nombre_etapa = document.getElementById('input-nombre_etapa');
                let input_fec_ini = document.getElementById('input-fec_ini');
                //let id_puesto = document.getElementById('input_id_puesto');

                console.log(id);
                console.log(nombre);
                console.log(fecha);
                console.log(lider);

                const $select = document.querySelector('#mySelect');
                $select.value = lider;
                //let nombre_puesto = b.parentNode.parentNode.parentNode.children[0].innerText;
                //let precio_hora = b.parentNode.parentNode.parentNode.children[1].innerText;

                //input_puesto.value = nombre_puesto;
                //costo_hora.value = precio_hora.replace('$ ', '').replace('.', '').replace(',', '.');
                //id_puesto.value = id;
            }
        </script>
        {{-- <script src="{{ asset('js/change-td-color.js') }}"></script> --}}
    </section>
@include('Ingenieria.Servicios.Ordenes.modal.crear-orden-mecanizado')

    
@endsection

@section('js')

@endsection