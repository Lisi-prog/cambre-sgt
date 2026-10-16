<!-- Modal -->
<div class="modal fade" id="crearEtapaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Etapa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('etapas.store') }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf
                <input type="hidden" name="id_servicio" id="id_servicio" value="{{ $proyecto->id_servicio }}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="nom_etapa" class="control-label" style="white-space: nowrap;">Nombre etapa:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="nom_etapa" id="nom_etapa" value="{{ old('nom_etapa') }}" class="form-control reset-input" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="responsable" class="control-label fs-7" style="white-space: nowrap;">Responsable:</label>
                                <span class="obligatorio">*</span>
                                <select name="responsable" id="responsable" class="form-select form-group reset-input" required>
                                <option value="" {{ old('responsable', null) === null || old('responsable', null) === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($supervisores as $valor => $nombre)
                                    <option value="{{ $valor }}" {{ (string) old('responsable', null) === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="m-crear-eta-idestado" class="control-label" style="white-space: nowrap;">Estado:</label>
                            <span class="obligatorio">*</span>
                            <select name="m-crear-eta-idestado" id="m-crear-eta-idestado" class="form-select form-control" required>
                                <option value="" {{ old('m-crear-eta-idestado', 2) === null || old('m-crear-eta-idestado', 2) === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($estados as $valor => $nombre)
                                    <option value="{{ $valor }}" {{ (string) old('m-crear-eta-idestado', 2) === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="fecha_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
                                        {{-- <span class="obligatorio">*</span> --}}
                            <input type="date" name="fecha_ini" id="fecha_ini" value="{{ old('fecha_ini', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control reset-fecha-hoy">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="fecha_lim" class="control-label fs-7" style="white-space: nowrap;">Fecha limite:</label>
                                        {{-- <span class="obligatorio">*</span> --}}
                            <input type="date" name="fecha_lim" id="fecha_lim" value="{{ old('fecha_lim', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control reset-fecha-hoy">
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

