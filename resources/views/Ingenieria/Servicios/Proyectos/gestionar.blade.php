@extends('layouts.app')
@section('titulo', 'Gestionar')
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
        padding: 1px 10px !important;
        height: 0px !important;
    }
    .col-4 {
        padding: 5px;
    }
    .col-12 {
        padding: 5px !important;
    }
</style>
@php
    $formato_fecha= Config::get('myconfig.formato_fecha');
    $formato_fecha_hora= Config::get('myconfig.formato_fecha_hora');
@endphp
    <section class="section">
        <div class="d-flex section-header justify-content-center">
            <div class="d-flex flex-row col-12">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 my-auto">
                    <h4 class="">Gestionar Servicio</h5>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
                </div>
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
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
    
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center my-auto">
                                    <h5 class="text-center">Proyecto</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    <button class="btn btn-primary col-9 my-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProyecto" aria-expanded="false" aria-controls="collapsecollapseProyecto">
                                        Opciones
                                    </button>
                                    <div class="collapse" id="collapseProyecto">
                                        <button type="button" class="btn btn-primary col-9" data-bs-toggle="modal" data-bs-target="#editarProyectoModal">
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-primary my-2 col-9" data-bs-toggle="modal" data-bs-target="#verActServOrdenModal" onclick="mostrarActProyectoAlt({{$proyecto->id_servicio}})">
                                            Actualizaciones
                                        </button>
                                        {{-- <button type="button" class="btn btn-primary my-2 col-9" onclick="mostrarActProyecto({{$proyecto->id_servicio}})">
                                            Actualizaciones
                                        </button> --}}
                                        {!! Form::open(['method' => 'GET', 'route' => ['proyectos.costos', $proyecto->id_servicio], 'style' => 'display:inline']) !!}
                                        {!! Form::submit('Costos actualizados', ['class' => 'btn btn-primary col-9']) !!}
                                        {!! Form::close() !!}
                                    </div>
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
                                        {!! Form::text('fecha_carga',\Carbon\Carbon::parse($proyecto->fecha_inicio)->format($formato_fecha), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_limite', "Fecha limite:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_limite', \Carbon\Carbon::parse($proyecto->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->fecha_limite)->format($formato_fecha), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
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
                            <div class="row">
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    {{-- @if($proyecto->id_activo)
                                        <div class="form-group">
                                            {!! Form::label('activo', "Codigo activo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            {!! Form::text('activo', $proyecto->getActivo->codigo_activo, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                        </div>
                                    @endif --}}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    @if($proyecto->id_activo)
                                        <div class="form-group">
                                            {!! Form::label('activo', "Activo asociado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            {!! Form::text('activo', $proyecto->getActivo->codigo_activo.' - '.$proyecto->getActivo->nombre_activo, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('costo_estimado', "Costo estimado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('costo_estimado', $proyecto->getCostoEstimadoGuardado(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('costo_real', "Costo real:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('costo_real', $proyecto->getCostoRealGuardado(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}
                
                {{-- Actualizaciones del proyecto --}}
                {{-- <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_act_proyecto' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center">
                                    <h5 class="text-center">Actualizaciones proyecto</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearActModal" onclick="cargarModalNuevaActProyecto({{$proyecto->getUltimaActualizacion()->getActualizacion}}, {{$proyecto->getResponsabilidad}})">
                                        Nueva
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="tablaAct" class="table table-hover mt-2" class="display">
                                    <thead style="background-color:#00b1b1">
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
                </div> --}}
                {{-- ------------- --}}

                {{-- Etapas del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center my-auto">
                                    <h5 class="text-center my-auto">Etapas</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearEtapaModal">
                                        Nueva etapa
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="height: 400px">
                                <table id="tablaEtapas" class="table table-hover mt-2">
                                    <thead style="background-color: #2970c1">
                                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha inicio</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha fin real</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Ultima actualizacion</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Costo estimado</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Costo real</th>
                                        <th class="text-center" scope="col" style="color:#fff; width:17vh">Acciones</th>                                                           
                                    </thead>
                                    <tbody id="accordion">
                                        @php 
                                            $idCount = 0;
                                        @endphp
                                        @foreach ($proyecto->getEtapas as $etapa)
                                            <tr>    
                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->descripcion_etapa}}</td>
                                                
                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->getEstado->nombre_estado}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->getResponsable->getEmpleado->nombre_empleado}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($etapa->fecha_inicio)->format($formato_fecha)}}</td>

                                                {{-- <td class= 'text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_limite)->format('d-m-Y')}}</td> --}}

                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->getFechaLimite()}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->getFechaFinalizacion() ? \Carbon\Carbon::parse($etapa->getFechaFinalizacion())->format('d-m-Y') : '____-__-__'}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_carga)->format($formato_fecha_hora)}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->getCostoEstimadoGuardado()}}</td>
                                                
                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->getCostoRealGuardado()}}</td>

                                                <td class='text-center' style="vertical-align: middle;">
                                                    <div class="row justify-content-center">
                                                        <div class="row justify-content-center">
                                                            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEtapa{{$idCount}}" aria-expanded="false" aria-controls="collapseEtapa{{$idCount}}">
                                                                Opciones
                                                            </button>
                                                        </div>
                                                        <div class="collapse" data-bs-parent="#accordion" id="collapseEtapa{{$idCount}}">
                                                            <div class="row ">
                                                                <div class="col-12">
                                                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarEtapaModal" onclick="cargarModalEditarEtapa({{$etapa->id_etapa}})">
                                                                        Editar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verActEtapaOrdenModal" onclick="mostrarActEtapaAlt({{$etapa->id_etapa}})">
                                                                        Actualizaciones
                                                                    </button>
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
                {{-- ------------- --}}

                {{-- Actualizaciones de la etapa --}}
                {{-- <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_act_etapa' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                                    <h5 class="text-center  my-auto">Actualizaciones etapa</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearActEtaModal">
                                        Nueva
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="tablaAct" class="table table-hover mt-2" class="display">
                                    <thead style="background-color: #5997d4">
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
                </div> --}}
                {{-- ------------- --}}

                @include('Ingenieria.Servicios.Proyectos.layout.gestionar-ordenes-v1')

                {{-- Ordenes del proyecto --}}
            
                {{-- <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                                    <h5 class="text-center  my-auto">Ordenes</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                                        Nueva orden
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="example" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Tipo orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Acciones</th>                                                           
                                    </thead>
                                    <tbody id="cuadro-ordenes">
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            {{-- ------------- --}}


                {{-- Partes del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12" id='parte_de_trabajo' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center  my-auto">
                                    <h5 class="text-center  my-auto">Partes</h5>
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
                <div class="p-1 position-fixed" style="bottom:2vh; left:0.5vh;">
                    {{-- {!! Form::open(['method' => 'GET', 'route' => 'proyectos.index', 'style' => '']) !!}
                    <button class="btn btn-primary">
                        <a class="nav-link" href="{{route('proyectos.index')}}" title="volver">
                            <i class="fas fa-arrow-left " style="margin-right:5px"></i>
                        </a>
                    </button>
                    {{-- {!! Form::submit('', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!} --}}
                </div>
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" >
                                <div class="d-flex">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="module"> 
            import {crearCuadrOrdenes, cargarModalVerOrden, obtenerPartes, cargarModalNuevaActProyecto, cargarModalEditarEtapa} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
            window.crearCuadrOrdenes = crearCuadrOrdenes;
            window.cargarModalVerOrden = cargarModalVerOrden;
            window.obtenerPartes = obtenerPartes;
            window.cargarModalNuevaActProyecto = cargarModalNuevaActProyecto;
            window.cargarModalEditarEtapa = cargarModalEditarEtapa;
        </script>

        <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}">
            
        </script>
        <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/gestionar.js') }}"></script>

        <script>
            $(document).ready(function () {
                let prefijo = '{{$prefijo}}';
                let tipo = '{{$tipo}}';
                var url = '{{route('proyecto.indexprefijo',[':prefijo',':tipo'])}}';
                url = url.replace(':prefijo', prefijo).replace(':tipo', tipo);
                // console.log(tipo);
                document.getElementById('volver').href = url;
                // document.getElementById('volver').href = '{{route('proyectos.index')}}';
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
                $('#tablaEtapas').excelTableFilter();
            });
        </script>
    </section>
    @include('Ingenieria.Servicios.Proyectos.modal.crear-etapa')
    @include('Ingenieria.Servicios.Proyectos.modal.editar-etapa')
    @include('Ingenieria.Servicios.Proyectos.modal.crear-orden')
    @include('Ingenieria.Servicios.Proyectos.modal.ver-orden')
    @include('Ingenieria.Servicios.Proyectos.modal.editar-proyecto')
    {{-- @include('Ingenieria.Servicios.Proyectos.modal.crear-act') --}}
    {{-- @include('Ingenieria.Servicios.Proyectos.modal.crear-act-eta') --}}
    @include('Ingenieria.Servicios.Proyectos.modal.ver-partes')
    @include('Ingenieria.Servicios.Ordenes.modal.editar-orden')
    @include('Ingenieria.Servicios.Proyectos.modal.ver-act-servicio')
    @include('Ingenieria.Servicios.Proyectos.modal.ver-act-etapa')
{{-- @include('layouts.modal.confirmation') --}}
@endsection

@section('js')

@endsection