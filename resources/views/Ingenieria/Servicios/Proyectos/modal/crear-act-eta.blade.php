<!-- Modal -->
<div class="modal fade" id="crearActEtaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear actualizacion etapa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('actualizacion-etapa.crear', $proyecto->id_servicio) }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf
            <div class="modal-body">
                <input type="hidden" name="id_etapa" id="m_cae_id_etapa" value="{{ old('id_etapa') }}" class="form-control">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="descrip" class="control-label" style="white-space: nowrap;">Descripcion:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="descripcion" id="descrip" value="{{ old('descripcion') }}" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="m-crear-act-eta-idestado" class="control-label" style="white-space: nowrap;">Estado:</label>
                            <span class="obligatorio">*</span>
                            <select name="id_estado" id="m-crear-act-eta-idestado" class="form-select form-group" required>
                                <option value="" {{ old('id_estado') === null || old('id_estado') === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($estados as $id => $nombre)
                                    <option value="{{ $id }}" {{ (string) old('id_estado') === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="m-crear-act-eta-feclimite" class="control-label fs-7" style="white-space: nowrap;">Fecha limite:</label>
                                        <span class="obligatorio">*</span>
                            <input type="date" name="fecha_limite" id="m-crear-act-eta-feclimite" value="{{ old('fecha_limite', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control">
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