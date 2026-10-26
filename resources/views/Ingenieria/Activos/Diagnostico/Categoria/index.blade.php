@extends('layouts.app')

@section('titulo', 'Categorías de diagnóstico')

@section('content')
<section class="section">
    <div class="section-header d-flex">
        <div class="flex-grow-1">
            <h4 class="titulo page__heading my-auto">Categorías de diagnóstico</h4>
        </div>
        <a href="{{ route('diagnostico.index') }}" class="btn btn-primary me-2">Diagnósticos</a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaCategoriaModal">Nueva categoría</button>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="tabla_categorias">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="color:#fff;">ID</th>
                                        <th class="text-center" style="color:#fff;">Categoría</th>
                                        <th class="text-center" style="color:#fff; width: 5%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categorias as $categoria)
                                        <tr>
                                            <td class="text-center">{{ $categoria->id_diagnostico_categoria }}</td>
                                            <td>{{ $categoria->nombre_diagnostico_categoria }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-primary me-1" href="{{ route('diagnostico_categoria.edit', $categoria->id_diagnostico_categoria) }}" title="Editar categoría" aria-label="Editar categoría"><i class="fas fa-edit"></i></a>
                                                    <form method="POST" action="{{ route('diagnostico_categoria.destroy', $categoria->id_diagnostico_categoria) }}" class="formulario" onsubmit="return confirm('¿Está seguro que desea ELIMINAR la categoría?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Eliminar categoría" aria-label="Eliminar categoría"><i class="fas fa-trash-alt"></i></button>
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

<div class="modal fade" id="nuevaCategoriaModal" tabindex="-1" aria-labelledby="nuevaCategoriaTitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevaCategoriaTitulo">Nueva categoría de diagnóstico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form method="POST" action="{{ route('diagnostico_categoria.store') }}" class="formulario form-prevent-multiple-submits">
                @csrf
                <div class="modal-body">
                    @include('Ingenieria.Activos.Diagnostico.Categoria._form', ['categoria' => null])
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
        document.getElementById('volver').href = @json(route('diagnostico.index'));
        document.getElementById('ayudin').hidden = false;
        $('#tabla_categorias').DataTable({
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
            bootstrap.Modal.getOrCreateInstance(document.getElementById('nuevaCategoriaModal')).show();
        @endif
    });
</script>
@endsection

