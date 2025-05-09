<!-- Modal -->
<div class="modal fade" id="verProgOrdenManModal" tabindex="-1" aria-labelledby="progresoOrdenMan" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="progresoOrdenMan">Orden Manufactura - Progreso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="">
                <div class="row mb-3">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('prg_ord_man', 'Orden Manufactura:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('prg_ord_man', null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'id' => 'm_prg_ord_man',
                                    'readonly'
                                ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('prg_est', 'Estado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('prg_est', null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'id' => 'm_prg_est',
                                    'readonly'
                                ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 my-auto">
                        <div class="form-group">
                            {!! Form::label('prg_progreso', 'Progreso:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <div class="progress position-relative" style="background-color: #b2baf8; z-index:1">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="div-prg-bar">
                                    <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff" id="span_prg">10 / 10</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('prg_ord_mec', 'Ordenes de Mecanizado Faltantes:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <div class="table-responsive">
                                <table id="tablaPrg" class="table table-hover mt-2" class="display">
                                    <thead style="background-color: #d37c00">
                                        <th class="text-center" scope="col" style="color:#fff;">Nombre</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>      
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>                                        
                                    </thead>
                                    <tbody id="cuadro-prg-orden">
                                        
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