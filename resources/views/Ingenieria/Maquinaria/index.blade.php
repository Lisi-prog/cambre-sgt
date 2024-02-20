@extends('layouts.app')

@section('titulo', 'Maquinaria')

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
            <h4 class="titulo page__heading my-auto mr-5">Maquinaria</h4>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
            {{-- @can('CREAR-RI') --}}
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaMaquinariaModal">
                Nueva maquinaria
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
                                <thead style="height:50px;">
                                    <th class='text-center' style="color:#fff;">Codigo</th>
                                    <th class='text-center' style="color:#fff;">Alias</th>
                                    <th class='text-center' style="color:#fff;">Descripcion</th>
                                    <th class='text-center' style="color:#fff;">Sector</th>
                                    <th class='text-center' style="color: #fff;width:13vh">Acciones</th>
                                </thead>
                                <tbody>
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($maquinarias as $maquinaria)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$maquinaria->codigo_maquinaria}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$maquinaria->alias_maquinaria}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$maquinaria->descripcion_maquinaria}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$maquinaria->getSector->nombre_sector ?? 'sin sector'}}</td>

                                            <td>
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMaquinarias{{$idCount}}" aria-expanded="false" aria-controls="collapseMaquinarias{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" id="collapseMaquinarias{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                            {{-- @can('EDITAR-ROL') --}}
                                                                {!! Form::open(['method' => 'GET', 'route' => ['maquinarias.edit', $maquinaria->id_maquinaria], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                                {{-- <button type="button" class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#editarMaquinariaModal" onclick="cargarModalEditar({{$maquinaria->id_maquinaria}})">
                                                                    Editar
                                                                </button> --}}
                                                            {{-- @endcan --}}
                                                        </div>
                                                            {{-- @can('BORRAR-ROL') --}}
                                                            <div class="row my-2 justify-content-center">    
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['maquinarias.destroy', $maquinaria->id_maquinaria],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea ELIMINAR la maquinaria?');"]) !!}
                                                                {!! Form::close() !!}
                                                            {{-- @endcan --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $idCount += 1;
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
    @include('Ingenieria.Maquinaria.modal.crear-maquinaria')
    @include('Ingenieria.Maquinaria.modal.editar-maquinaria')

<script>
    function cargarModalEditar(id){
        let codigo = document.getElementById('input_codigo_maquinaria');
        let alias = document.getElementById('input_alias_maquinaria');
        let descripcion = document.getElementById('input_descripcion');

        $.when($.ajax({
            type: "post",
            url: '/maquinaria/obtener/'+id, 
            data: {
                    id: id,
                },
            success: function (response) {
                    codigo.value = response.codigo_maquinaria;
                    alias.value = response.alias_maquinaria;
                    descripcion.value = response.descripcion_maquinaria
                    if (response.id_sector) {
                        document.querySelector('#input_id_sector').value = response.id_sector;
                    }     
            },
            error: function (error) {
                console.log(error);
            }
        }));
    }
</script>

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