@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h4 class="titulo page__heading my-auto">Empleados</h4>
        </div>
        <div class="ms-auto">
            {{-- @can('CREAR-RI') --}}
                {!! Form::open(['method' => 'GET', 'route' => ['empleados.create'], 'class' => 'd-flex justify-content-end']) !!}
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
                                    <th class='ml-3 text-center' style="color:#fff;">Codigo</th>
                                    <th class='text-center' style="color:#fff;">Nombre</th>
                                    <th class='text-center' style="color:#fff;">Email</th>
                                    <th class='text-center' style="color:#fff;">Telefono</th>
                                    <th class='text-center' style="color:#fff;">Puesto</th>
                                    <th class='text-center' style="color:#fff;">Sector</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($empleados as $empleado)
                                        <tr>
                                            <td class='text-center'>{{$empleado->id_empleado}}</td>

                                            <td class='text-center'>{{$empleado->nombre_empleado}}</td>

                                            <td class='text-center'>{{$empleado->email_empleado}}</td>

                                            <td class='text-center'>{{$empleado->telefono}}</td>

                                            <td class='text-center'>{{$empleado->getPuestoEmpleado->titulo_puesto_empleado}}</td>

                                            <td class='text-center'>{{$empleado->getSector->nombre_sector}}</td>

                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    {{-- @can('EDITAR-ROL') --}}
                                                        {!! Form::open(['method' => 'GET', 'route' => ['empleados.edit', $empleado->id_empleado], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                        {!! Form::close() !!}
                                                    {{-- @endcan --}}

                                                    {{-- @can('BORRAR-ROL') --}}
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'class' => 'formulario',
                                                            'route' => ['empleados.destroy', $empleado->id_empleado],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    {{-- @endcan --}}

                                                    {{-- @can('AGREGAR-PERMISOS')
                                                        {!! Form::open(['method' => 'GET', 'route' => ['rubros.edit', $rubro->id], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Permisos', ['class' => 'btn btn-info mr-2']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan --}}
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