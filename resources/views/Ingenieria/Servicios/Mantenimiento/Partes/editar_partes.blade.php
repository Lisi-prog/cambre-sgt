<div class="modal fade" id="editarPartes" tabindex="-1" aria-labelledby="editarPartes" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar Parte</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                
            </div>            
            {!! Form::open(['route' => 'orden_mantenimiento.editar', 'method' => 'PUT']) !!}
            <div class="modal-body">    
                <input name="id_orden" type="text" hidden id="id_orden_editar">
                <div class="d-flex">
                    <div class="col-lg-8s">
                        <p>La orden de mantenimiento se encuentra...</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-check form-switch">
                            <input name="activo" class="form-check-input" type="checkbox" id="activo_editar" checked>
                            <label class="form-check-label" for="activo_editar" id="label_activo_editar">Activa</label>
                        </div>    
                    </div>
                </div>
                <hr>
                <label for="id_editar_empleado">Técnico Asignado: </label>
                <select name="id_empleado" class="form-select" id="id_editar_empleado">
                    <option value="">SIN ASIGNAR</option>
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->id_empleado }}">{{ $empleado->nombre_empleado }}</option>
                    @endforeach
                </select>                            
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Editar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
