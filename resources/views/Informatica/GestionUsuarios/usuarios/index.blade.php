@extends('layouts.app')

@section('titulo', 'Usuarios')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 my-auto">
                <h4 class="titulo page__heading my-auto">Usuarios</h5>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-4">
            </div>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        {!! Form::label('Opciones:') !!}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexOpc1" checked>
                            <label class="form-check-label" for="flexOpc1">
                              Solo activos.
                            </label>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
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
                                    <th class='text-center' style="color:#fff;">Usuario</th>
                                    <th class='text-center' style="color:#fff;">Email</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($usuarios as $usuario)
                                        <tr {{$usuario->getEmpleado->esta_activo ? '' : 'hidden'}} class="{{$usuario->getEmpleado->esta_activo ? '' : 'no-activo'}}">
                                            <td class='text-center' style="vertical-align: middle;">{{$usuario->id}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$usuario->name}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$usuario->email}}</td>

                                            <td>
                                                <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsuario{{$idCount}}" aria-expanded="false" aria-controls="collapseActivo{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseUsuario{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['usuarios.edit', $usuario->id], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['usuarios.destroy', $usuario->id],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger w-100', 'onclick' => "return confirm('¿Está seguro que desea BORRAR el usuario?');"]) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
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
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'usuario';

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

        $('#flexOpc1').on('change', mostrarOculto);

        function mostrarOculto() {
            document.querySelectorAll('.no-activo').forEach(element => {
                if (element.hidden) {
                    element.hidden = false;
                } else {
                    element.hidden = true;
                }
            });

        }
    });
</script>

    
@endsection