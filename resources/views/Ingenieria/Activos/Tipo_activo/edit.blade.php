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
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-7">
                <div class="d-flex flex-column">
                    <div class="card">
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
                                        <th class='text-center' style="color:#fff;">Eliminar</th>
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
                                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
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
                                <h5>Tareas de Mantenimiento</h5>      
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
                                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
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
@include('Ingenieria.Activos.Tipo_activo.modal.editar-sintomas-tipo-activo')
@include('Ingenieria.Activos.Tipo_activo.modal.editar-tareas-mantenimiento-tipo-activo')
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
    });
</script>
@endsection