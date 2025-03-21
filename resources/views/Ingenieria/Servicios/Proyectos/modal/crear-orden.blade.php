<!-- Modal -->
<div class="modal fade" id="crearOrdenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="m-crear-orden">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Orden</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'ordenes.crear', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::text('id_servicio', $proyecto->id_servicio, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'id' => 'id_servicio',
                                            'hidden' => true
                                        ]) !!}
                            {!! Form::label('tipo_orden', "Tipo Orden:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('tipo_orden', [1 => 'Orden de Trabajo', 2 => 'Orden de Manufactura', 3 => 'Orden de Mecanizado'], null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select form-group',
                                    'id' => 'selected-tipo-orden',
                                    'required'
                                ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('num_etapa', "Etapa:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('num_etapa', $etapas_plk, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select form-group reset-input',
                                    'required',
                                    'id' => 'num_etapa'
                                ]) !!}
                        </div>
                    </div>
                </div>
                <div id="formulario">

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