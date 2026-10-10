<!-- Modal -->
<div class="modal fade" id="avanceProyectoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Avance de servicio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="cod_serv_input" class="control-label" style="white-space: nowrap; ">ID:</label>
                            <input type="text" name="cod_serv" id="cod_serv_input" class="form-control" value="-" required readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            <label for="nom_serv_input" class="control-label" style="white-space: nowrap; ">Nombre servicio:</label>
                            <input type="text" name="nom_serv" id="nom_serv_input" class="form-control" value="-" required readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <label for="lider_input" class="control-label" style="white-space: nowrap; ">Lider:</label>
                            <input type="text" name="lider" id="lider_input" class="form-control" value="-" required readonly>
                        </div>
                    </div>   
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <label for="est_input" class="control-label" style="white-space: nowrap; ">Estado:</label>
                            <input type="text" name="est" id="est_input" class="form-control" value="-" required readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                            <label for="fec_ini_input" class="control-label" style="white-space: nowrap; ">Fecha inicio:</label>
                            <input type="text" name="fc_ini" id="fec_ini_input" class="form-control" value="-" required readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                            <label for="fec_lim_input" class="control-label" style="white-space: nowrap; ">Fecha limite:</label>
                            <input type="text" name="fc_lim" id="fec_lim_input" class="form-control" value="-" required readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="prog" class="control-label" style="white-space: nowrap; ">Progreso:</label>
                            <div class="progress position-relative" style="background-color: #b2baf8">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="barra-progreso">
                                    <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff" id="numero-progreso">0%</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="eta" class="control-label" style="white-space: nowrap; ">Etapas:</label>
                            <div class="table-responsive tableFixHead">
                                <table id="tablaAct" class="table table-hover mt-2" class="display">
                                    <thead style="background-color:#2970c1" id="tbeta">
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha inicio</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Avance</th>                                                   
                                    </thead>
                                    <tbody id="cuadro-ver-etapas">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if (Auth::user()->can('VER-GESTIONAR-MANTENIMIENTO'))
                    <a id="btn-avance-gest" href="" class="btn btn-primary" target="_blank">Gestionar</a>
                @endif
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>