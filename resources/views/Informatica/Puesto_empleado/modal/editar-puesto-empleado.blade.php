<!-- Modal -->
<div class="modal fade" id="editarPuestoEmpleadoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar puesto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'puesto_empleado.editar', 'method' => 'GET', 'class' => 'formulario']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('nombre_puesto_empleado', "Nombre del Titulo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_puesto_empleado', null, ['class' => 'form-control', 'required', 'id' => 'input_puesto']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        {{-- <div class="form-group">
                            {!! Form::label('nombre_puesto_empleado', "Nombre del Titulo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_puesto_empleado', null, ['class' => 'form-control']) !!}
                        </div> --}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="form-group">
                            {!! Form::label('costo_hora', "Costo por hora:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input id="input-costo_hora" type="text" class="form-control" name="costo_hora" required data-type="currency">
                            </div>
                            {{-- {!! Form::text('costo_hora', null, ['class' => 'form-control']) !!} --}}
                        </div>
                    </div>
                    <div hidden>
                        <input class="form-control" name="id_puesto" required value=1 id="input_id_puesto">
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

