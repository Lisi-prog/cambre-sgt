@extends('layouts.app')

@section('titulo', 'Zona')

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
                <h4 class="titulo page__heading my-auto">Zona</h5>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            </div>
            
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 d-flex justify-content-end">
                <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#nuevaZonaModal">
                    Nueva
                </button>
            </div>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="zona_table">
                                <thead style="height:50px;">
                                    <th class='text-center' style="color:#fff;max-width:5vh">ID</th>
                                    <th class='text-center' style="color:#fff;">Nombre</th>
                                    <th class='text-center' style="color: #fff;width:13vh">Acciones</th>
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($zonas as $zona)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$zona->id_zona}}</td>

                                            <td class='text-start' style="vertical-align: middle;">{{$zona->nombre_zona}}</td>

                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('zona.edit', $zona->id_zona)}}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Editar">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="{{ route('zona.asignar.tipo', $zona->id_zona) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="SubTipos">
                                                        <i class="fas fa-tags"></i>
                                                    </a>
                                                    {{-- {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'formulario',
                                                                'route' => ['zona.destroy', $zona->id_zona],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro que desea ELIMINAR la zona?');" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash"></i></button>
                                                    {!! Form::close() !!} --}}
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
    @include('Ingenieria.Activos.Zona.modal.crear-zona') 


<script>
    $(document).ready(function () {
        var url = '{{url('/activos')}}';
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;

        $('#zona_table').DataTable({
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