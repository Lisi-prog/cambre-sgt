<!-- Modal -->
<div class="modal fade" id="editarProyectoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Proyecto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::model($proyecto, ['method' => 'PUT', 'route' => ['proyectos.update', $proyecto->id_servicio], 'class' => '']) !!}

            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="form-group">
                            {!! Form::label('codigo_proyecto', 'Codigo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('codigo_proyecto', $proyecto->codigo_servicio, [
                                'class' => 'form-control',
                                'required' => 'required',
                                'id' => 'codigo_proyecto'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('id_tipo_proyecto', 'Tipo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('id_tipo_proyecto', $Tipos_servicios, $proyecto->getSubTipoServicio->id_subtipo_servicio, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select',
                                'id' => 'id_tipo_proyecto',
                                'required'
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('nombre', "Nombre proyecto:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_proyecto', $proyecto->nombre_servicio, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('lider', 'Lider:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                {!! Form::select('lider', $empleados, $proyecto->getResponsabilidad->getEmpleado->id_empleado, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select',
                                    'id' => 'lider',
                                    'required'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('fec_ini', 'Fecha inicio:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                            {!! Form::date('fecha_ini', $proyecto->fecha_inicio, [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fec_ini',
                                'class' => 'form-control',
                                'required'
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>