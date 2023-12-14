@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    
    <div class="section-header d-flex">
        <div class="">
            <h4 class="titulo page__heading my-auto">Ordenes</h4>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {{-- <div class="card">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                <form method="GET" action="">
                                    <div class="input-group">
                                        <input name="name" type="text" class="form-control" placeholder="Buscar Rol" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">

                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                {!! Form::open(['method' => 'GET', 'route' => ['roles.create'], 'class' => 'd-flex justify-content-end']) !!}
                                    {!! Form::submit('Nuevo Rol', ['class' => 'btn btn-success my-1']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="card">
                    <div class="card-body">
                        <!-- Centramos la paginacion a la derecha -->
                        {{-- <div class="pagination justify-content-end">
                                {!! $CategoriasLaborales->links() !!}
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead style="height:50px;">
                                    <th class='ml-3 text-center' style="color:#fff;">Proyecto</th>
                                    <th class='text-center' style="color:#fff;">Orden</th>
                                    <th class='text-center' style="color:#fff;">Tipo de orden</th>
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    <th class='text-center' style="color:#fff;">Responsable</th>
                                    <th class='text-center' style="color:#fff;">Prioridad</th>
                                    <th class='text-center' style="color:#fff;">Fecha inicio</th>
                                    <th class='text-center' style="color:#fff;">Fecha limite</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($ordenes_trabajo as $orden_trabajo)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$orden_trabajo->getEtapa->getServicio->nombre_servicio}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden_trabajo->nombre_orden_trabajo}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden_trabajo->getTipoOrden()}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$orden_trabajo->getPartes->sortByDesc('id_parte_trabajo')->first()->getEstado->nombre_estado}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden_trabajo->getResponsable->getEmpleado->nombre_empleado}}</td>

                                            <td class='text-center' style="vertical-align: middle;">*Prioridad*</td>

                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($orden_trabajo->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha)->format('d-m-Y')}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($orden_trabajo->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha_limite)->format('d-m-Y')}}</td>

                                            <td>
                                                {{-- <div class="row">
                                                    <div class="col-6">
                                                        {!! Form::open(['method' => 'GET', 'route' => ['ordenes_trabajo.show', $ordenes_trabajo->id_servicio], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Ver', ['class' => 'btn btn-danger w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                    <div class="col-6">
                                                        {!! Form::open(['method' => 'GET', 'route' => ['ordenes_trabajo.show', $ordenes_trabajo->id_servicio], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Evaluar', ['class' => 'btn btn-warning w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        {!! Form::open(['method' => 'GET', 'route' => ['ordenes_trabajo.gestionar', $orden->id_servicio], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Gestionar', ['class' => 'btn btn-primary w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div> --}}
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
    {{-- <script src="{{ asset('js/usuarios/index_usuarios.js') }}"></script> --}}

{{-- <script src="{{ asset('js/categorialaboral/index_categorialaboral.js') }}"></script> --}}
{{-- <script src="{{ asset('js/modal/success.js') }}"></script> --}}

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