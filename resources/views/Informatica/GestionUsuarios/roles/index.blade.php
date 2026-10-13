@extends('layouts.app')

@section('titulo', 'Roles')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h4 class="titulo page__heading my-auto">Roles</h4>
        </div>
        <div class="ms-auto">
            <a class="btn btn-success" href="{{route('roles.create')}}">Nuevo Rol</a>
        </div>
    </div>
    <div class="section-body">
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-sm" id="roles">
                            <thead>
                                <th class='text-center' style="color:#fff; width: 10%;">Codigo</th>
                                <th class='text-center' style="color:#fff; width: 80%;">Rol</th>
                                <th class='text-center' style="color: #fff; width: 10%;">Acciones</th>
                            </thead>
                            <tbody id="accordion">
                                @php
                                    $idCount = 0;   
                                @endphp
                                @foreach ($roles as $rol)
                                    <tr class="my-auto">
                                        <td class='text-center' style="vertical-align: middle;">{{$rol->id}}</td>

                                        <td style="vertical-align: middle;">{{$rol->name}}</td>

                                        <td>
                                            <div class="d-flex">
                                                <div class="me-1" style="width: 50% !important;">
                                                    <a title="Editar" type="button" class="btn btn-primary w-100" href="{{route('roles.edit', $rol->id)}}"><i class="fas fa-edit"></i></a>
                                                </div>
                                                <div class="me-1" style="width: 50% !important;">
                                                    <a title="Permisos" type="button" class="btn btn-info w-100" href="{{route('roles.permisos', $rol->id)}}"><i class="fas fa-clipboard-list"></i></a>
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
</section>

<script>
    $(document).ready(function () {
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'rol';

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
        $('#roles').DataTable({
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
                order: [[ 0, 'asc' ]],
                "aaSorting": []
        });
    });
</script>

    
@endsection