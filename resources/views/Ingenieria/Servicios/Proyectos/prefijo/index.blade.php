@extends('layouts.app')

@section('titulo', 'Prefijo proyecto')

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
    <div class="section-header d-flex justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 my-auto">
            <h4 class="titulo page__heading my-auto mr-5">Prefijo Proyecto</h4>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
            {{-- @can('CREAR-RI') --}}
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoPrefijoModal">
                Nuevo prefijo
            </button>
            {{-- @endcan --}}
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
                                    <th class='text-center' style="color:#fff;">Codigo</th>
                                    <th class='text-center' style="color:#fff;">Nombre</th>
                                    <th class='text-center' style="color:#fff;">Descripcion</th>
                                    <th class='text-center' style="color: #fff;width:13vh">Acciones</th>
                                </thead>
                                <tbody>
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    
                                    @foreach ($prefijos as $prefijo)
                                        <tr class="my-auto">
                                            <td class='text-center' style="vertical-align: middle;">{{$prefijo->id_prefijo_proyecto ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$prefijo->nombre_prefijo_proyecto ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$prefijo->descripcion_prefijo_proyecto ?? '-'}}</td>


                                            <td>
                                                <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseActivo{{$idCount}}" aria-expanded="false" aria-controls="collapseActivo{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" id="collapseActivo{{$idCount}}">
                                                        {{-- @can('EDITAR-ROL') --}}
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['prefijo_proyecto.edit', $prefijo->id_prefijo_proyecto], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        {{-- @endcan --}}

                                                        {{-- @can('BORRAR-ROL') --}}
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['prefijo_proyecto.destroy', $prefijo->id_prefijo_proyecto],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea ELIMINAR el prefijo proyecto?');"]) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        {{-- @endcan --}}
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
    @include('Ingenieria.Servicios.Proyectos.prefijo.modal.crear-prefijo') 

<script>
    $(document).ready(function () {
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