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
                <div class="titulo page__heading py-1 fs-5">Gestionar Proyecto</div>
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
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <button type="button" class="btn btn-primary" onclick="mostrarActProyecto({{$proyecto->id_servicio}})">
                                        Actualizaciones
                                    </button>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 text-center">
                                    <h5 class="text-center">Proyecto</h5>
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
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('id_proyecto', "ID:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('id_proyecto', $proyecto->codigo_servicio, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('nom_proyecto', 'Nombre proyecto:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_proyecto', $proyecto->nombre_servicio, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('id_tipo', 'Tipo:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('id_sector', $proyecto->getSubTipoServicio->nombre_subtipo_servicio, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('lider_proyecto', "Lider de proyecto:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('prioridad',$proyecto->getResponsabilidad->getEmpleado->nombre_empleado, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_ini', "Fecha inicio:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_carga',\Carbon\Carbon::parse($proyecto->fecha_inicio)->format('d-m-Y'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_limite', "Fecha limite:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_limite', \Carbon\Carbon::parse($proyecto->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->fecha_limite)->format('d-m-Y'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('estado', $proyecto->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->getEstado->nombre_estado, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('prioridad', "Prioridad Nº:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('prioridad', $proyecto->prioridad_servicio, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}
                
                {{-- Actualizaciones del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_act_proyecto' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Actualizaciones proyecto</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearActModal">
                                        Nueva
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="tablaAct" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Codigo</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha carga</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Descripcion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Responsable</th>                                                          
                                    </thead>
                                    <tbody id="cuadro-act">
                                        
                                    </tbody>
                                </table>
                                </div>
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
                                    <h5 class="text-center">Etapas</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearEtapaModal">
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
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha inicio</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha fin real</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Ultima actualizacion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Acciones</th>                                                           
                                    </thead>
                                    <tbody>
                                        @foreach ($proyecto->getEtapas as $etapa)
                                            <tr>    
                                                <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td>
                                                
                                                <td class= 'text-center' >{{$etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->getEstado->nombre_estado}}</td>

                                                <td class= 'text-center' >{{$etapa->getResponsable->getEmpleado->nombre_empleado}}</td>

                                                <td class= 'text-center'>{{\Carbon\Carbon::parse($etapa->fecha_inicio)->format('d-m-Y')}}</td>

                                                <td class= 'text-center'>{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_limite)->format('d-m-Y')}}</td>

                                                <td class= 'text-center'>+late</td>

                                                <td class= 'text-center' >{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_carga)->format('d-m-Y H:i')}}</td>

                                                <td class='text-center'>
                                                    <div class="row my-2">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarEtapaModal" onclick="cargarModalEditarEtapa({{$etapa->id_etapa}})">
                                                                Editar
                                                            </button>
                                                        </div>
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-warning w-100" onclick="window.crearCuadrOrdenes({{$etapa->id_etapa}})">
                                                                Ordenes
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" onclick="mostrarActEtapa({{$etapa->id_etapa}})">
                                                                Actualizaciones
                                                            </button>
                                                        </div>
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
                {{-- ------------- --}}

                {{-- Actualizaciones de la etapa --}}
                <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_act_etapa' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Actualizaciones etapa</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearActEtaModal">
                                        Nueva
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="tablaAct" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Codigo</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha carga</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Descripcion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Responsable</th>                                                          
                                    </thead>
                                    <tbody id="cuadro-act-etapa">
                                        
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Ordenes del proyecto --}}
                
                    <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes' hidden>
                        <div class="card">
                            <div class="card-head">
                                <br>
                                <div class="row m-auto">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                        <h5 class="text-center">Ordenes</h5>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                                            Nueva
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div>
                                    <table id="example" class="table table-hover mt-2" class="display">
                                        <thead style="">
                                            <th class="text-center" scope="col" style="color:#fff;width:50%;">Orden</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:25%;">Tipo orden</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:20%;">Acciones</th>                                                           
                                        </thead>
                                        <tbody id="cuadro-ordenes">
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- ------------- --}}


                {{-- Partes del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12" id='parte_de_trabajo' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Parte de trabajo</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    {{-- {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.nuevavivalt', $obra->id_obr], 'style' => '']) !!}
                                    {!! Form::submit('Crear', ['class' => 'btn btn-success w-100']) !!}
                                    {!! Form::close() !!} --}}
                                </div>
                            </div>
                            {{-- <br>
                            <div class="text-center"><h5>Viviendas</h5></div>                         --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="example" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Fecha carga</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Observaciones</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Horas</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Supervisor</th>                                                           
                                    </thead>
                                    <tbody id="renglones_parte">
                                        
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        {{-- (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong> --}}
                                    </div>
                                    <div class="p-1">
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => 'proyectos.index', 'style' => '']) !!}
                                        {!! Form::submit('Volver', ['class' => 'btn btn-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="module"> 
            import {crearCuadrOrdenes, cargarModalVerOrden, obtenerPartes} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
            window.crearCuadrOrdenes = crearCuadrOrdenes;
            window.cargarModalVerOrden = cargarModalVerOrden;
            window.obtenerPartes = obtenerPartes;
        </script>

        <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}">
            
        </script>
        <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/gestionar.js') }}"></script>

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
        </script>

    </section>
    @include('Ingenieria.Servicios.Proyectos.modal.crear-etapa')
    @include('Ingenieria.Servicios.Proyectos.modal.editar-etapa')
    @include('Ingenieria.Servicios.Proyectos.modal.crear-orden')
    @include('Ingenieria.Servicios.Proyectos.modal.ver-orden')
    @include('Ingenieria.Servicios.Proyectos.modal.editar-proyecto')
    @include('Ingenieria.Servicios.Proyectos.modal.crear-act')
    @include('Ingenieria.Servicios.Proyectos.modal.crear-act-eta')

{{-- @include('layouts.modal.confirmation') --}}
@endsection

@section('js')

@endsection