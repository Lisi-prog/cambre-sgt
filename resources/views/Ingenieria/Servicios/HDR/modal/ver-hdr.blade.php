<!-- Modal -->
<div class="modal fade" id="verHdr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ver Hoja de Ruta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <div class="form-group">
                            {!! Form::label('m_id_pieza', 'ID PIEZA:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_id_pieza', $orden->nombre_orden, [
                                'class' => 'form-control',
                                'readonly',
                                'id' => 'm_ver_id_pieza'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('m_confec', 'Confeccionó:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {{-- <span class="obligatorio">*</span> --}}
                            {!! Form::text('m_confec',  $orden->getSupervisor(), [
                                'class' => 'form-control',
                                'readonly',
                                'id' => 'm_ver_confec'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <div class="form-group">
                            {!! Form::label('m_ubi', 'Ubicación/es:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_ubi', null, [
                                'class' => 'form-control reset-input',
                                'readonly',
                                'id' => 'm_ver_ubi'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('m_cant', 'Cantidad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_cant', null, [
                                'class' => 'form-control reset-input',
                                'readonly',
                                'id' => 'm_ver_cant'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('m_fec_carga', 'Fecha:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::date('m_fec_carga', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'm_ver_fec_carga',
                                'class' => 'form-control',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row border border-danger mb-2" id="obser-fallo" hidden>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('observaciones', 'Observaciones para la Hoja de Ruta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <textarea name='observaciones_fallo' id="m_ver-obser-razon" class="form-control reset-input" maxlength="500" rows="54" cols="54" style="resize:none; height: 20vh" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('ope', 'Operaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <table class="table table-striped mt-2" id="verEditableTable">
                                <thead>
                                  <tr>
                                    <th class='text-center' style="color:#fff;">N°</th>
                                    <th class='text-center' style="color:#fff;">Operación</th>
                                    <th class='text-center' style="color:#fff;">Asignado</th>
                                    <th class='text-center' style="color:#fff;">Máquina</th>
                                  </tr>
                                </thead>
                                <tbody id="ver-table-body">
                                </tbody>
                            </table>                       
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('observaciones', 'Observaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <textarea name='observaciones' id="m_ver-obser" class="form-control reset-input" maxlength="500" rows="54" cols="54" style="resize:none; height: 20vh" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('archivo', 'Adjuntar Archivo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('m_ruta', 'Ruta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('m_ruta', null, [
                                'class' => 'form-control reset-input',
                                'id' => 'm_ver_ruta',
                                'readonly'
                            ]) !!}
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