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
                                    {{-- <th class='text-center' style="color:#fff;">Prioridad</th> --}}
                                    {{-- <th class='text-center' style="color:#fff;">Fecha</th> --}}
                                    <th class='ml-3 text-center' style="color:#fff;">ID</th>
                                    <th class='text-center' style="color:#fff;">Nombre</th>
                                    <th class='text-center' style="color:#fff;">Tipo etapa</th>
                                    {{-- <th class='text-center' style="color:#fff;">Tipo etapa</th> --}}
                                    <th class='text-center' style="color:#fff;">Lider</th>
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    <th class='text-center' style="color:#fff;">Fecha inicio</th>
                                    <th class='text-center' style="color:#fff;">Fecha limite</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    {{--@foreach ($etapas as $etapa)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->codigo_servicio}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->nombre_servicio}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->getSubTipoServicio->nombre_subtipo_servicio}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->getResponsabilidad->getEmpleado->nombre_empleado}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$etapa->getPrioridad->nombre_prioridad}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($etapa->getPrioridad->fecha_inicio)->format('d-m-Y')}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($etapa->getPrioridad->fecha_limite)->format('d-m-Y')}}</td>

                                            <td>
                                                <div class="row">
                                                    <div class="col-6">
                                                        {!! Form::open(['method' => 'GET', 'route' => ['etapas.show', $etapa->id_servicio], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Ver', ['class' => 'btn btn-danger w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                    <div class="col-6">
                                                        {!! Form::open(['method' => 'GET', 'route' => ['etapas.show', $etapa->id_servicio], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Evaluar', ['class' => 'btn btn-warning w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </td>
{{--
                                            @if (is_null($Ri->getSolicitud->fecha_requerida))
                                            <td class='text-center' style="vertical-align: middle;">Sin fecha</td>
                                            @else
                                                <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Ri->getSolicitud->fecha_requerida)->format('d-m-Y')}}</td>
                                            @endif
                                            

                                            <td class='text-center' style="vertical-align: middle;">{{$Ri->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ri->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud}}</td>

                                            <td>
                                                <div class="row">
                                                    <div class="col-6">{!! Form::open(['method' => 'GET', 'route' => ['ri.evaluar', $Ri->id_requerimiento_de_ingenieria], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Editar', ['class' => 'btn btn-danger w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                    <div class="col-6">
                                                        {!! Form::open(['method' => 'GET', 'route' => ['ri.evaluar', $Ri->id_requerimiento_de_ingenieria], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Evaluar', ['class' => 'btn btn-warning w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </td> 
                                        </tr>
                                    @endforeach--}}
                                    <div class="row">
                                        {{--<div class="col-6">{!! Form::open(['method' => 'GET', 'route' => ['ri.evaluar', $Ri->id_requerimiento_de_ingenieria], 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Editar', ['class' => 'btn btn-danger w-100']) !!}
                                            {!! Form::close() !!}
                                        </div>--}}
                                        <div class="col-6">
                                            {!! Form::open(['method' => 'GET', 'route' => ['etp.show', 1], 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Ver', ['class' => 'btn btn-warning w-100']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
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