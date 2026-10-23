<!-- Modal -->
<div class="modal fade" id="editarParteTrabajoModal" tabindex="-1" aria-labelledby="titulo-editar-parte-trabajo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="editar-parte-trabajo" method="POST" action="{{ route('parte.trabajo.editar') }}">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="titulo-editar-parte-trabajo">Editar Parte</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="ep_mensaje" class="alert d-none" role="status" aria-live="polite" style="white-space: pre-line;"></div>
                <div class="row">
                    <div class="col-12 col-sm-4 col-lg-2">
                        <div class="form-group">
                            <label for="ep_cod" class="control-label fs-7" style="white-space: nowrap;">Cod. Parte:</label>
                            <input id="ep_cod" class="form-control" autocomplete="off" name="id_parte" type="text" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="ep_observaciones" class="control-label fs-7" style="white-space: nowrap;">Observaciones:</label>
                            <textarea name="observaciones" id="ep_observaciones" class="form-control" maxlength="500" rows="6" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="ep_fecha" class="control-label fs-7" style="white-space: nowrap;">Fecha:</label>
                            <input type="date" name="fecha" id="ep_fecha" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="ep_horas" class="control-label fs-7" style="white-space: nowrap;">Horas:</label>
                            <input type="text" name="horas" id="ep_horas" class="form-control" placeholder="HH:MM" pattern="[0-9]+:[0-5][0-9]" title="Ingresá la duración en horas y minutos (HH:MM)." required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="submit" class="btn btn-success" id="btn-guardar-parte-trabajo" disabled>Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </form>
    </div>
</div>
