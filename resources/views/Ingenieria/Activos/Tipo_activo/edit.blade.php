@extends('layouts.app')

@section('titulo', 'Editar Tipo Activo')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar Tipo Activo #{{$ta->id_tipo_activo}}</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                <div class="card">
                    {!! Form::model($ta, ['method' => 'PUT', 'route' => ['tipo_activo.update', $ta->id_tipo_activo], 'class' => '']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('tipo_activo', 'Tipo Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('tipo_activo', $ta->nombre_tipo_activo, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'id' => 'tipo_activo'
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
                                    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                    {!! Form::close() !!}
                                </div>
                                <div class="p-1">
                                    {!! Form::open(['method' => 'GET', 'route' => 'tipo_activo.index', 'style' => '']) !!}
                                    {!! Form::submit('Cancelar', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div><h6 class="p-2">Configuración</h6></div>
                    <div class="card-body d-flex justify-content-between">
                        <button class="btn btn-outline-primary btn-config"
                                data-target="#card-sintomas" style="width: 23%;"> 
                            Síntomas
                        </button>
    
                        <button class="btn btn-outline-primary btn-config"
                                data-target="#card-correctivas" style="width: 23%;">
                            Correctivas
                        </button>
    
                        <button class="btn btn-outline-primary btn-config"
                                data-target="#card-preventivas" style="width: 23%;">
                            Preventivas
                        </button>
    
                        <button class="btn btn-outline-primary btn-config"
                                data-target="#card-zonas" style="width: 23%;">
                            Zonas
                        </button>
                    </div>
                </div>
                
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-7">
                <div class="d-flex flex-column">                    
                    <div id="card-sintomas" class="card d-none card-config">
                    {{-- {!! Form::model($ta, ['method' => 'PUT', 'route' => ['tipo_activo.set_sintomas', $ta->id_tipo_activo], 'class' => '']) !!} --}}
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
                                    <th class='text-center' style="color:#fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($ta->getSintomas as $sintoma)
                                        <tr>
                                            <td>{{$sintoma->getSintoma->nombre_sintoma}}</td>
                                            <td>{{$sintoma->getSintoma->getTipoSintoma->nombre_tipo_sintoma}}</td>
                                            <td class="text-center">
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['tipo_activo.destroy_sintoma', [$sintoma->id_sintoma, $ta->id_tipo_activo]],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>                        
                </div>
                    <div id="card-correctivas" class="card d-none card-config">
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
                                        <th class='text-center' style="color:#fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($ta->getTareasMantenimiento as $tarea)
                                            <tr>
                                                <td>{{$tarea->getTareaMantenimiento->nombre_tarea}}</td>
                                                <td>{{$tarea->getTareaMantenimiento->getEjecucion->nombre_ejecucion}}</td>
                                                <td>{{$tarea->getTareaMantenimiento->getZonaTarea->nombre_zona}}</td>
                                                <td class="text-center">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['tipo_activo.destroy_tarea_mantenimiento', [$tarea->id_tarea_mantenimiento, $ta->id_tipo_activo]],
                                                        'style' => 'display:inline'
                                                    ]) !!}
                                                     <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                    </div>

                    <div id="card-preventivas" class="card d-none card-config">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h5>Tareas de Mantenimiento Preventivas</h5>      
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarTareasMantenimientoPreventivasModal">
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
                                        {{-- <th class='text-center' style="color:#fff;">Última Ejecución</th> --}}
                                        <th class='text-center' style="color:#fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($ta->getTareasMantenimientoPreventiva as $tarea)
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
                                                {{-- <td class="text-center">
                                                    {{$tarea->fecha_ultima_ejecucion}}
                                                </td> --}}
                                                <td class="text-center">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['tipo_activo.destroy_tarea_mantenimiento_preventiva', [$tarea->id_tarea_mantenimiento, $ta->id_tipo_activo]],
                                                        'style' => 'display:inline'
                                                    ]) !!}
                                                     <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                    </div>

                    <div id="card-zonas" class="card card-config d-none">
                        <div class="card-body">

                            {!! Form::open([
                                'method' => 'PUT',
                                'route' => ['tipo_activo.set_zonas', $ta->id_tipo_activo]
                            ]) !!}

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="mb-0">Zonas Asociadas</h5>
                                    <small class="text-muted">
                                        Seleccione las zonas que corresponden a este tipo de activo.
                                    </small>
                                </div>

                                {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                            </div>

                            <div class="row">

                                @foreach($zonas as $zona)

                                    <div class="col-md-4 mb-2">

                                        <div class="border rounded p-2">

                                            <div class="form-check">

                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="zonas[]"
                                                    value="{{ $zona->id_zona_tarea }}"
                                                    id="zona{{ $zona->id_zona_tarea }}"

                                                    {{ in_array(
                                                        $zona->id_zona_tarea,
                                                        $ta->getZonas->pluck('id_zona_tarea')->toArray()
                                                    ) ? 'checked' : '' }}
                                                >

                                                <label
                                                    class="form-check-label"
                                                    for="zona{{ $zona->id_zona_tarea }}"
                                                >
                                                    {{ $zona->nombre_zona }}
                                                </label>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('Ingenieria.Activos.Tipo_activo.modal.editar-sintomas-tipo-activo')
@include('Ingenieria.Activos.Tipo_activo.modal.editar-tareas-mantenimiento-tipo-activo')
@include('Ingenieria.Activos.Tipo_activo.modal.editar-tareas-mantenimiento-prev-tipo-activo')
<script>
    $(document).ready(function () {
        var url = '{{route('activos.index')}}';
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

    $('.btn-config').click(function () {

        $('.card-config').addClass('d-none');

        $($(this).data('target'))
            .removeClass('d-none');
    });
</script>
@endsection