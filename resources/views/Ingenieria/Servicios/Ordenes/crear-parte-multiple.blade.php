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
        <div class="row">
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
                                    
                                    <tbody id="accordion" >
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
    <script src="{{ asset('js\Ingenieria\Servicios\Partes\carga-multiple.js') }}"></script>
</section>

@endsection