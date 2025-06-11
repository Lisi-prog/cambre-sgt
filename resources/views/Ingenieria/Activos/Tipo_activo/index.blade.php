@extends('layouts.app')

@section('titulo', 'Tipo Activo')

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
                <h4 class="titulo page__heading my-auto">Tipo Activo</h5>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                {{-- <a href="{{route('puesto_tecnico.index')}}" class="btn btn-primary">Tipo maquinaria</a> --}}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            </div>
            
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 d-flex justify-content-end">
                <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#nuevoTipoActivoModal">
                    Nuevo
                </button>
            </div>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead style="height:50px;">
                                    <th class='text-center' style="color:#fff;max-width:5vh">Codigo</th>
                                    <th class='text-center' style="color:#fff;">Tipo</th>
                                    <th class='text-center' style="color: #fff;width:13vh">Acciones</th>
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($tipos_activo as $ta)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$ta->id_tipo_activo}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$ta->nombre_tipo_activo}}</td>

                                            <td>
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTipAct{{$idCount}}" aria-expanded="false" aria-controls="collapseTipAct{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseTipAct{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['tipo_activo.edit', $ta->id_tipo_activo], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                        </div>
                                                        <div class="row my-2 justify-content-center">    
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'formulario',
                                                                'route' => ['tipo_activo.destroy', $ta->id_tipo_activo],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea ELIMINAR el tipo activo?');"]) !!}
                                                            {!! Form::close() !!}
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
    {{-- @include('Ingenieria.Maquinaria.modal.crear-maquinaria') --}}
    @include('Ingenieria.Activos.Tipo_activo.modal.crear-tipo-activo') 


<script>
    $(document).ready(function () {
        var url = '{{url('/activos')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        // let nombreArchivo = 'maquinaria';

        $('#example').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar:',
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