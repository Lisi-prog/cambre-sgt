<!-- Modal -->
<div class="modal fade" id="verOrdenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ver Orden</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('orden', "Orden:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nom_orden', null, ['class' => 'form-control', 'id' => 'input-orden', 'readonly']) !!}
                            {{-- <input class="form-control" name="nom_orden" type="text"> --}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('tipo', "Tipo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('tipo', null, ['class' => 'form-control', 'id' => 'input-tipo', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('estado', null, ['class' => 'form-control', 'id' => 'input-estado', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::label('responsable', "Responsable:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('responsable', null, ['class' => 'form-control', 'id' => 'input-responsable', 'readonly']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('fecha_inicio', "Fecha inicio:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('fecha_inicio', null, ['class' => 'form-control', 'id' => 'input-fec_ini', 'readonly']) !!}
                        </div>                        
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('fecha_limite', "Fecha limite:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('fecha_limite', null, ['class' => 'form-control', 'id' => 'input-fec_limite', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('fecha_fin_real', "Fecha fin:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('fecha_inicio', null, ['class' => 'form-control', 'id' => 'input-fec_fin', 'readonly']) !!}
                        </div> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        {{-- <div class="form-group">
                            {!! Form::label('fecha_inicio', "Fecha inicio:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('fecha_inicio', null, ['class' => 'form-control', 'id' => 'input-fec_ini', 'readonly']) !!}
                        </div>                         --}}
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('duracion_estimada', "Duracion estimada:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('duracion_estimada', null, ['class' => 'form-control', 'id' => 'input-duracion_estimada', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('duracion_real', "Duracion real:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('duracion_real', null, ['class' => 'form-control', 'id' => 'input-duracion_real', 'readonly']) !!}
                        </div> 
                    </div>
                </div>

                <div class="row">
                    {!! Form::label('ultimo_parte', "Ultimo parte:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('fecha_ultimo_parte', "Fecha:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('fecha_ultimo_parte', null, ['class' => 'form-control', 'id' => 'input-fecha_ultimo_parte', 'readonly']) !!}
                        </div> 
                    </div>
                    <div class="col-9">
                        <div class="form-group">
                            {!! Form::label('observacion', "Observacion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('observacion', null, ['class' => 'form-control', 'id' => 'input-observacion', 'readonly']) !!}
                        </div> 
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('supervisor', "Supervisor:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('supervisor', null, ['class' => 'form-control', 'id' => 'input-supervisor', 'readonly']) !!}
                        </div> 
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">Guardar</button> --}}
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>