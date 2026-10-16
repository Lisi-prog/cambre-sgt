<!-- Modal -->
<div class="modal fade" id="editarOrdenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Orden</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orden.editar') }}" method="POST" class="formulario">
                @csrf
            <div class="modal-body" id="modal-body-editar-orden">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            
                            
                            <input type="hidden" name="id_orden_edit" id="id_orden_edit" value="{{ old('id_orden_edit') }}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="etapa_edit" class="control-label" style="white-space: nowrap;">Etapa:</label>
                            <input type="text" name="etapa_edit" id="etapa_edit" value="{{ old('etapa_edit') }}" class="form-control" required readonly>
                            
                        </div>
                    </div>
                </div>
                <div id="formulario-editar-orden">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>