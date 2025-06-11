<!-- Modal -->
<div class="modal fade" id="nuevoActivoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo activo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'activos.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('codigo_activo', 'Codigo activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('codigo_activo', null, [
                                'class' => 'form-control reset-input',
                                'required' => 'required',
                                'style' => 'text-transform:uppercase',
                                'id' => 'codigo_activo'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('nombre_activo', 'Nombre activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_activo', null, [
                                'class' => 'form-control reset-input',
                                'required' => 'required',
                                'id' => 'nombre_activo'
                            ]) !!}
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('descripcion', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <textarea name='descripcion' id="descripcion" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('tipo_activo', "Tipo Activo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('tipo_activo', $tipos_activo, null, [
                                            'class' => 'form-select form-control',
                                            'id' => 'tip_act',
                                            'placeholder' => 'Seleccionar'
                                        ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('est_act', "¿Esta Activo?:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('esta_activo', [0 => 'NO', 1 => 'SI'], 1, [
                                                    'class' => 'form-select form-control',
                                                    'id' => 'est_act',
                                                    'required'
                                                ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('opciones', "Opciones:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value=1 id="checkCheckedOpt" checked name="opt_nsa">
                                <label class="form-check-label" for="checkCheckedOpt">
                                    Crear Servicio de Activo
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