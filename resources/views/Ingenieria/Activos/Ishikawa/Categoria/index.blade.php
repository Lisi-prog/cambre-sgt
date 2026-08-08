@extends('layouts.app')

@section('titulo', 'Las 5M - Categorías')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="flex-grow-1">
            <h4 class="titulo page__heading my-auto">Las 5M - Categorías</h5>
        </div>
        <div class="pe-2">
        </div>
        <div class="">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaCategoriaModal">
                Nueva categoría
            </button>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="tabla_categorias">
                                <thead>
                                    <th class='text-center' style="color:#fff;">ID</th>
                                    <th class='text-center' style="color:#fff;">Categoria</th>
                                    <th class='text-center' style="color:#fff;">Código</th>
                                    <th class='text-center' style="color: #fff;width:10%">Acciones</th>
                                </thead>
                                <tbody id="tabla_categorias_body">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($categorias as $categoria)
                                        <tr>
                                            <td class='text-center'>{{ $categoria->id_ishikawa_categoria }}</td>
                                            <td class='text-start'>{{ $categoria->nombre_categoria }}</td>
                                            <td class='text-center'>{{ $categoria->codigo_categoria }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="me-1" style="width: 50% !important;">
                                                        <a type="button" class="btn btn-primary w-100" href="{{route('ishikawa_categoria.edit', $categoria->id_ishikawa_categoria)}}"><i class="fas fa-edit"></i></a>
                                                    </div>
                                                    <div class="me-1" style="width: 50% !important;">
                                                        {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['ishikawa_categoria.destroy', $categoria->id_ishikawa_categoria],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('¿Está seguro que desea ELIMINAR la categoría?');">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                                {{-- <div class="row justify-content-center">
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
                                                </div> --}}
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