<div class="modal fade" id="nuevaCausaModal" tabindex="-1" aria-labelledby="nuevaCausaModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Nuevo Diagnóstico</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'ishikawa_causa.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                           {!! Form::label('nombre_causa', 'Nombre diagnóstico:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_causa', null, [
                                'class' => 'form-control reset-input',
                                'required' => 'required',
                                'id' => 'nombre_causa',
                                'autocomplete' => 'off',
                                'style' => 'text-transform: uppercase;'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('ishikawa_categoria', "Categoría:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::select('ishikawa_categoria', $categorias->pluck('nombre_categoria', 'id_ishikawa_categoria'), null, [
                                            'class' => 'form-select form-control',
                                            'id' => 'ishikawa_categoria',
                                            'placeholder' => 'Seleccionar',
                                            'required'
                            ]) !!}                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                           {!! Form::label('explicacion_causa', 'Explicación diagnóstico:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::textarea('explicacion_causa', null, [
                                'class' => 'form-control reset-input',
                                'id' => 'explicacion_causa',
                                'rows' => 3,
                                'autocomplete' => 'off',
                                'style' => 'text-transform: uppercase; resize:none; width: 100%; height: 10vh;'
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