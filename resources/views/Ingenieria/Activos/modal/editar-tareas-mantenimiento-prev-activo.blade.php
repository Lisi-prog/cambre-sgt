<div class="modal fade" id="editarTareasMantenimientoPreventivaModal" tabindex="-1" aria-labelledby="editarTareasMantenimientoModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar Tareas de Mantenimiento Preventivas del Activo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'activo.set_tareas_mantenimiento_preventiva', 'method' => 'PUT', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <h5>Tareas Disponibles</h5>
                <button type="button" class="btn btn-success" onclick="mostrarNuevaTarea('card-nueva-tarea')">
                    + Nueva tarea
                </button>
                <div id="card-nueva-tarea" class="card mb-3 d-none">
                    <div class="card-header">
                        Nueva tarea de mantenimiento preventiva
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Nombre tarea --}}
                            <div class="col-md-12 mt-3">
                                {!! Form::label('nombre_tarea_nueva_m', 'Nombre tarea:') !!}

                                {!! Form::text('nombre_tarea_nueva_m', null, [
                                    'class'=>'form-control',
                                    'placeholder'=>'Nombre de la tarea'
                                ]) !!}
                            </div>
                            <div class="col-md-12 mt-3 text-end">
                                <button type="button" class="btn btn-primary" onclick="guardarNuevaTarea(this)">
                                    Guardar nueva tarea
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="tabla_set_tareas_mantenimiento_preventivas" class="table table-striped">
                    <thead>
                        <th class='text-center' style="color:#fff;">Asignar</th>
                        <th class='text-center' style="color:#fff;">Tarea</th>
                        <th class='text-center' style="color:   #fff;">Intervalo</th>
                        <th class='text-center' style="color:#fff;">Cantidad de Golpes</th>
                        <th class='text-center' style="color:#fff;">Fecha Última Ejecución</th>
                    </thead>
                    <tbody>                    
                        @foreach($activo->getTareasMantenimientoSinUsarPreventiva() as $tarea_mantenimiento_disponible)
                            <tr>
                                <td>
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
                                </td>
                                <td>
                                    <div class="form-check">
                                        {!! Form::label('tarea_mantenimiento_'.$tarea_mantenimiento_disponible->id_tarea_mantenimiento, $tarea_mantenimiento_disponible->nombre_tarea, ['class' => 'form-check-label']) !!}
                                    </div>
                                </td>
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