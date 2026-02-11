@extends('layouts.app')

@section('titulo', 'Tareas de Mantenimiento')

@section('content')

<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 my-auto">
                <h4 class="titulo page__heading my-auto">Tareas de Mantenimiento</h4>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex justify-content-evenly">
                {!! Form::open(['method' => 'GET', 'route' => ['tarea_ejecucion.index'], 'class' => 'd-flex justify-content-end']) !!}
                    {!! Form::submit('Ejecuciones', ['class' => 'btn btn-primary', 'style' => 'width:100px']) !!}
                {!! Form::close() !!}
                {!! Form::open(['method' => 'GET', 'route' => ['zona_tarea.index'], 'class' => 'd-flex justify-content-end']) !!}
                    {!! Form::submit('Zonas', ['class' => 'btn btn-primary', 'style' => 'width:100px']) !!}
                {!! Form::close() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-5 col-lg-4">
            </div>
            
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 d-flex justify-content-end">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaTareaModal">
                    Nueva Tarea de Mantenimiento
                </button>
            </div>
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
                                    <th class='text-center' style="color: #fff;width:13vh">Acciones</th>
                                </thead>
                                <tbody id="tabla_tareas_body">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($tareas as $tarea)
                                        <tr>
                                            <td class="text-center">{{ $tarea->id_tarea }}</td>
                                            <td class="text-center">{{ $tarea->nombre_tarea }}</td>
                                            <td class="text-center">{{ $tarea->getZonaTarea->nombre_zona }}</td>
                                            <td class="text-center">{{ $tarea->getEjecucion->nombre_ejecucion }}</td>
                                            <td class="text-center">
                                                <div class="row justify-content-center">
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
                                                </div>
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
                "aaSorting": []
        });
    });

    
</script> 
@endsection