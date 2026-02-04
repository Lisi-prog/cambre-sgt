@extends('layouts.app')

@section('titulo', 'Categorías - Diagrama de Ishikawa')

@section('content')

<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 my-auto">
                <h4 class="titulo page__heading my-auto">Categorías - Diagrama de Ishikawa</h4>
            </div>
            <div class="col-xs-12 col-sm-1 col-md-5 col-lg-5">
            </div>
            
            <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3 d-flex justify-content-end">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaCategoriaModal">
                    Nueva categoría
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
                            <table class="table table-striped mt-2" id="tabla_categorias">
                                <thead>
                                    <th class='text-center' style="color:#fff;">ID</th>
                                    <th class='text-center' style="color:#fff;">Nombre</th>
                                    <th class='text-center' style="color:#fff;">Código</th>
                                    <th class='text-center' style="color: #fff;width:13vh">Acciones</th>
                                </thead>
                                <tbody id="tabla_categorias_body">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($categorias as $categoria)
                                        <tr>
                                            <td class='text-center'>{{ $categoria->id_ishikawa_categoria }}</td>
                                            <td class='text-center'>{{ $categoria->nombre_categoria }}</td>
                                            <td class='text-center'>{{ $categoria->codigo_categoria }}</td>
                                            <td>
                                                <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategoria{{$idCount}}" aria-expanded="false" aria-controls="collapseCategoria{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#tabla_categorias_body" id="collapseCategoria{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open(
                                                                    ['method' => 'GET', 
                                                                    'route' => ['ishikawa_categoria.edit', $categoria->id_ishikawa_categoria], 
                                                                    'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['ishikawa_categoria.destroy', $categoria->id_ishikawa_categoria],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea ELIMINAR la categoría?');"]) !!}
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
@include('Ingenieria.Activos.Ishikawa.Categoria.modal.crear-categoria')

<script>
    $(document).ready(function () {
        var url = '{{url('/ishikawa_causa')}}';
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        $('#tabla_categorias').DataTable({
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