@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h4 class="titulo page__heading my-auto">Puesto empleado</h4>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearPuestoEmpleadoModal">
                Nuevo puesto
            </button>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">

                <div class="card">
                    <div class="card-body">
                        <!-- Centramos la paginacion a la derecha -->
                        {{-- <div class="pagination justify-content-end">
                                {!! $CategoriasLaborales->links() !!}
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead style="height:50px;">
                                    <th class='ml-3 text-center' style="color:#fff;">Puesto</th>
                                    <th class='text-center' style="color:#fff;">Costo hora</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($puestos_empleados as $puesto_empleado)
                                        <tr>
                                            <td class='text-center'>{{$puesto_empleado->titulo_puesto_empleado}}</td>

                                            <td class='text-center'>{{'$ ' . number_format($puesto_empleado->costo_hora, 2, ',', '.')}}</td>

                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    {{-- @can('EDITAR-ROL') --}}
                                                    <button type="button" class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#editarPuestoEmpleadoModal" onclick="cargarModalEditar({{$puesto_empleado->id_puesto_empleado}}, this)">
                                                        Editar
                                                    </button>
                                                        {{-- {!! Form::open(['method' => 'GET', 'route' => ['puesto_empleado.edit', $puesto_empleado->id_puesto_empleado], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                        {!! Form::close() !!} --}}
                                                    {{-- @endcan --}}

                                                    {{-- @can('BORRAR-ROL') --}}
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'class' => 'formulario',
                                                            'route' => ['puesto_empleado.destroy', $puesto_empleado->id_puesto_empleado],
                                                            'onclick' => "return confirm('Estas seguro que desea ELIMINAR el puesto empleado?",
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    {{-- @endcan --}}
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
    {{-- <script src="{{ asset('js/input-number-two-decimal.js') }}"></script> --}}
</section>
@include('Informatica.Puesto_empleado.modal.crear-puesto-empleado')
@include('Informatica.Puesto_empleado.modal.editar-puesto-empleado')
    {{-- <script src="{{ asset('js/usuarios/index_usuarios.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/input-number-two-decimal.js') }}"></script> --}}
    <script src="{{ asset('js/input-number-two-decimal.js') }}"></script>
{{-- <script srck="{{ asset('js/categorialaboral/index_categorialaboral.js') }}"></script> --}}

{{-- <script src="{{ asset('js/modal/success.js') }}"></script> --}}
<script>
    function cargarModalEditar(id, b){
        let input_puesto = document.getElementById('input_puesto');
        let costo_hora = document.getElementById('input-costo_hora');
        let id_puesto = document.getElementById('input_id_puesto');

        // console.log(id);
        // console.log(b.parentNode.parentNode.parentNode.children[0].innerText);
        // console.log(b.parentNode.parentNode.parentNode.children[1].innerText);
        let nombre_puesto = b.parentNode.parentNode.parentNode.children[0].innerText;
        let precio_hora = b.parentNode.parentNode.parentNode.children[1].innerText;

        input_puesto.value = nombre_puesto;
        costo_hora.value = precio_hora.replace('$ ', '').replace('.', '').replace(',', '.');
        id_puesto.value = id;
    }
    
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
                "aaSorting": []
        });
    });
</script>

    
@endsection