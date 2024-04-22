@extends('layouts.app')

@section('titulo', 'Editar empleado')

@section('content')

    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Editar técnico</div>
        </div>
        <div class="section-body">
            <div class="row">
                {!! Form::model($empleado,['method' => 'PUT', 'route' => ['tecnicos.update', $empleado->id_empleado], 'class' => 'd-flex justify-content-start']) !!}
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('nom_comp', 'Nombre completo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('nombre_completo', $empleado->nombre_empleado, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'id' => 'nom_comp'
                                        ]) !!}
                                    </div>
                                </div>

                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div> --}}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('puesto', 'Puesto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('puesto', $puestos, $empleado->id_puesto_empleado, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'puesto',
                                            'required'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    {{-- <div class="form-group">
                                        {!! Form::label('user_wb', '¿Crear usuario web?', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('user_wb', [0 => 'NO', 1 => 'SI'], 1, [
                                            'class' => 'form-select form-control',
                                            'id' => 'user_wb',
                                            'required'
                                        ]) !!}
                                    </div> --}}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('email', 'Email:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::email('email', $empleado->email_empleado, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'id' => 'email'
                                        ]) !!}
                                    </div>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div> --}}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('sector', 'Sector:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('sector', $sectores, $empleado->id_sector, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'sector',
                                            'required'
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    {{-- <div class="form-group">
                                        {!! Form::label('pass', 'Contraseña:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        <input id='pass-input' type="password" class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" placeholder="Ingrese la contraseña" name="password" tabindex="2" required>
                                    </div> --}}
                                </div>
                            </div>

                           <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('telefono', 'Telefono:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        {{-- <span class="obligatorio">*</span> --}}
                                        {!! Form::text('telefono', $empleado->telefono_empleado, [
                                            'class' => 'form-control',
                                            'id' => 'telefono'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('costo_hora', 'Costo hora:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('costo_hora', $empleado->costo_hora, [
                                            'class' => 'form-control',
                                            'id' => 'costo_hora'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('esta_activo', '¿Se encuentra activo?:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('esta_activo', [1 => 'SI', 0 => 'NO'], $empleado->esta_activo, [
                                            'class' => 'form-select form-control',
                                            'required'
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    
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
                                        {!! Form::open(['method' => 'GET', 'route' => 'tecnicos.index', 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-danger']) !!}
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
    {{-- <script src="{{ asset('js/Informatica/Empleados/crear-empleado.js') }}"></script> --}}
    <script>
        $(document).ready(function () {
            var url = '{{route('tecnicos.index')}}';
            //url = url.replace(':id_servicio', id_servicio);
            document.getElementById('volver').href = url;
        });
    </script>
@endsection