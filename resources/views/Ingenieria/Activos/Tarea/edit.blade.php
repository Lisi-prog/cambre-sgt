@extends('layouts.app')

@section('titulo', 'Editar Causa - Diagrama de Ishikawa')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar Causa - Diagrama de Ishikawa</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {!! Form::model($tarea, ['method' => 'PUT', 'route' => ['tarea_mantenimiento.update', $tarea->id_tarea_mantenimiento], 'class' => '']   ) !!}
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                {!! Form::label('nombre_tarea', 'Nombre tarea:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('nombre_tarea', null, [
                                        'class' => 'form-control reset-input',
                                        'required' => 'required',
                                        'id' => 'nombre_tarea'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('id_zona_tarea', 'Zona de tarea:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select('id_zona_tarea', $zonas->pluck('nombre_zona', 'id_zona_tarea'), null, [
                                        'class' => 'form-control reset-input',
                                        'placeholder' => 'Seleccione una zona',
                                        'required' => 'required',
                                        'id' => 'id_zona_tarea'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between">
                                <div class="form-group" style="width: 90%;">
                                    {!! Form::label('id_ejecucion', 'Ejecución de tarea:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select('id_ejecucion', $ejecuciones->pluck('nombre_ejecucion', 'id_ejecucion'), null, [
                                        'class' => 'form-control reset-input',
                                        'placeholder' => 'Seleccione una ejecución',
                                        'required' => 'required',
                                        'id' => 'id_ejecucion'
                                    ]) !!}
                                    {!! Form::text('ejecucion_nueva', null, [
                                        'class' => 'form-control reset-input mt-2',
                                        'placeholder' => 'Nueva ejecución',
                                        'id' => 'ejecucion_nueva',
                                        'style' => 'display:none;'])
                                    !!}
                                </div>
                                <div class="form-group" style="width: 10%;">
                                    <button type="button" class="btn btn-success mt-4" onclick="mostrarInputEjecucion()">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="d-flex">
                                <div class="me-auto">
                                    (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                </div>
                                <div class="p-1">
                                    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                    {!! Form::close() !!}
                                </div>
                                <div class="p-1">
                                    {!! Form::open(['method' => 'GET', 'route' => 'tarea_mantenimiento.index', 'style' => '']) !!}
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
<script>
    $(document).ready(function () {
        var url = '{{route('tarea_mantenimiento.index')}}';
        document.getElementById('volver').href = url;
    });

    function mostrarInputEjecucion() {
        var selectEjecucion = document.getElementById('id_ejecucion');
        var inputEjecucionNueva = document.getElementById('ejecucion_nueva');

        if (inputEjecucionNueva.style.display === 'none') {
            inputEjecucionNueva.style.display = 'block';
            selectEjecucion.disabled = true;
            selectEjecucion.value = '';
            inputEjecucionNueva.setAttribute('required', 'required');
        } else {
            inputEjecucionNueva.style.display = 'none';
            selectEjecucion.disabled = false;
            inputEjecucionNueva.removeAttribute('required');
        }
    }
</script>
@endsection