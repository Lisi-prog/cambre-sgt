<!-- Modal -->
<div class="modal fade" id="activarOrdenManufacturaModal" tabindex="-1" aria-labelledby="actOrdManModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="actOrdManModalLabel">Activar Orden de Manufactura</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'ordenes.ordenman.validar', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits activar-orden-manufactura']) !!}
            {!! Form::number('idord', null, ['class' => 'form-control', 'id' => 'm_act_id_ord_man', 'hidden']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('proyecto', 'Proyecto:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('proyecto', null, ['class' => 'form-control', 'id' => 'm_act_ord_man_pry', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('prioridad', 'Orden Manufactura:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('ordman', null, ['class' => 'form-control', 'id' => 'm_act_ord_man', 'readonly']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::label('ope_ems', 'Operacion de Ensamblado:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('prioridad', 'Prioridad:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::number('prioridad', null, ['class' => 'form-control', 'id' => 'm_act_ord_man_pri']) !!}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('operacion', 'Operacion:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('operacion', null, ['class' => 'form-control', 'id' => 'm_act_ord_man_ope', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('maquina', 'Maquina:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('maquina', null, ['class' => 'form-control', 'id' => 'm_act_ord_man_maq', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('asignado', 'Asignado:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::select('asignado', $tecnicosConManual, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'm_act_ord_man_asig',
                                            'required'
                                        ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div id="alert-act-ord" class="mx-3">
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Activar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
