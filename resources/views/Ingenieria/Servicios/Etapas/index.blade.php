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
                                    <th class='text-center' style="color:#fff;">Prioridad</th>
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
                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->getServicio->prioridad_servicio}}</td>

                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$etapa->getServicio->nombre_servicio}}" style="text-decoration:none; font-variant: none;">{{$etapa->getServicio->codigo_servicio}} <i class="fas fa-eye"></i></abbr></td>

                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->descripcion_etapa}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->getResponsable->getEmpleado->nombre_empleado}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->getEstado->nombre_estado}}</td>

                                            <td class= 'text-center'>{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_limite)->format('d-m-Y')}}</td>

                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verEtapaModal" onclick="window.cargarModalVerEtapa({{$etapa->id_etapa}})">
                                                            ver
                                                        </button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="button" class="btn 'btn btn-warning w-100'" data-bs-toggle="modal" data-bs-target="#verEtapaModal">
                                                            parte
                                                        </button>
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

@include('Ingenieria.Servicios.Etapas.modal.ver-etapa')
<script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
<script src="{{ asset('js/change-td-color.js') }}"></script>
<script type="module"> 
    import {cargarModalVerEtapa} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
    window.cargarModalVerEtapa = cargarModalVerEtapa;
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
                order: [[ 0, 'asc' ]],
                "aaSorting": []
        });
    });
</script>

    
@endsection