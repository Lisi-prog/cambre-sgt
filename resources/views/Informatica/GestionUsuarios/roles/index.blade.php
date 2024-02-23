@extends('layouts.app')

@section('titulo', 'Roles')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Roles</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                <div class="card">
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
                </div>

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
                                    <th class='text-center' style="color:#fff;">Rol</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $rol)
                                        <tr>
                                            <td class='text-center'>{{$rol->id}}</td>

                                            <td class='text-center'>{{$rol->name}}</td>

                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    {{-- @can('EDITAR-ROL') --}}
                                                        {!! Form::open(['method' => 'GET', 'route' => ['roles.edit', $rol->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                        {!! Form::close() !!}
                                                    {{-- @endcan --}}

                                                    {{-- @can('BORRAR-ROL') --}}
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'class' => 'formulario',
                                                            'route' => ['roles.destroy', $rol->id],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger', 'onclick' => "return confirm('¿Está seguro que desea BORRAR el rol?');"]) !!}
                                                        {!! Form::close() !!}
                                                    {{-- @endcan --}}

                                                    {{-- @can('AGREGAR-PERMISOS')--}}
                                                        {!! Form::open(['method' => 'GET', 'route' => ['roles.permisos', $rol->id], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Permisos', ['class' => 'btn btn-info ml-2']) !!}
                                                        {!! Form::close() !!}
                                                    {{-- @endcan  --}}
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
                order: [[ 0, 'asc' ]],
                "aaSorting": []
        });
    });
</script>

    
@endsection