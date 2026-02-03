<div class="modal fade" id="nuevoSintomaModal" tabindex="-1" aria-labelledby="nuevoSintomaModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Nuevo Sintoma</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'sintoma.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                           {!! Form::label('nombre_sintoma', 'Nombre sintoma:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_sintoma', null, [
                                'class' => 'form-control reset-input',
                                'required' => 'required',
                                'id' => 'nombre_sintoma'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('tipo_sintoma', "Tipo de sintoma:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::select('tipo_sintoma', $tipos_sintomas->pluck('nombre_tipo_sintoma', 'id_tipo_sintoma'), null, [
                                            'class' => 'form-select form-control',
                                            'id' => 'tipo_sintoma',
                                            'placeholder' => 'Seleccionar',
                                            'required'
                            ]) !!}
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