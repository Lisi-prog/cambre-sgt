@extends('layouts.app')

@section('titulo', 'Tipos de Sintomas')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="flex-grow-1">
            <h4 class="titulo page__heading my-auto">Tipos de Sintomas</h5>
        </div>
        <div class="">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoTipoSintomaModal">
                Nuevo sintoma
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
                            <table class="table table-striped mt-2" id="tabla_tipos_sintomas">
                                <thead>
                                    <th class='text-center' style="color:#fff;">ID</th>
                                    <th class='text-center' style="color:#fff;">Nombre</th>
                                    <th class='text-center' style="color: #fff;width:10%">Acciones</th>
                                </thead>
                                <tbody id="tabla_sintomas_body">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($tipos_sintomas as $tipo_sintoma)
                                        <tr>
                                            <td class='text-center'  style="vertical-align: middle;">{{ $tipo_sintoma->id_tipo_sintoma }}</td>
                                            <td class='text-start'  style="vertical-align: middle;">{{ $tipo_sintoma->nombre_tipo_sintoma }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="me-1" style="width: 50% !important;">
                                                        <a type="button" class="btn btn-primary w-100" href="{{route('tipo_sintoma.edit', $tipo_sintoma->id_tipo_sintoma)}}"><i class="fas fa-edit"></i></a>
                                                    </div>
                                                    <div class="me-1" style="width: 50% !important;">
                                                        {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['tipo_sintoma.destroy', $tipo_sintoma->id_tipo_sintoma],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('¿Está seguro que desea ELIMINAR el tipo de síntoma?');">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                                {{-- <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTipoSintoma{{$idCount}}" aria-expanded="false" aria-controls="collapseTipoSintoma{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#tabla_sintomas_body" id="collapseTipoSintoma{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['tipo_sintoma.edit', $tipo_sintoma->id_tipo_sintoma], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['tipo_sintoma.destroy', $tipo_sintoma->id_tipo_sintoma],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea ELIMINAR el tipo de síntoma?');"]) !!}
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
@include('Ingenieria.Activos.Sintomas.TiposSintomas.modal.crear-tipo-sintoma')

<script>
    $(document).ready(function () {
        var url = '{{url('/sintoma')}}';
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        $('#tabla_tipos_sintomas').DataTable({
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