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
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 my-auto">
                <h4 class="titulo page__heading my-auto">Activos</h5>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                {!! Form::open(['method' => 'GET', 'route' => ['tipo_activo.index'], 'class' => 'd-flex justify-content-end']) !!}
                    {!! Form::submit('Tipo Activo', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-7">
                {{-- <a href="{{route('operacion.index')}}" class="btn btn-primary">Operacion</a> --}}
            </div>
            
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 d-flex justify-content-end">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoActivoModal">
                    Nuevo activo
                </button>
            </div>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
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