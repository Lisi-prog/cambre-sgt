<!-- Modal -->
<div class="modal fade" id="editarOpe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Operacion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::model($orden, ['method' => 'POST', 'route' => ['ope.edit'], 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body pb-0">
                {!! Form::number('id_ope', null, ['class' => 'form-control', 'hidden', 'id' => 'm_edi_idope']) !!}
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('m_numero_ope', 'Numero:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <select class="form-select form-group" id="m_edi_num_ope" required="" name="m_edi_num_ope">
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('m_ope', 'Operacion:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_edi_ope',  null, [
                                'class' => 'form-control',
                                'id' => 'm_edi_ope',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('m_maq', 'Maquina:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_edi_maq_ope',  null, [
                                'class' => 'form-control',
                                'id' => 'm_edi_maq_ope',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('m_asig', 'Asignado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_edi_asig_ope',  null, [
                                'class' => 'form-control',
                                'id' => 'm_edi_asig_ope',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <div class="form-group">
                            {!! Form::label('m_act', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_edi_act_ope',  null, [
                                'class' => 'form-control',
                                'id' => 'm_edi_act_ope',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('m_adc', 'Adicional:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="checkDefaultActOpe" name="act-ope">
                                <label class="form-check-label" for="checkDefaultActOpe">
                                    Activar esta operacion.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>