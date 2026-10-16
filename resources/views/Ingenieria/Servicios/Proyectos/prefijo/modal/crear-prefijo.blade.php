<!-- Modal -->
<div class="modal fade" id="nuevoPrefijoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo prefijo proyecto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('prefijo_proyecto.store') }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="nombre_prefijo" class="control-label fs-7" style="white-space: nowrap;">Nombre prefijo:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="nombre_prefijo" id="nombre_prefijo" value="{{ old('nombre_prefijo') }}" class="form-control reset-input" style="text-transform:uppercase" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="descripcion" class="control-label" style="white-space: nowrap;">Descripcion:</label>
                            <span class="obligatorio">*</span>
                            <textarea name='descripcion' id="descripcion" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required>{{ old('descripcion') }}</textarea>
                        </div>
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
