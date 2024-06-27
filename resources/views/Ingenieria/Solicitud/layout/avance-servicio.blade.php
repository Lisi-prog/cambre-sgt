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
                            {!! Form::label('cod_serv', "ID:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('cod_serv', '-', ['class' => 'form-control', 'required', 'id' => 'cod_serv_input', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('nom_serv', "Nombre servicio:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('nom_serv', '-', ['class' => 'form-control', 'required', 'id' => 'nom_serv_input', 'readonly']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('lider', "Lider:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('lider', '-', ['class' => 'form-control', 'required', 'id' => 'lider_input', 'readonly']) !!}
                        </div>
                    </div>   
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('est', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('est', '-', ['class' => 'form-control', 'required', 'id' => 'est_input', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('fc_ini', "Fecha inicio:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('fc_ini', '-', ['class' => 'form-control', 'required', 'id' => 'fec_ini_input', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('fc_lim', "Fecha limite:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('fc_lim', '-', ['class' => 'form-control', 'required', 'id' => 'fec_lim_input', 'readonly']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('prog', "Progreso:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
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
                            {!! Form::label('eta', "Etapas:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
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
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>