@extends('layouts.app')
@section('titulo', 'Partes')
@section('content')


<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 my-auto">
                <h4 class="">Carga multiple partes</h5>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
            </div>
        </div>
    </div>
    
    <div class="section-body">
        {{-- <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body" >  
                        <div class="row" >
                            <h5 class="text-center control-label pt-2" id="titulo-parte">Nuevo parte</h5>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('servicio', 'Proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('id_servicio', $servicios, null, [
                                        'placeholder' => 'Seleccionar',
                                        'class' => 'form-select',
                                        'id' => 'id_servicio'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('etapa', 'Etapa:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('id_etapa', [], null, [
                                        'placeholder' => 'Seleccionar',
                                        'class' => 'form-select',
                                        'id' => 'id_etapa'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('orden', 'Orden:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select('id_orden', [], null, [
                                        'placeholder' => 'Seleccionar',
                                        'class' => 'form-select',
                                        'id' => 'id_orden'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            {!! Form::open(['route' => 'partes.guardar.act', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits-3sec nuevo-editar-parte', 'id' => 'form-nuevo-parte']) !!}
                            {!! Form::text('id_orden', null, ['class' => 'form-control', 'hidden', 'id' => 'm-ver-parte-orden']) !!}
                            {!! Form::text('id_parte', null, ['class' => 'form-control', 'hidden', 'id' => 'm-id-parte']) !!}
                            {!! Form::text('editar', 0, ['class' => 'form-control', 'hidden', 'id' => 'm-editar']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('observaciones', 'Observaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        <textarea name='observaciones' id="observaciones" maxlength="500" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('estado', 'Estado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        <select class="form-select" id="m-ver-parte-estado" name="estado">
                                            <option selected="selected" value="">Seleccionar</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{$estado->id_estado}}">{{$estado->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('fecha_limite', 'Fecha limite:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        @role('SUPERVISOR')
                                            {!! Form::date('fecha_limite', null, [
                                                'min' => '2023-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'm-ver-parte-fecha-limite',
                                                'class' => 'form-control'
                                            ]) !!}
                                        @else
                                            {!! Form::date('fecha_limite', null, [
                                                'min' => '2023-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'm-ver-parte-fecha-limite',
                                                'class' => 'form-control',
                                                'readonly'
                                            ]) !!}
                                        @endrole
                                    </div>
                                </div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('fecha', 'Fecha:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                                    <span class="obligatorio">*</span>
                                        {!! Form::date('fecha', \Carbon\Carbon::now(), [
                                            'min' => '2023-01-01',
                                            'max' => \Carbon\Carbon::now()->year . '-12',
                                            'id' => 'fecha',
                                            'class' => 'form-control',
                                            'required'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group"> 
                                        <label for="horas" class="control-label" style="white-space: nowrap; ">Horas hombre:</label> 
                                        <span class="obligatorio">*</span> 
                                        <div class= "input-group">
                                            <input class="form-control" name="horas" type="number" min="0" value="00" id="horas" required>
                                            <span class="input-group-text">:</span>
                                            <input class="form-control" name="minutos" type="number" min="0" max="59" value="00" id="minutos" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="m-ver-parte-maquinaria">
        
                            </div>
                        
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                <button id="btn_agregar" type="button" class="btn btn-success" disabled onclick="agregarRenglon()">Agregar</button>
                                <button type="button" class="btn btn-danger">Limpiar</button>
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
                            <button type="button" class="btn btn-primary-outline m-1 rounded" onclick="mostrarFiltro('demo')">Filtros <i class="fas fa-caret-down"></i></button> 
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
                                                <label>Supervisor:</label>
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
                                                    <label>Responsable:</label>
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
                                                <label>Estados:</label>
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
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Centramos la paginacion a la derecha -->
                        {{-- @if (count($ordenes) != 0)
                            <div class="pagination justify-content-end">
                                {!! $ordenes->links() !!}
                            </div>
                        @endif --}}
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead id="encabezado_ordenes">
                                    <th class='text-center' style="color:#fff;min-width:5vw">Prioridad</th>
                                    <th class='text-center' style="color:#fff; width:13vw">Proyecto</th>
                                    <th class='text-center' style="color:#fff;" hidden>Proyecto</th>
                                    <th class='text-center' style="color:#fff;min-width:14vw">Orden</th>
                                    <th class='text-center' style="color:#fff;min-width:12vw">Etapa</th>
                                    <th class='text-center' style="color:#fff;min-width:4vw">Estado</th>
                                    <th class='text-center' style="color:#fff;min-width:6vw">Supervisor</th>
                                    <th class='text-center' style="color:#fff;min-width:6vw">Responsable</th>
                                    <th class='text-center' style="color:#fff;">Horas</th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Fecha limite</th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Fecha finalizacion</th>
                                    <th class='text-center' style="color: #fff; width:10%">Acciones</th>
                                </thead>
                                
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($ordenes as $orden)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->prioridad_servicio ?? '-'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->nombre_servicio ?? '-'}}" style="text-decoration:none; font-variant: none;">{{$orden->codigo_servicio ?? '-'}} <i class="fas fa-eye"></i></abbr></td>
                                            
                                            <td class='text-center' style="vertical-align: middle;" hidden>{{$orden->codigo_servicio ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_orden ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;"><abbr title='{{$orden->descripcion_etapa}}' style="text-decoration:none; font-variant: none;">{{substr($orden->descripcion_etapa, 0, 20)}} <i class="fas fa-eye"></abbr></td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_estado ?? ''}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->supervisor ?? '-'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->responsable ?? '-'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->total_horas ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->fecha_limite ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->fecha_finalizacion}}</td>
        
                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row justify-content-center" >
                                                    <button type="button" class="btn btn-warning w-50" data-bs-toggle="modal" data-bs-target="#crearParteMultipleModal" onclick="">
                                                        Agregar
                                                    </button>
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

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body" >
                        <div class="row">
                            {{-- <div class="table-responsive"> --}}
                                <table class="table table-striped mt-2" id="partemult">
                                    <thead id="encabezado_ordenes">
                                        <th class='text-center' style="color:#fff; width:13vw">Proyecto</th>
                                        <th class='text-center' style="color:#fff;min-width:12vw">Etapa</th>
                                        <th class='text-center' style="color:#fff;min-width:14vw">Orden</th>
                                        
                                        <th class='text-center' style="color:#fff;min-width:6vw">Observaciones</th>
                                        <th class='text-center' style="color:#fff;min-width:4vw">Estado</th>
                                        <th class='text-center' style="color:#fff;min-width:6vw">Fecha limite</th>
                                        <th class='text-center' style="color:#fff;min-width:5vw">Fecha</th>
                                        <th class='text-center' style="color:#fff;">Horas</th>
                                        <th class='text-center' style="color: #fff; width:10%">Acciones</th>
                                    </thead>
                                    
                                    <tbody id="accordionParte" >
                                        {{-- <tr>
                                            <td class='text-center' style="vertical-align: middle;"></td>
                                            <td class='text-center' style="vertical-align: middle;"></td>
                                            <td class='text-center' style="vertical-align: middle;"></td>
                                            <td class='text-center' style="vertical-align: middle;"></td>
                                            <td class='text-center' style="vertical-align: middle;"></td>
                                            <td class='text-center' style="vertical-align: middle;"></td>
                                            <td class='text-center' style="vertical-align: middle;"></td>
                                            <td class='text-center' style="vertical-align: middle;"></td>
                                            <td class='text-center' style="vertical-align: middle;"></td>
                                        </tr> --}}
                                        {{-- @php
                                            $idCount = 0;
                                        @endphp
                                        @foreach ($ordenes as $orden)
                                            <tr>
                                                <td class='text-center' style="vertical-align: middle;">{{$orden->prioridad_servicio ?? '-'}}</td>
                                                
                                                <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->nombre_servicio ?? '-'}}" style="text-decoration:none; font-variant: none;">{{$orden->codigo_servicio ?? '-'}} <i class="fas fa-eye"></i></abbr></td>
                                                
                                                <td class='text-center' style="vertical-align: middle;" hidden>{{$orden->codigo_servicio ?? '-'}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_orden ?? '-'}}</td>

                                                <td class='text-center' style="vertical-align: middle;"><abbr title='{{$orden->descripcion_etapa}}' style="text-decoration:none; font-variant: none;">{{substr($orden->descripcion_etapa, 0, 20)}} <i class="fas fa-eye"></abbr></td>
                                                
                                                <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_estado ?? ''}}</td>
                                                
                                                <td class='text-center' style="vertical-align: middle;">{{$orden->supervisor ?? '-'}}</td>
                                                
                                                <td class='text-center' style="vertical-align: middle;">{{$orden->responsable ?? '-'}}</td>
                                                
                                                <td class='text-center' style="vertical-align: middle;">{{$orden->total_horas ?? '-'}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$orden->fecha_limite ?? '-'}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$orden->fecha_finalizacion}}</td>

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
                                        @endforeach  --}}
                                    </tbody>
                                </table>
                            {{-- </div>                        --}}
                        </div>
                        <div class="row">
                            <div class="row justify-content-center">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                    <button type="button" class="btn btn-success">Guardar</button>
                                    <button type="button" class="btn btn-danger">Cancelar</button>
                                </div>
                            </div> 
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
    <script src="{{ asset('js\Ingenieria\Servicios\Partes\carga-multiple.js') }}"></script>
    <script src="{{ asset('js/change-td-color.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/filter.js') }}"></script>
</section>
@include('Ingenieria.Servicios.Ordenes.modal.agregar-parte')
<script>
    let x = '';
    let ind_rw = '';
    let id_emp = {{Auth::user()->getEmpleado->id_empleado}};
    let es_super = {{$es_sup}};
    var table;
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
        // modificarFormularioConArgumentos(tipo_orden, 'formulario-editar-orden', true);
        // document.getElementById('encabezado_ordenes').style.backgroundColor = colorEncabezadoPorTipoDeOrden(tipo_orden);
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
                "aaSorting": [],
                "pageLength": 10
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

    $("#form-agregar-parte").on('submit', function(evt){
    evt.preventDefault();    
    agregarRenglon();
    console.log('holaaaaa')
    const miBoton = document.getElementById('btn-cerrar-md');
    miBoton.click();
    

    /* var url_php = $(this).attr("action"); 
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
    */
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