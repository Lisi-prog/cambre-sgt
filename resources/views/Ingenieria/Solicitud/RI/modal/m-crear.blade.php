<!-- Modal -->
<div class="modal fade" id="crearRIModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear requerimiento de ingenieria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('r_i.store') }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf
            <div class="modal-body">
                <div class="row">
                    @include('layouts.modal.mensajes')

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label for="selected-prioridad" class="control-label fs-7" style="white-space: nowrap;">Prioridad:</label>
                                <span class="obligatorio">*</span>
                                <select name="id_prioridad" id="selected-prioridad" class="form-select" required>
                                    <option value="" {{ old('id_prioridad') === null || old('id_prioridad') === '' ? 'selected' : '' }}>Seleccionar</option>
                                    @foreach ($Prioridades as $id => $nombre)
                                        <option value="{{ $id }}" {{ (string) old('id_prioridad') === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3" id="fecha_req">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label for="descrip" class="control-label fs-7" style="white-space: nowrap;">Descripcion:</label>
                                <span class="obligatorio">*</span>
                                <textarea name='descripcion' id="descrip" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 25vh" required>{{ old('descripcion') }}</textarea>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id='descrip_urgencia'>
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

<script src="{{ asset('js/Ingenieria/Solicitud/crear-rssi-no-au.js') }}"></script>
