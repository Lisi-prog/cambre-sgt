@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Nuevo proyecto</div>
        </div>
        <div class="section-body">
            <div class="row">
                {!! Form::open(['route' => 'proyectos.store', 'method' => 'POST', 'class' => 'formulario']) !!}
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('codigo_proyecto', 'Codigo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('codigo_proyecto', null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'id' => 'codigo_proyecto'
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                    <div class="form-group">
                                        {!! Form::label('nombre_proyecto', 'Nombre proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('nombre_proyecto', null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'id' => 'nombre_proyecto'
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('id_tipo_proyecto', 'Tipo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('id_tipo_proyecto', $Tipos_servicios, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'id_tipo_proyecto',
                                            'required'
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2" id="fecha_req">
                                    {{-- <div class="form-group">
                                        {!! Form::label('fec_req', 'Fecha requerida:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::date('fecha_req', \Carbon\Carbon::now(), [
                                            'min' => '2023-01-01',
                                            'max' => \Carbon\Carbon::now()->year . '-12',
                                            'id' => 'fec_req',
                                            'class' => 'form-control'
                                        ]) !!}
                                    </div> --}}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('lider', 'Lider:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('lider', $empleados, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'lider',
                                            'required'
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_ini', 'Fecha inicio:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::date('fecha_ini', \Carbon\Carbon::now(), [
                                            'min' => '2023-01-01',
                                            'max' => \Carbon\Carbon::now()->year . '-12',
                                            'id' => 'fec_ini',
                                            'class' => 'form-control'
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_req', 'Fecha requerida:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::date('fecha_req', \Carbon\Carbon::now(), [
                                            'min' => '2023-01-01',
                                            'max' => \Carbon\Carbon::now()->year . '-12',
                                            'id' => 'fec_req',
                                            'class' => 'form-control'
                                        ]) !!}
                                    </div>
                                </div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('prioridad', 'Prioridad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('prioridad', $prioridades, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'prioridad',
                                            'required'
                                        ]) !!}
                                    </div>
                                </div>
                            </div>

                           

                            
                            
                            
                    
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        {{-- @can('CREAR-OBRAVIVIENDA') --}}
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        {{-- @endcan --}}
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => 'r_i.index', 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-primary']) !!}
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
    {{-- <script src="{{ asset('js/Ingenieria/Solicitud/crear-rssi-no-au.js') }}"></script> --}}
@endsection