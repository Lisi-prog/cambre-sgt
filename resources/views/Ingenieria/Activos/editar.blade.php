@extends('layouts.app')

@section('titulo', 'Editar activo')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar activo #{{$activo->id_activo}}</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {!! Form::model($activo, ['method' => 'PUT', 'route' => ['activos.update', $activo->id_activo], 'class' => '']) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('codigo_activo', 'Codigo activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('codigo_activo', $activo->codigo_activo, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'style' => 'text-transform:uppercase',
                                        'id' => 'codigo_activo'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                <div class="form-group">
                                    {!! Form::label('nombre_activo', 'Nombre activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('nombre_activo', $activo->nombre_activo, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'id' => 'nombre_activo'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <div class="form-group">
                                    {!! Form::label('descripcion', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <textarea name='descripcion' id="descripcion" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$activo->descripcion_activo}}</textarea>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            {!! Form::label('tipo_activo', "Tipo Activo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            {!! Form::select('tipo_activo', $tipos_activo, $activo->id_tipo_activo ?? null, [
                                                    'class' => 'form-select form-control',
                                                    'id' => 'tip_act',
                                                    'placeholder' => 'Seleccionar'
                                                ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            {!! Form::label('est_act', "¿Esta Activo?:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            {!! Form::select('esta_activo', [0 => 'NO', 1 => 'SI'], $activo->esta_activo, [
                                                            'class' => 'form-select form-control',
                                                            'id' => 'est_act',
                                                            'required'
                                                        ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- {{$activo->getServicioActivo()}} --}}
                        @if (!$activo->getServicioActivo())
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('opciones', "Opciones:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=1 id="checkCheckedOpt" name="opt_nsa">
                                            <label class="form-check-label" for="checkCheckedOpt">
                                                Crear Servicio de Activo
                                            </label>
                                        </div>
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
                                    {!! Form::open(['method' => 'GET', 'route' => 'activos.index', 'style' => '']) !!}
                                    {!! Form::submit('Cancelar', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                              
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h5>Síntomas</h5>      
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarSintomasModal">
                                Agregar
                            </button>                     
                        </div>
                        <div>
                            <table id="tabla_sintomas" class="table table-striped">
                                <thead>
                                    <th class='text-center' style="color:#fff;">Síntoma</th>
                                    <th class='text-center' style="color:#fff;">Tipo de Sintoma</th>
                                    <th class='text-center' style="color:#fff;">Eliminar</th>
                                </thead>
                                <tbody>
                                    @foreach ($activo->getSintomas as $sintoma)
                                        <tr>
                                            <td>{{$sintoma->getSintoma->nombre_sintoma}}</td>
                                            <td>{{$sintoma->getSintoma->getTipoSintoma->nombre_tipo_sintoma}}</td>
                                            <td class="text-center">
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['activo.destroy_sintoma', [$sintoma->id_sintoma, $activo->id_activo]],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach 
                                    @foreach ($activo->getTipoActivo->getSintomas as $sintoma)
                                        <tr>
                                            <td>{{$sintoma->getSintoma->nombre_sintoma}}</td>
                                            <td>{{$sintoma->getSintoma->getTipoSintoma->nombre_tipo_sintoma}}</td>
                                            <td class="text-center">
                                                Este síntoma pertenece al tipo de activo.
                                            </td>
                                        </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>                        
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="d-flex flex-column">                      
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h5>Tareas de Mantenimiento Correctivas (INSPECCIÓN)</h5>      
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarTareasMantenimientoModal">
                                    Agregar
                                </button>                     
                            </div>
                            <div>
                                <table id="tabla_tareas_mantenimiento" class="table table-striped">
                                    <thead>
                                        <th class='text-center' style="color:#fff;">Tarea</th>
                                        <th class='text-center' style="color:#fff;">Ejecución</th>
                                        <th class='text-center' style="color:#fff;">Zona</th>
                                        <th class='text-center' style="color:#fff;">Eliminar</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($activo->getTareasMantenimiento as $tarea)
                                            <tr>
                                                <td>{{$tarea->getTareaMantenimiento->nombre_tarea}}</td>
                                                <td>{{$tarea->getTareaMantenimiento->getEjecucion->nombre_ejecucion}}</td>
                                                <td>{{$tarea->getTareaMantenimiento->getZonaTarea->nombre_zona}}</td>
                                                <td class="text-center">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['activo.destroy_tarea_mantenimiento', [$tarea->id_tarea_mantenimiento, $activo->id_activo]],
                                                        'style' => 'display:inline'
                                                    ]) !!}
                                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach 
                                        @foreach ($activo->getTipoActivo->getTareasMantenimiento as $tarea)
                                            <tr>
                                                <td>{{$tarea->getTareaMantenimiento->nombre_tarea}}</td>
                                                <td>{{$tarea->getTareaMantenimiento->getEjecucion->nombre_ejecucion}}</td>
                                                <td>{{$tarea->getTareaMantenimiento->getZonaTarea->nombre_zona}}</td>
                                                <td class="text-center">
                                                    Esta tarea pertenece al tipo de activo.
                                                </td>
                                            </tr>
                                        @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h5>Tareas de Mantenimiento Preventivas</h5>      
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarTareasMantenimientoPreventivaModal">
                                    Agregar
                                </button>                     
                            </div>
                            <div>
                                <table id="tabla_tareas_mantenimiento_preventivas" class="table table-striped">
                                    <thead>
                                        <th class='text-center' style="color:#fff;">Tarea</th>
                                        <th class='text-center' style="color:#fff;">Ejecución</th>
                                        <th class='text-center' style="color:#fff;">Zona</th>
                                        <th class='text-center' style="color:#fff;">Intervalo</th>
                                        <th class='text-center' style="color:#fff;">Cantidad de Golpes</th>
                                        <th class='text-center' style="color:#fff;">Última Ejecución</th>
                                        <th class='text-center' style="color:#fff;">Eliminar</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($activo->getTareasMantenimientoPreventiva as $tarea)
                                            <tr>
                                                <td>{{$tarea->getTareaMantenimiento->nombre_tarea}}</td>
                                                <td>{{$tarea->getTareaMantenimiento->getEjecucion->nombre_ejecucion}}</td>
                                                <td>{{$tarea->getTareaMantenimiento->getZonaTarea->nombre_zona}}</td>
                                                <td class="text-center">
                                                    {{$tarea->intervalo_dias}}
                                                </td>
                                                <td class="text-center">
                                                    {{$tarea->cant_golpes}}
                                                </td>
                                                <td class="text-center">
                                                    {{$tarea->fecha_ultima_ejecucion}}
                                                </td>
                                                <td class="text-center">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['activo.destroy_tarea_mantenimiento_preventiva', [$tarea->id_tarea_mantenimiento, $activo->id_activo]],
                                                        'style' => 'display:inline'
                                                    ]) !!}
                                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach 
                                        @foreach ($activo->getTipoActivo->getTareasMantenimientoPreventiva as $tarea)
                                            <tr>
                                                <td>{{$tarea->getTareaMantenimiento->nombre_tarea}}</td>
                                                <td>{{$tarea->getTareaMantenimiento->getEjecucion->nombre_ejecucion}}</td>
                                                <td>{{$tarea->getTareaMantenimiento->getZonaTarea->nombre_zona}}</td>
                                                <td class="text-center">
                                                    {{$tarea->intervalo_dias}}
                                                </td>
                                                <td class="text-center">
                                                    {{$tarea->cant_golpes}}
                                                </td>
                                                <td class="text-center">
                                                    {{$tarea->fecha_ultima_ejecucion}}
                                                </td>
                                                <td class="text-center">
                                                    Esta tarea pertenece al tipo de activo.
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
        </div>
    </div>
</section>
@include('Ingenieria.Activos.modal.editar-sintomas-activo')
@include('Ingenieria.Activos.modal.editar-tareas-mantenimiento-activo')
@include('Ingenieria.Activos.modal.editar-tareas-mantenimiento-prev-activo')
<script>
    $(document).ready(function () {
        var url = '{{route('activos.index')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;

         $('#tabla_sintomas').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar:',
                    paginate:{
                        first:"Prim.",
                        last: "Ult.",
                        previous: 'Ant.',
                        next: 'Sig.',
                    },
                },
                "aaSorting": []
        });
        $('#tabla_set_sintomas').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar:',
                    paginate:{
                        first:"Prim.",
                        last: "Ult.",
                        previous: 'Ant.',
                        next: 'Sig.',
                    },
                },
                "aaSorting": []
        });
        $('#tabla_tareas_mantenimiento').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar:',
                    paginate:{
                        first:"Prim.",
                        last: "Ult.",
                        previous: 'Ant.',
                        next: 'Sig.',
                    },
                },
                "aaSorting": []
        });
        $('#tabla_tareas_mantenimiento_preventivas').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar:',
                    paginate:{
                        first:"Prim.",
                        last: "Ult.",
                        previous: 'Ant.',
                        next: 'Sig.',
                    },
                },
                "aaSorting": []
        });
        $('#tabla_set_tareas_mantenimiento').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar:',
                    paginate:{
                        first:"Prim.",
                        last: "Ult.",
                        previous: 'Ant.',
                        next: 'Sig.',
                    },
                },
                "aaSorting": []
        });
        $('#tabla_set_tareas_mantenimiento_preventivas').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar:',
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

    $(document).on('change', '.check-tarea', function () {
        let id = $(this).data('id');
        let checked = $(this).is(':checked');

        let inputs = $('.input-tarea[data-id="' + id + '"]');

        if (checked) {
            inputs.prop('disabled', false);
            inputs.prop('required', true);
        } else {
            inputs.prop('disabled', true);
            inputs.prop('required', false);
            inputs.val(''); // optional: clear values
        }
    });
</script>
@endsection