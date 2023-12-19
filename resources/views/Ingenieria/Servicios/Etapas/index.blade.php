@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h4 class="titulo page__heading my-auto">Etapas</h4>
        </div>
        <div class="ms-auto">
            {{-- @can('CREAR-RI') --}}
                {!! Form::open(['method' => 'GET', 'route' => ['etapas.create'], 'class' => 'd-flex justify-content-end']) !!}
                    {!! Form::submit('Nuevo', ['class' => 'btn btn-success my-1']) !!}
                {!! Form::close() !!}
            {{-- @endcan --}}
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Centramos la paginacion a la derecha -->
                        {{-- <div class="pagination justify-content-end">
                                {!! $CategoriasLaborales->links() !!}
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead style="height:50px;">
                                    <th class='text-center' style="color:#fff;">Proyecto</th>
                                    <th class='text-center' style="color:#fff;">Etapa</th>
                                    <th class='text-center' style="color:#fff;">Lider</th>
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    <th class='text-center' style="color:#fff;">Fecha limite</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($etapas as $etapa)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->getServicio->codigo_servicio}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->descripcion_etapa}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->getResponsable->getEmpleado->nombre_empleado}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{'trello'}}</td>

                                            <td class= 'text-center'>{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_limite)->format('d-m-Y')}}</td>

                                            <td>
                                                <div class="row">
                                                    <div class="col-6">
                                                        {!! Form::open(['method' => 'GET', 'route' => ['etapas.show', $etapa->id_etapa], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Ver', ['class' => 'btn btn-danger w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                    <div class="col-6">
                                                        {!! Form::open(['method' => 'GET', 'route' => ['etapas.show', $etapa->id_etapa], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Evaluar', ['class' => 'btn btn-warning w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
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