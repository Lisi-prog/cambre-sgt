@extends('layouts.app')

@section('titulo', 'Técnicos')

@section('content')

<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 my-auto">
                <h4 class="titulo page__heading my-auto">Técnicos</h5>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                {!! Form::open(['method' => 'GET', 'route' => ['puesto_tecnico.index'], 'class' => 'd-flex justify-content-end']) !!}
                    {!! Form::submit('Puesto de técnico', ['class' => 'btn btn-success']) !!}
                {!! Form::close() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-7">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orgChartModal">
                    Organigrama
                </button>
            </div>
            
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                {!! Form::open(['method' => 'GET', 'route' => ['tecnicos.create'], 'class' => 'd-flex justify-content-end']) !!}
                    {!! Form::submit('Nuevo', ['class' => 'btn btn-success col-9']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Centramos la paginacion a la derecha -->
                        {{-- <div class="pagination justify-content-end">
                                {!! $CategoriasLaborales->links() !!}
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table table-hover mt-2" id="example">
                                <thead>
                                    <th class='text-center' style="color:#fff;">Codigo</th>
                                    <th class='text-center' style="color:#fff;">Nombre</th>
                                    <th class='text-center' style="color:#fff;">Email</th>
                                    <th class='text-center' style="color:#fff;">Telefono</th>
                                    <th class='text-center' style="color:#fff;">Puesto</th>
                                    <th class='text-center' style="color:#fff;">Sector</th>
                                    <th class='text-center' style="color:#fff;">Costo/hora</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($empleados as $empleado)
                                        <tr class="my-auto {{$empleado->esta_activo ? '' : 'no-activo'}}" {{$empleado->esta_activo ? '' : 'hidden'}}>
                                            <td class='text-center' style="vertical-align: middle;">{{$empleado->id_empleado}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$empleado->nombre_empleado}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$empleado->getUser->email ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$empleado->telefono_empleado}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$empleado->getPuestoEmpleado->titulo_puesto_empleado}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$empleado->getSector->nombre_sector}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$empleado->costo_hora}}</td>

                                            <td>
                                                <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTecnico{{$idCount}}" aria-expanded="false" aria-controls="collapseActivo{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseTecnico{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['tecnicos.edit', $empleado->id_empleado], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['tecnicos.destroy', $empleado->id_empleado],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger w-100', "onclick" => "return confirm('¿Está seguro que desea ELIMINAR el técnico?');"]) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        @if ($empleado->getUser->id ?? 0)
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['usuarios.edit', $empleado->getUser->id], 'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Usuario', ['class' => 'btn btn-warning w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
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
@include('Informatica.Empleados.modal.m-org')
    {{-- <script src="{{ asset('js/usuarios/index_usuarios.js') }}"></script> --}}

{{-- <script src="{{ asset('js/categorialaboral/index_categorialaboral.js') }}"></script> --}}
{{-- <script src="{{ asset('js/modal/success.js') }}"></script> --}}

<script>
    $(document).ready(function () {
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'tecnico';

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
                order: [[0, 'asc']],
                "pageLength": 25
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