@extends('layouts.app')

@section('titulo', 'Puesto técnico')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 my-auto">
                <h4 class="titulo page__heading my-auto">Puesto técnico</h5>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearPuestoEmpleadoModal">
                    Nuevo puesto
                </button>
            </div>
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
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;   
                                    @endphp
                                    @foreach ($puestos_empleados as $puesto_empleado)
                                        <tr>
                                            <td class='text-center'>{{$puesto_empleado->titulo_puesto_empleado}}</td>

                                            <td class='text-center'>{{'$ ' . number_format($puesto_empleado->costo_hora, 2, ',', '.')}}</td>

                                            <td>
                                                <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePuesto{{$idCount}}" aria-expanded="false" aria-controls="collapseActivo{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapsePuesto{{$idCount}}">
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarPuestoEmpleadoModal" onclick="cargarModalEditar({{$puesto_empleado->id_puesto_empleado}}, this)">
                                                                    Editar
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2 justify-content-center">
                                                            <div class="col-12">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['puesto_tecnico.destroy', $puesto_empleado->id_puesto_empleado],
                                                                    'onclick' => "return confirm('¿Está seguro que desea BORRAR el puesto tecnico?');",
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger w-100']) !!}
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
    @include('Informatica.Puesto_empleado.modal.crear-puesto-empleado')
    @include('Informatica.Puesto_empleado.modal.editar-puesto-empleado')
    
<script src="{{ asset('js/input-number-two-decimal.js') }}"></script>

<script>
    function cargarModalEditar(id, b){
        let input_puesto = document.getElementById('input_puesto');
        let costo_hora = document.getElementById('input-costo_hora');
        let id_puesto = document.getElementById('input_id_puesto');
        let nombre_puesto = b.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.children[0].innerText;
        let precio_hora = b.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.children[1].innerText;
        input_puesto.value = nombre_puesto;
        costo_hora.value = precio_hora.replace('$ ', '').replace('.', '').replace(',', '.');
        id_puesto.value = id;
    } 
</script>

<script>
    $(document).ready(function () {
        var url = '{{route('tecnicos.index')}}';
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