<!-- Modal -->
<div class="modal fade" id="editarEtapaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Etapa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('etapa.actualizar') }}" method="POST" class="formulario">
                @csrf
            <input type="hidden" name="id_etapa" id="m_ee_id_etapa" value="{{ old('id_etapa') }}" class="form-control">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="input-nombre_etapa" class="control-label" style="white-space: nowrap;">Nombre etapa:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="nom_etapa" id="input-nombre_etapa" value="{{ old('nom_etapa') }}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="cbx_responsable_etapa" class="control-label fs-7" style="white-space: nowrap;">Responsable:</label>
                                <span class="obligatorio">*</span>
                                <select name="responsable" id="cbx_responsable_etapa" class="form-select form-control">
                                    <option value="" {{ old('responsable') === null || old('responsable') === '' ? 'selected' : '' }}>Seleccionar</option>
                                    @foreach ($supervisores_admin as $id => $nombre)
                                        <option value="{{ $id }}" {{ (string) old('responsable') === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="input-fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
                                        {{-- <span class="obligatorio">*</span> --}}
                            <input type="date" name="fecha_ini" id="input-fec_ini" value="{{ old('fecha_ini', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control">
                        </div>

                    </div>
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