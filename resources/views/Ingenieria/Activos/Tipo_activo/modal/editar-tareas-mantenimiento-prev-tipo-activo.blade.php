<div class="modal fade" id="editarTareasMantenimientoPreventivasModal" tabindex="-1" aria-labelledby="editarTareasMantenimientoModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar Tareas de Mantenimiento Preventivas del Tipo de Activo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'tipo_activo.set_tareas_mantenimiento_preventivas', 'method' => 'PUT', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <h5>Tareas Disponibles</h5>
                <table id="tabla_set_tareas_mantenimiento_preventivas" class="table table-striped">
                    <thead>
                        <th class='text-center' style="color:#fff;">Asignar</th>
                        <th class='text-center' style="color:#fff;">Tarea</th>
                        <th class='text-center' style="color:#fff;">Ejecución</th>
                        <th class='text-center' style="color:#fff;">Zona</th>
                        <th class='text-center' style="color:#fff;">Intervalo</th>
                        <th class='text-center' style="color:#fff;">Cantidad de Golpes</th>
                        <th class='text-center' style="color:#fff;">Última Ejecución</th>
                    </thead>
                    <tbody>                    
                        @foreach($ta->getTareasMantenimientoSinUsarPreventiva() as $tarea_mantenimiento_disponible)
                            <tr>
                                <td>
                                    <div class="form-check">
                                       <div class="form-check">
                                        {!! Form::checkbox(
                                                'tareas_mantenimiento[]',
                                                $tarea_mantenimiento_disponible->id_tarea_mantenimiento,
                                                false,
                                                [
                                                    'class' => 'form-check-input check-tarea',
                                                    'data-id' => $tarea_mantenimiento_disponible->id_tarea_mantenimiento
                                                ]
                                            ) !!}
                                    </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        {!! Form::label('tarea_mantenimiento_'.$tarea_mantenimiento_disponible->id_tarea_mantenimiento, $tarea_mantenimiento_disponible->nombre_tarea, ['class' => 'form-check-label']) !!}
                                    </div>
                                </td>
                                <td>{{$tarea_mantenimiento_disponible->getEjecucion->nombre_ejecucion}}</td>
                                <td>{{$tarea_mantenimiento_disponible->getZonaTarea->nombre_zona}}</td>
                                <td>
                                    {!! Form::number('duracion_'.$tarea_mantenimiento_disponible->id_tarea_mantenimiento, null, [
                                        'class' => 'form-control input-tarea w-100',
                                        'data-id' => $tarea_mantenimiento_disponible->id_tarea_mantenimiento,
                                        'placeholder' => 'Días',
                                        'disabled'
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::number('cant_golpes_'.$tarea_mantenimiento_disponible->id_tarea_mantenimiento, null, [
                                        'class' => 'form-control input-tarea w-100',
                                        'data-id' => $tarea_mantenimiento_disponible->id_tarea_mantenimiento,
                                        'placeholder' => 'Golpes',
                                        'disabled'
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::date('fecha_ultima_ejecucion_'.$tarea_mantenimiento_disponible->id_tarea_mantenimiento, null, [
                                        'class' => 'form-control input-tarea w-100',
                                        'data-id' => $tarea_mantenimiento_disponible->id_tarea_mantenimiento,
                                        'placeholder' => 'Fecha',
                                        'disabled'
                                    ]) !!}
                                </td>

                            </tr>
                        @endforeach 
                    </tbody>
                </table>
                {!! Form::hidden('id_tipo_activo', $ta->id_tipo_activo) !!}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>