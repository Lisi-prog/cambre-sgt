<div class="modal fade" id="nuevaTareaModal" tabindex="-1" aria-labelledby="nuevaTareaModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Nueva Tarea de Mantenimiento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'tarea_mantenimiento.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            {!! Form::label('codigo_tarea', 'Código:', ['class' => 'control-label fs-7']) !!}
                            {!! Form::text('codigo_tarea', null, ['class' => 'form-control', 'id' => 'codigo_tarea', 'placeholder' => 'Se genera al guardar', 'disabled' => true]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                           {!! Form::label('nombre_tarea', 'Nombre tarea:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_tarea', null, [
                                'class' => 'form-control reset-input',
                                'required' => 'required',
                                'id' => 'nombre_tarea',
                                'autocomplete' => 'off'
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group form-check">
                            {!! Form::hidden('en_uso', 0) !!}
                            {!! Form::checkbox('en_uso', 1, true, ['class' => 'form-check-input', 'id' => 'en_uso']) !!}
                            {!! Form::label('en_uso', 'En uso', ['class' => 'form-check-label']) !!}
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
