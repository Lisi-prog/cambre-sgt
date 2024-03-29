@extends('layouts.app')
@section('titulo', 'Ver S.S.I.')
@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Requerimiento de ingenieria</h3>
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
                                    <th class='text-center' style="color:#fff;">Fecha</th>
                                    <th class='ml-3 text-center' style="color:#fff;">Codigo</th>
                                    <th class='text-center' style="color:#fff;">Nombre</th>
                                    <th class='text-center' style="color:#fff;">Sector</th>
                                    <th class='text-center' style="color:#fff;">Empleado</th>
                                    <th class='text-center' style="color:#fff;">Descripcion</th>
                                    <th class='text-center' style="color:#fff;">Fecha requerida</th>
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    <th class='text-center' style="color:#fff;">Prioridad</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($ListaRI as $Ri)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Ri->getSolicitud->fecha_carga)->format('d-m-Y')}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ri->getSolicitud->id_solicitud}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ri->getSolicitud->nombre_solicitante}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ri->getSector->nombre_sector}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ri->getEmpleado->nombre_empleado}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ri->getSolicitud->descripcion_solicitud}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Ri->getSolicitud->fecha_requerida)->format('d-m-Y')}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ri->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ri->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud}}</td>

                                            <td>
                                                {!! Form::open(['method' => 'GET', 'route' => ['home'], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('Evaluar', ['class' => 'btn btn-warning w-100']) !!}
                                                {!! Form::close() !!}
                                            </td>
                                            {{--@if (!is_null($obra->id_loc))
                                                <td class='text-center' style="vertical-align: middle;">{{$obra->getLocalidad->nom_loc}}</td>
                                            @else
                                                <td class='text-center' style="vertical-align: middle;"> NO EXISTE </td>
                                            @endif
                                            
                                            
                                            <td>
                                                <div>
                                                    <div class="row mb-2 ">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                            {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.show',$obra->id_obr], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Ver', ['class' => 'btn btn-warning w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                            @can('EDITAR-OBRAVIVIENDA')
                                                                {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.edit',$obra->id_obr], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary w-100']) !!}
                                                                {!! Form::close() !!}
                                                            @endcan
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            
                                                            @can('EDITAR-OBRAVIVIENDA')
                                                                {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.viviendas',$obra->id_obr], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Viviendas', ['class' => 'btn btn-primary mb-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                            @endcan
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        @can('VER-OBRAVIVIENDA')
                                                            {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.etapas', $obra->id_obr], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Etapas/Entregas', ['class' => 'btn btn-primary mr-2 w-100']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            </td> --}}
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
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
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