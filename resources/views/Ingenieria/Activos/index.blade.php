@extends('layouts.app')

@section('titulo', 'Activos')

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
        <div class="flex-grow-1">
            <h4 class="titulo page__heading my-auto">Activos</h5>
        </div>
        <div class="pe-2">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('tipo_activo.index') }}" class="btn btn-primary">Tipo Activo</a>
                <a href="{{ route('zona.index') }}" class="btn btn-primary">Zona</a>
            </div>
        </div>
        <div class="">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoActivoModal">
                Nuevo activo
            </button>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead>
                                    <th class='text-center' style="color:#fff;">ID</th>
                                    <th class='text-center' style="color:#fff;">Codigo</th>
                                    <th class='text-center' style="color:#fff;">Nombre</th>
                                    <th class='text-center' style="color:#fff;">Descripcion</th>
                                    <th class='text-center' style="color:#fff;">Activo</th>
                                    <th class='text-center' style="color:#fff;">Tipo</th>
                                    <th class='text-center' style="color:#fff;">Tareas Preventivas (Vencidas/Total)</th>
                                    <th class='text-center' style="color: #fff;width:13vh">Acciones</th>
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($activos as $activo)
                                        <tr class="my-auto">
                                            <td class='text-center' style="vertical-align: middle;">{{$activo->id_activo}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$activo->codigo_activo ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$activo->nombre_activo ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$activo->descripcion_activo ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$activo->esta_activo ? 'SI' : 'NO'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$activo->getTipoActivo->nombre_tipo_activo ?? '-'}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">
                                                @php
                                                    if ($activo->getProgreso() >= 90) {
                                                       $color = 'bg-danger';
                                                    }else if($activo->getProgreso() >= 50){
                                                        $color = 'bg-warning';
                                                    }else{
                                                       $color = 'bg-success';
                                                    }
                                                @endphp
                                                <div class="progress position-relative" style="background-color: #b2baf8">
                                                    <div class="progress-bar progress-bar-striped {{$color}}" role="progressbar" style="width: {{$activo->getProgreso()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$activo->getTotalTareasMantenimientoPreventivaPendientes().'/'.$activo->getTotalTareasMantenimientoPreventiva()}}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseActivo{{$idCount}}" aria-expanded="false" aria-controls="collapseActivo{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseActivo{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['activos.edit', $activo->id_activo], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                         <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#crearServicioMantModal" onclick="cargarServMant({{$activo->id_activo}})">Nuevo Mant.</button>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['activos.destroy', $activo->id_activo],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea ELIMINAR el activo?');"]) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $idCount +=1;
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
    {{-- <script src="{{ asset('js/usuarios/index_usuarios.js') }}"></script> --}}
    {{-- @include('Ingenieria.Maquinaria.modal.crear-maquinaria')--}}
    @include('Ingenieria.Activos.modal.crear-activo') 
    @include('Ingenieria.Activos.modal.crear-serv-mant')

<script>
    $(document).ready(function () {
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'activo';

        $.when($.ajax({
            type: "post",
            url: '/documentacion/obtener/'+nombreArchivo, 
            data: {
                nombreArchivo: nombreArchivo,
            },
            success: function (response) {
                document.getElementById('ayudin').href = response;
            },
            error: function (error) {
                console.log(error);
            }
        }));
        $('#example').DataTable({
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