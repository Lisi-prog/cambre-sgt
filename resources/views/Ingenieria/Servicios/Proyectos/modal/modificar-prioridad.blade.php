<!-- Modal -->
<div class="modal fade" id="modificarPrioridadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar prioridad del proyecto.</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('proyectos.cambiarprioridad') }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf

            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id_proyecto" id="id_proyecto" value="{{ old('id_proyecto') }}" class="form-control">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="m-codigo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Codigo:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="codigo_proyecto" id="m-codigo_proyecto" value="{{ old('codigo_proyecto') }}" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            <label for="m-nombre_proyecto" class="control-label fs-7" style="white-space: nowrap;">Nombre:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="nombre_proyecto" id="m-nombre_proyecto" value="{{ old('nombre_proyecto') }}" class="form-control" required readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="num_prioridad" class="control-label fs-7" style="white-space: nowrap;">Prioridad:</label>
                                <span class="obligatorio">*</span>
                                <input type="number" name="prioridad" id="num_prioridad" value="{{ old('prioridad') }}" class="form-control" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            <label for="id_motivo" class="control-label fs-7" style="white-space: nowrap;">Motivo del cambio:</label>
                            <span class="obligatorio">*</span>
                            <textarea name='motivo' id="id_motivo" class="form-control" rows="54" cols="54" style="resize:none; height: 15vh" required>{{ old('motivo') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <div class="form-group">
                            <span class="control-label fs-7" style="white-space: nowrap;">Opciones:</span>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value=1 id="sin-pri" name="sin-pri">
                                <label class="form-check-label" for="sin-pri">
                                    Sin prioridad.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
