<div class="modal fade" id="editarTareasMantenimientoModal" tabindex="-1" aria-labelledby="editarTareasMantenimientoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar Tareas de Mantenimiento del Activo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'activo.set_tareas_mantenimiento', 'method' => 'PUT', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <h5>Tareas Disponibles</h5>
                <table id="tabla_set_tareas_mantenimiento" class="table table-striped">
                    <thead>
                        <th class='text-center' style="color:#fff;">Asignar</th>
                        <th class='text-center' style="color:#fff;">Tarea</th>
                        <th class='text-center' style="color:#fff;">Ejecución</th>
                        <th class='text-center' style="color:#fff;">Zona</th>
                    </thead>
                    <tbody>                    
                        @foreach($activo->getTareasMantenimientoSinUsar() as $tarea_mantenimiento_disponible)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        {!! Form::checkbox('tareas_mantenimiento[]', $tarea_mantenimiento_disponible->id_tarea_mantenimiento, false, ['class' => 'form-check-input', 'id' => 'tarea_mantenimiento_'.$tarea_mantenimiento_disponible->id_tarea_mantenimiento]) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        {!! Form::label('tarea_mantenimiento_'.$tarea_mantenimiento_disponible->id_tarea_mantenimiento, $tarea_mantenimiento_disponible->nombre_tarea, ['class' => 'form-check-label']) !!}
                                    </div>
                                </td>
                                <td>{{$tarea_mantenimiento_disponible->getEjecucion->nombre_ejecucion}}</td>
                                <td>{{$tarea_mantenimiento_disponible->getZonaTarea->nombre_zona}}</td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
                {!! Form::hidden('id_activo', $activo->id_activo) !!}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>