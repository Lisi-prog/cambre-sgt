@extends('layouts.app')
@section('titulo', 'Gestionar')
@section('content')
<style>
    .tableFixHead {
        overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
        min-height: 200px; /* gives an initial height of 200px to the table */
        max-height: 400px;
    }
    .tableFixHead thead th {
        position: sticky; /* make the table heads sticky */
        top: 0px; /* table head will be placed from the top of the table and sticks to it */
        z-index:2;
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
        background: #2970c1;
    }

    #cot th {
        background: #558540;
    }

    #comac th {
        background: #982b37;
    }

    #comec th {
        background: #d37c00;
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
                                        {!! Form::text('fecha_limite', $proyecto->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->fecha_limite ? \Carbon\Carbon::parse($proyecto->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->fecha_limite)->format($formato_fecha) : '-', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
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
                                        {!! Form::text('prioridad', $proyecto->prioridad_servicio ?? 'S/P', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
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
                                        {{-- {!! Form::label('costo_estimado', "Costo estimado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('costo_estimado', $costo_estimado, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!} --}}
                                        {!! Form::label('horas_estimada', "Horas estimadas:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('horas_estimada', $horas_estimada ?? '-', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {{-- {!! Form::label('costo_real', "Costo real:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('costo_real', $costo_real, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!} --}}
                                        {!! Form::label('horas_real', "Horas real:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('horas_real', $horas_real ?? '-', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
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
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-center my-auto">
                                    <h5 class="text-center my-auto" onclick="mostrarFiltro('flt_etapa')" style="cursor: pointer;">Etapas <i class="fas fa-filter"></i></h5>
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-2">
                                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearEtapaModal">
                                        Nueva etapa
                                    </button>
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
                                                    <label>Etapa:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('cod_serv', this)">
                                                </div>
                                                <div class="d-flex flex-column overflow-auto">
                                                    <label style="font-style: italic"><input class="eta-ckb" name="filter" type="checkbox" value="cod_serv" checked> (Seleccionar todo)</label>
                                                    @foreach ($proyecto->getEtapas->sortBy('descripcion_etapa') as $etapa)
                                                        <label><input class="eta-ckb" name="cod_serv" type="checkbox" value="{{$etapa->descripcion_etapa}}" checked> {{$etapa->descripcion_etapa}}</label>
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
                                                    <label>Estados:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('est', this)">
                                                </div>
                                                <div class="d-flex flex-column overflow-auto">
                                                    <label style="font-style: italic"><input class="eta-ckb" name="filter" type="checkbox" value="est" checked> (Seleccionar todo)</label>
                                                    @foreach ($flt_estados as $estado)
                                                        @if ($estado->id_estado < 9)
                                                            <label><input class="eta-ckb" name="est" type="checkbox" value="{{$estado->nombre_estado}}" checked> {{$estado->nombre_estado}}</label>
                                                        @else
                                                            <label><input class="eta-ckb" name="est" type="checkbox" value="{{$estado->nombre_estado}}"> {{$estado->nombre_estado}}</label>
                                                        @endif
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
                                                    <label>Responsable:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('res', this)">
                                                </div>
                                                <div class="d-flex flex-column overflow-auto">
                                                    <label style="font-style: italic"><input class="eta-ckb" name="filter" type="checkbox" value="res" checked> (Seleccionar todo)</label>
                                                    @foreach ($filtros['responsables_etapa'] as $responsable)
                                                        <label><input class="eta-ckb" name="res" type="checkbox" value="{{$responsable}}" checked> {{$responsable}}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- <div class="row">
                                    <button type="button" class="btn btn-primary-outline rounded" onclick="limpiarFiltro()">Limpiar</i></button> 
                                </div> --}}
                            </div>   
                        </div>
                        <div class="card-body">
                            {{-- <div class="table-responsive tableFixHead"> --}}
                                <table id="tablaEtapas" class="table table-hover mt-2">
                                    <thead style="background-color: #2970c1" id="viv">
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:10vw">Etapa</th>
                                        <th class="text-center apply-filter" scope="col" style="color:#fff;">Estado</th>
                                        <th class="text-center apply-filter" scope="col" style="color:#fff;">Responsable</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:5vw">Fecha inicio</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:5vw">Fecha limite</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:5vw">Fecha finalizacion</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;">Ultima actualizacion</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;">Horas estimadas</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;">Horas reales</th>
                                        <th class="text-center" scope="col" style="color:#fff; min-width:6vw">Acciones</th>                                                           
                                    </thead>
                                    <tbody id="accordion">
                                        @php 
                                            $idCount = 0;
                                        @endphp
                                        @foreach ($etapas as $etapa)
                                            
                                            @if ($etapa->id_estado < 9)
                                                <tr>
                                            @else
                                                <tr style="display: none;">
                                            @endif     
                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->descripcion_etapa}}</td>
                                                
                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->nombre_estado}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->responsable}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->fecha_inicio}}</td>

                                                {{-- <td class= 'text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_limite)->format('d-m-Y')}}</td> --}}

                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->fecha_limite}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->fecha_finalizacion}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->fecha_ult_act}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->horas_estimada}}</td>
                                                
                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->horas_real}}</td>

                                                <td class='text-center' style="vertical-align: middle;">
                                                    <div class="row justify-content-center">
                                                        <div class="row justify-content-center">
                                                            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEtapa{{$idCount}}" aria-expanded="false" aria-controls="collapseEtapa{{$idCount}}">
                                                                Opciones <i class="fas fa-filter" hidden></i>
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
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <button type="button" class="btn btn-info w-100" name="flt-for-eta" value="{{$etapa->descripcion_etapa}}">
                                                                        Filtro
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
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                @include('Ingenieria.Servicios.Proyectos.layout.gestionar-ordenes-v1')

                
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
                <div class="p-1 position-fixed" style="bottom:2vh; left:0.5vh;" hidden>
                    {{-- {!! Form::open(['method' => 'GET', 'route' => 'proyectos.index', 'style' => '']) !!}
                    <button class="btn btn-primary">
                        <a class="nav-link" href="{{route('proyectos.index')}}" title="volver">
                            <i class="fas fa-arrow-left " style="margin-right:5px"></i>
                        </a>
                    </button>
                    {{-- {!! Form::submit('', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!} --}}
                </div>
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12" hidden> 
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
        
        <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js')) }}"></script>

        {{-- <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script> --}}

        <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/gestionar.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Proyectos/modal/gestionar.js')) }}"></script>
        {{-- <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/gestionar.js') }}"></script> --}}
        <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/FilterGestionar.js') }}"></script>

        <script>
            // let oord = Array();
            let ind_rw = '';
            let opt_act = 0;
            $(document).ready(function () {
                let opcion = '{{$opcion}}';
                
                var url = '{{route('proyecto.indexprefijo', ':opcion')}}';
                url = url.replace(':opcion', opcion);
                document.getElementById('volver').href = url;
                document.getElementById('ayudin').hidden = false;
                let nombreArchivo = 'gestionar';
                

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
                // document.getElementById('volver').href = '{{route('proyectos.index')}}';
               $('#tablaEtapas').DataTable({
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '400px',
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
                        order: [[4, 'asc']],
                });

                var tableOrdTra = $('#tablaOrdenTrabajo').DataTable({
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '400px',
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

                tableOrdTra.on('draw',function () {
                    changeTdColor();
                } )

                $('#tablaOrdenMan').DataTable({
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '400px',
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

                $('#tablaOrdenMec').DataTable({
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '400px',
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

                $('#tablaOrdenTrabajo tbody').on('click', 'tr', function () {
                        ind_rw = tableOrdTra.row(this).index();
                        opt_act = 1;
                });

                $('#verPartesModal').on('hidden.bs.modal', function (e) {
                    switch (opt_act) {
                        case 1:
                            actRowOrdTra(tableOrdTra);
                            break;
                    
                        default:
                            break;
                    }
                })

                $('#editarOrdenModal').on('hidden.bs.modal', function (e) {
                    switch (opt_act) {
                        case 1:
                            actRowOrdTra(tableOrdTra);
                            break;
                    
                        default:
                            break;
                    }
                })
                
                $('#verActEtapaOrdenModal').on('hidden.bs.modal', function (e) {
                    // console.log('holi');
                    document.getElementById('m-ver-act-eta-descripcion').value = '';
                    document.getElementById('m-ver-act-eta-div').hidden = true;
                });

                $('#crearEtapaModal').on('hidden.bs.modal', function (e) {
                    // console.log('holi');
                    document.getElementById('m-crear-eta-idestado').value = 2;
                });
            });

            function actRowOrdTra(LaTabla){
                let id_orden = document.getElementById('m-ver-parte-orden').value 
                                ? document.getElementById('m-ver-parte-orden').value 
                                : document.getElementById('id_orden_edit').value;
                $.when($.ajax({
                    type: "post",
                    url: '/orden/obtener-orden-tra/'+id_orden,
                    data: {
                    },
                    success: function (response) { 
                        // console.log(response)
                        LaTabla.cell(ind_rw, 0).data(response.nombre_orden).draw(false);
                        LaTabla.cell(ind_rw, 2).data(response.nombre_estado).draw(false);
                        LaTabla.cell(ind_rw, 3).data(response.supervisor).draw(false);
                        LaTabla.cell(ind_rw, 4).data(response.responsable).draw(false);
                        LaTabla.cell(ind_rw, 5).data(response.fecha_limite).draw(false);
                        LaTabla.cell(ind_rw, 6).data(response.fecha_finalizacion).draw(false);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                }));
            }
        </script>

        <script>
            document.querySelectorAll('input[name=filter]').forEach(item => {
                item.addEventListener('change', event => {
                    if (item.checked) {
                        //console.log("Checkbox is checked..");
                        selects($(item).val());
                    } else {
                        //console.log("Checkbox is not checked..");
                        deSelect($(item).val());
                    }
                    // validarFiltro();
                })
            });

            document.querySelectorAll('button[name=flt-for-eta]').forEach(item => {
                item.addEventListener('click', event => {
                    filtrarAllOrdenes(item);
                })
            });

            function filtrarAllOrdenes(b){
                let flt_ord = document.getElementsByClassName("flt_x_eta");
                
                deSelect('ot_etapa');
                deSelect('om_etapa');
                deSelect('ome_etapa');

                
                for (let i = 0; i < flt_ord.length; i++) {
                    if (String(flt_ord[i].value) == String(b.value)) {
                        flt_ord[i].checked = true;
                    }
                }
                buscarYfiltrarOrdTrabajo('tablaOrdenTrabajo');
                buscarYfiltrarOrdMan('tablaOrdenMan');
                buscarYfiltrarOrdMec('tablaOrdenMec');
            
                /*console.log("dawdaw");
                selects('ot_etapa');
                selects('om_etapa');
                selects('ome_etapa');
                buscarYfiltrarOrdTrabajo('tablaOrdenTrabajo');
                buscarYfiltrarOrdMan('tablaOrdenMan');
                buscarYfiltrarOrdMec('tablaOrdenMec'); */
                
            }

            function selects(name){  
                var ele=document.getElementsByName(name);  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].type=='checkbox')  
                        ele[i].checked=true;  
                }  
            }  

            function deSelect(name){  
                var ele=document.getElementsByName(name);  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].type=='checkbox')  
                        ele[i].checked=false;  
                        
                }  
            } 

            function mostrarFiltro(a){
                let cuadro_filtro = document.getElementById(a);
                if ($('#'+a).is(":hidden")) {
                    cuadro_filtro.hidden = false;
                }else{
                    cuadro_filtro.hidden = true;
                }
            }
        </script>
        <script src="{{ asset('js/change-td-color.js') }}"></script>
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