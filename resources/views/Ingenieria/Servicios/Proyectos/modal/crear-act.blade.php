<!-- Modal -->
<div class="modal fade" id="crearActModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear actualizacion proyecto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('actualizacion.crear', $proyecto->id_servicio) }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="descripcion" class="control-label" style="white-space: nowrap;">Descripcion:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="id_estado" class="control-label" style="white-space: nowrap;">Estado:</label>
                            <span class="obligatorio">*</span>
                            <select name="id_estado" id="id_estado" class="form-select form-group" required>
                                <option value="" {{ old('id_estado') === null || old('id_estado') === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($estados as $valor => $nombre)
                                    <option value="{{ $valor }}" {{ (string) old('id_estado') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="fecha_limite" class="control-label fs-7" style="white-space: nowrap;">Fecha limite:</label>
                                        <span class="obligatorio">*</span>
                            <input type="date" name="fecha_limite" id="fecha_limite" value="{{ old('fecha_limite', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            <label for="cbx_lider" class="control-label" style="white-space: nowrap;">Lider:</label>
                            <span class="obligatorio">*</span>
                            <select name="lider" id="cbx_lider" class="form-select form-group" required>
                                <option value="" {{ old('lider') === null || old('lider') === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($empleados as $valor => $nombre)
                                    <option value="{{ $valor }}" {{ (string) old('lider') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
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