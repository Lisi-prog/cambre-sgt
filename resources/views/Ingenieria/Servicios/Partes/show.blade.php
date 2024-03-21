@extends('layouts.app')
@section('titulo', 'Partes de una orden')
@section('content') 
<style>
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
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Partes de una orden</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')

                {{-- Informacion del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::label('proyecto', "Proyecto:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('prioridad', "Prioridad:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('prioridad', $orden->getEtapa->getServicio->prioridad_servicio ?? '', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('id_proyecto', "ID:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('id_proyecto', $orden->getEtapa->getServicio->codigo_servicio ?? '', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('nom_proyecto', 'Nombre proyecto:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_proyecto', $orden->getEtapa->getServicio->nombre_servicio ?? '', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('estadoo', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('estadoo', $orden->getEtapa->getServicio->getEstado() ?? '', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    {!! Form::label('etapa', "Etapa:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('desc', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('dec', $orden->getEtapa->descripcion_etapa ?? '', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('desc', "Fecha inicio:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('dec', $orden->getEtapa->fecha_inicio, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {!! Form::label('orden', "Orden:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('tipo', "Tipo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('tipo', $orden->getOrdenDe->getNombreTipoOrden() ?? '', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('nombre-orden', "Nombre:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nombre-orden', $orden->nombre_orden, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('responsable', "Responsable:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('responsable', $orden->getNombreResponsable(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('supervisor', "Supervisor:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('supervisor', $orden->getSupervisor(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="row">
                                    </div>
                                    <div class="row">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Partes de una Orden --}}
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 my-auto text-center">
                                    <h5 class="text-center">Parte de {{$orden->getOrdenDe->getNombreTipoOrden()}}</h5>
                                    <div hidden>
                                        {!! Form::text('tipo_orden', $orden->getOrdenDe->getTipoOrden(), [
                                        'id' => 'tipo_orden',
                                        'disabled',
                                        'readonly'
                                    ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearParteModal">
                                        Nuevo parte   
                                    </button>
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
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Codigo</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:25%;">Observaciones</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Fecha</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Horas</th>

                                        @if ($orden->getOrdenDe->getTipoOrden() == 3)
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">Maquina</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:5%;">Horas maquina</th>
                                        @endif
                                        
                                        {{-- <th class="text-center" scope="col" style="color:#fff;width:5%;">Acciones</th>                                                            --}}
                                    </thead>
                                    <tbody>
                                        @foreach ($orden->getPartes as $parte)
                                        <tr>
                                            <td class= 'text-center' >{{$parte->id_parte}}</td>

                                            <td class= 'text-center' >{{$parte->observaciones}}</td>

                                            <td class= 'text-center'>{{$parte->fecha}}</td>

                                            <td class= 'text-center'>{{ $parte->fecha_limite ?? '-'}}</td>

                                            
                                            <td class= 'text-center'>{{$parte->getParteDe->getNombreEstado()}}</td>
                                              

                                            {{-- <td class= 'text-center'>{{substr($parte->horas, 0, strlen($parte->horas)-3)}}</td> --}}

                                            <td class= 'text-center'>{{$parte->horas}}

                                            @if ($orden->getOrdenDe->getTipoOrden() == 3)
                                                <td class= 'text-center'>{{$parte->getParteDe->getParteMecxMaq->first()->getMaquinaria->codigo_maquinaria ?? '-'}}</td>
                                                <td class= 'text-center'>{{$parte->getParteDe->getParteMecxMaq->first()->horas_maquina ?? '-'}}</td>
                                            @endif
                                            {{-- <td>
                                                {!! Form::open(['method' => 'GET', 'route' => ['empleados.index'], 'style' => '']) !!}
                                                    {!! Form::submit('Editar', ['class' => 'btn btn-warning w-100']) !!}
                                                {!! Form::close() !!}
                                            </td> --}}
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
                                        {!! Form::open(['method' => 'GET', 'route' => ['ordenes.tipo', $tipo_orden], 'style' => '']) !!}
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
    </section>
    @include('Ingenieria.Servicios.Partes.modal.crear-parte')
    <script>
        $(document).ready(function () {
            let tipo_orden = document.getElementById('tipo_orden').value;
            var url = '{{route('ordenes.tipo',':tipo_orden')}}';
            url = url.replace(':tipo_orden', tipo_orden);
            document.getElementById('volver').href = url;
        });
    </script>
@endsection
