<!-- Modal -->
<div class="modal fade" id="verParteTrabajoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="titulo-parte0">Ver Parte</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label for="vp_cod" class="control-label fs-7" style="white-space: nowrap;">Cod. Parte:</label>
                            <input id="vp_cod" class="form-control" autocomplete="off" name="vp_cod" type="text" readonly>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="vp_res" class="control-label fs-7" style="white-space: nowrap;">Responsable:</label>
                            <input id="vp_res" class="form-control" autocomplete="off" name="vp_res" type="text" readonly>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="vp_sup" class="control-label fs-7" style="white-space: nowrap;">Supervisor:</label>
                            <input id="vp_sup" class="form-control" autocomplete="off" name="vp_sup" type="text" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="vp_observaciones" class="control-label fs-7" style="white-space: nowrap;">Observaciones:</label>
                            <textarea name='observaciones' id="vp_observaciones" class="form-control" maxlength="500" rows="54" cols="54" style="resize:none; height: 20vh" readonly required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="vp_fec_limite" class="control-label fs-7" style="white-space: nowrap;">Fecha limite:</label>
                            <input type="text" name="fecha_limite" value="" id="vp_fec_limite" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="vp_fecha" class="control-label fs-7" style="white-space: nowrap;">Fecha:</label>
                            <input type="text" name="fecha" value="" id="vp_fecha" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group"> 
                            <label for="vp_horas" class="control-label" style="white-space: nowrap; ">Horas:</label>
                            <input class="form-control" name="vp_horas" type="text" value="" id="vp_horas" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="vp_estado" class="control-label" style="white-space: nowrap;">Estado:</label>
                            <input id="vp_estado" class="form-control" autocomplete="off" name="vp_estado" type="text" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
