@extends('layouts.app')

@section('titulo', 'Sintomas')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="flex-grow-1">
            <h4 class="titulo page__heading my-auto">Sintomas</h5>
        </div>
        <div class="pe-2">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('tipo_sintoma.index') }}" class="btn btn-primary">Tipo Sintoma</a>
            </div>
        </div>
        <div class="">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoSintomaModal">
                Nuevo Sintoma
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
                            <table class="table table-striped mt-2" id="tabla_sintomas">
                                <thead>
                                    <th class='text-center' style="color:#fff;">ID</th>
                                    <th class='text-center' style="color:#fff;">Sintoma</th>
                                    <th class='text-center' style="color:#fff;">Tipo</th>
                                    <th class='text-center' style="color: #fff;width:10%">Acciones</th>
                                </thead>
                                <tbody id="tabla_sintomas_body">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($sintomas as $sintoma)
                                        <tr>
                                            <td class="text-center"  style="vertical-align: middle;">{{ $sintoma->id_sintoma }}</td>
                                            <td class="text-start"  style="vertical-align: middle;">{{ $sintoma->nombre_sintoma }}</td>
                                            <td class="text-center"  style="vertical-align: middle;">{{ $sintoma->getTipoSintoma->nombre_tipo_sintoma }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="me-1" style="width: 50% !important;">
                                                        <a type="button" class="btn btn-primary w-100" href="{{route('sintoma.edit', $sintoma->id_sintoma)}}"><i class="fas fa-edit"></i></a>
                                                    </div>
                                                    <div class="me-1" style="width: 50% !important;">
                                                        {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['sintoma.destroy', $sintoma->id_sintoma],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('¿Está seguro que desea ELIMINAR el síntoma?');">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                                {{-- <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSintoma{{$idCount}}" aria-expanded="false" aria-controls="collapseSintoma{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#tabla_sintomas_body" id="collapseSintoma{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['sintoma.edit', $sintoma->id_sintoma], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['sintoma.destroy', $sintoma->id_sintoma],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea ELIMINAR el síntoma?');"]) !!}
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
@include('Ingenieria.Activos.Sintomas.modal.crear-sintoma')

<script>
    $(document).ready(function () {
        var url = '{{url('')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        $('#tabla_sintomas').DataTable({
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