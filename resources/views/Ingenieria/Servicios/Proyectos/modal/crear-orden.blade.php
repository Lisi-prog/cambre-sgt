<!-- Modal -->
<div class="modal fade" id="crearOrdenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Orden</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ordenes.crear') }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <input type="hidden" name="id_servicio" id="id_servicio" value="{{ $proyecto->id_servicio }}" class="form-control" required>
                            <label for="selected-tipo-orden" class="control-label" style="white-space: nowrap;">Tipo orden:</label>
                            <span class="obligatorio">*</span>
                            <select name="tipo_orden" id="selected-tipo-orden" class="form-select form-group" required>
                                <option value="" {{ old('tipo_orden') === null || old('tipo_orden') === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ([1 => 'Orden de trabajo', 2 => 'Orden de manufactura', 3 => 'Orden de mecanizado', 4 => 'Orden de mantenimiento'] as $valor => $nombre)
                                    <option value="{{ $valor }}" {{ (string) old('tipo_orden') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="num_etapa" class="control-label" style="white-space: nowrap;">Etapa:</label>
                            <span class="obligatorio">*</span>
                            <select name="num_etapa" id="num_etapa" class="form-select form-group reset-input" required>
                                <option value="" {{ old('num_etapa') === null || old('num_etapa') === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($etapas_plk as $valor => $nombre)
                                    <option value="{{ $valor }}" {{ (string) old('num_etapa') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div id="formulario">

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