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
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
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

                                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
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
                            </div>

                            <div class="row">
                                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
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
                    
                                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
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
                            </div>

                           <div class="row">
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('telefono', 'Telefono:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        {{-- <span class="obligatorio">*</span> --}}
                                        {!! Form::text('telefono', $empleado->telefono_empleado, [
                                            'class' => 'form-control',
                                            'id' => 'telefono'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('costo_hora', 'Costo hora:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('costo_hora', $empleado->costo_hora, [
                                            'class' => 'form-control',
                                            'required',
                                            'id' => 'costo_hora'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('esta_activo', '¿Se encuentra activo?:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('esta_activo', [1 => 'SI', 0 => 'NO'], $empleado->esta_activo, [
                                            'class' => 'form-select form-control',
                                            'required'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('sup_di', 'Supervisor directo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::select('sup_di', $supervisores, $empleado->getOrganigrama->getSupervisorDirecto->id_empleado ?? null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control'
                                        ]) !!}
                                    </div>
                                </div>
                            </div>        

                            @if ($es_supervisor)
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            {!! Form::label('not_em', 'Notificaciones email:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                            @foreach ($op_nots as $not)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value={{$not->id_em_notificacion}} id="flexCheckDefault{{$not->id_em_notificacion}}" {{in_array($not->id_em_notificacion, $per_avisos) ? 'checked' : ''}} name='notificaciones_email[]'>
                                                        <label class="form-check-label" for="flexCheckDefault{{$not->id_em_notificacion}}">
                                                        {{$not->nombre_em_notificacion}}
                                                        </label>
                                                    </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            
                    
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