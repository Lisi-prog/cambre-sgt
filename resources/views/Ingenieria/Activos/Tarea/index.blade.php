@extends('layouts.app')

@section('titulo', 'Tareas de Mantenimiento')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="flex-grow-1">
            <h4 class="titulo page__heading my-auto">Tareas de Mantenimiento</h5>
        </div>
        <div class="pe-2">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('tarea_ejecucion.index') }}" class="btn btn-primary">Ejecuciones</a>
                <a href="{{ route('zona_tarea.index') }}" class="btn btn-primary">Zonas</a>
            </div>
        </div>
        <div class="">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaTareaModal">
                Nueva Tarea de Mantenimiento
            </button>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="tabla_tareas">
                                <thead>
                                    <th class='text-center' style="color:#fff;">ID</th>
                                    <th class='text-center' style="color:#fff;">Nombre</th>
                                    <th class='text-center' style="color:#fff;">Zona</th>
                                    <th class='text-center' style="color:#fff;">Ejecución</th>
                                    <th class='text-center' style="color: #fff;width:10%">Acciones</th>
                                </thead>
                                <tbody id="tabla_tareas_body">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($tareas as $tarea)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle;">{{ $tarea->id_tarea_mantenimiento ?? '-'}}</td>
                                            <td class="text-start" style="vertical-align: middle;">{{ $tarea->nombre_tarea }}</td>
                                            <td class="text-center" style="vertical-align: middle;">{{ $tarea->getZonaTarea->nombre_zona }}</td>
                                            <td class="text-start" style="vertical-align: middle;">{{ $tarea->getEjecucion->nombre_ejecucion }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="me-1" style="width: 50% !important;">
                                                        <a type="button" class="btn btn-primary w-100" href="{{route('tarea_mantenimiento.edit', $tarea->id_tarea_mantenimiento)}}"><i class="fas fa-edit"></i></a>
                                                    </div>
                                                    <div class="me-1" style="width: 50% !important;">
                                                        {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['tarea_mantenimiento.destroy', $tarea->id_tarea_mantenimiento],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('¿Está seguro que desea ELIMINAR la tarea?');">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                                {{-- <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTarea{{$idCount}}" aria-expanded="false" aria-controls="collapseTarea{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#tabla_tareas_body" id="collapseTarea{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['tarea_mantenimiento.edit', $tarea->id_tarea_mantenimiento], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['tarea_mantenimiento.destroy', $tarea->id_tarea_mantenimiento],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea ELIMINAR la tarea?');"]) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            </td>
                                        </tr>
                                        @php
                                            $idCount++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('Ingenieria.Activos.Tarea.modal.crear-tarea')
<script>
    $(document).ready(function () {
        var url = '{{url('')}}';
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        $('#tabla_tareas').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
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
                order: [1, 'asc']
        });
    });

    
</script> 
@endsection