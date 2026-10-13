@extends('layouts.app')

@section('titulo', 'Las 5M - Diagnóstico')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="flex-grow-1">
            <h4 class="titulo page__heading my-auto">Las 5M - Diagnóstico</h5>
        </div>
        <div class="pe-2">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('ishikawa_categoria.index') }}" class="btn btn-primary">Categoria</a>
            </div>
        </div>
        <div class="">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaCausaModal">
                Nuevo Diagnóstico
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
                            <table class="table table-striped mt-2" id="tabla_causas">
                                <thead>
                                    <th class='text-center' style="color:#fff;">ID</th>
                                    <th class='text-center' style="color:#fff;">Diagnóstico</th>
                                    <th class='text-center' style="color:#fff;">Explicación</th>
                                    <th class='text-center' style="color:#fff;">Categoria</th>
                                    <th class='text-center' style="color: #fff;width:10%">Acciones</th>
                                </thead>
                                <tbody id="tabla_causas_body">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($causas as $causa)
                                        <tr>
                                            <td class="text-center">{{ $causa->id_ishikawa_causa }}</td>
                                            <td class="text-start">{{ $causa->nombre_causa }}</td>
                                            <td class="text-start">{{ $causa->explicacion }}</td>
                                            <td class="text-center">{{ $causa->getCategoria->nombre_categoria }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="me-1" style="width: 50% !important;">
                                                        <a type="button" class="btn btn-primary w-100" href="{{route('ishikawa_causa.edit', $causa->id_ishikawa_causa)}}"><i class="fas fa-edit"></i></a>
                                                    </div>
                                                    <div class="me-1" style="width: 50% !important;">
                                                        {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['ishikawa_causa.destroy', $causa->id_ishikawa_causa],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('¿Está seguro que desea ELIMINAR el diagnóstico?');">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                                {{-- <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCausa{{$idCount}}" aria-expanded="false" aria-controls="collapseCausa{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#tabla_causas_body" id="collapseCausa{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['ishikawa_causa.edit', $causa->id_ishikawa_causa], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['ishikawa_causa.destroy', $causa->id_ishikawa_causa],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea ELIMINAR la causa?');"]) !!}
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
@include('Ingenieria.Activos.Ishikawa.Causa.modal.crear-causa')

<script>
    $(document).ready(function () {
        var url = '{{url('')}}';
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        $('#tabla_causas').DataTable({
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