<!-- Modal -->
<div class="modal fade" id="modificarPrioridadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar prioridad del proyecto.</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'proyectos.cambiarprioridad', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}

            <div class="modal-body">
                <div class="row">
                    {!! Form::text('id_proyecto', null, ['class' => 'form-control', 'id' => 'id_proyecto', 'hidden']) !!}
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('codigo_proyecto', 'Codigo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('codigo_proyecto', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                                'id' => 'm-codigo_proyecto',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('nombre_proyecto', 'Nombre:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_proyecto', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                                'id' => 'm-nombre_proyecto',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('prioridad', 'Prioridad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                {!! Form::number('prioridad', null, [
                                'class' => 'form-control',
                                'min' => 1,
                                'required' => 'required',
                                'id' => 'num_prioridad'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('motivo', 'Motivo del cambio:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            <textarea name='motivo' id="id_motivo" class="form-control" rows="54" cols="54" style="resize:none; height: 15vh" required></textarea>
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