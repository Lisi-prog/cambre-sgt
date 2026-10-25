@extends('layouts.app')

@section('titulo', 'Diagnósticos')

@section('content')
<section class="section">
    <div class="section-header d-flex">
        <div class="flex-grow-1">
            <h4 class="titulo page__heading my-auto">Diagnósticos</h4>
        </div>
        <a href="{{ route('diagnostico_categoria.index') }}" class="btn btn-primary me-2">Categorías de diagnóstico</a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoDiagnosticoModal">Nuevo Diagnóstico</button>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="tabla_diagnosticos">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="color:#fff;">ID</th>
                                        <th class="text-center" style="color:#fff;">Diagnóstico</th>
                                        <th class="text-center" style="color:#fff;">Explicación</th>
                                        <th class="text-center" style="color:#fff;">Categoría</th>
                                        <th class="text-center" style="color:#fff;">En uso</th>
                                        <th class="text-center" style="color:#fff;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diagnosticos as $diagnostico)
                                        <tr>
                                            <td class="text-center">{{ $diagnostico->id_diagnostico }}</td>
                                            <td>{{ $diagnostico->nombre_diagnostico }}</td>
                                            <td>{{ $diagnostico->explicacion }}</td>
                                            <td class="text-center">{{ optional($diagnostico->getCategoria)->nombre_diagnostico_categoria }}</td>
                                            <td class="text-center">{{ $diagnostico->en_uso ? 'Sí' : 'No' }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-primary me-1" href="{{ route('diagnostico.edit', $diagnostico->id_diagnostico) }}" title="Editar diagnóstico" aria-label="Editar diagnóstico"><i class="fas fa-edit"></i></a>
                                                    <form method="POST" action="{{ route('diagnostico.destroy', $diagnostico->id_diagnostico) }}" class="formulario" onsubmit="return confirm('¿Está seguro que desea ELIMINAR el diagnóstico?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Eliminar diagnóstico" aria-label="Eliminar diagnóstico"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
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

<div class="modal fade" id="nuevoDiagnosticoModal" tabindex="-1" aria-labelledby="nuevoDiagnosticoTitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoDiagnosticoTitulo">Nuevo Diagnóstico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form method="POST" action="{{ route('diagnostico.store') }}" class="formulario form-prevent-multiple-submits">
                @csrf
                <div class="modal-body">
                    @include('Ingenieria.Activos.Diagnostico._form', ['diagnostico' => null])
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        document.getElementById('volver').href = @json(url(''));
        document.getElementById('ayudin').hidden = false;
        $('#tabla_diagnosticos').DataTable({
            language: {
                lengthMenu: 'Mostrar _MENU_ registros por página',
                zeroRecords: 'No se han encontrado registros',
                info: 'Mostrando página _PAGE_ de _PAGES_',
                infoEmpty: 'No se han encontrado registros',
                infoFiltered: '(Filtrado de _MAX_ registros totales)',
                search: 'Buscar',
                paginate: { first: 'Prim.', last: 'Últ.', previous: 'Ant.', next: 'Sig.' }
            },
            aaSorting: [],
            columnDefs: [{ targets: -1, orderable: false, searchable: false }]
        });
        @if ($errors->any())
            bootstrap.Modal.getOrCreateInstance(document.getElementById('nuevoDiagnosticoModal')).show();
        @endif
    });
</script>
@endsection

