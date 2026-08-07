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
                <button type="button" class="btn btn-success" onclick="mostrarNuevaTarea('card-nueva-tarea-mantenimiento')">
                    + Nueva tarea
                </button>
                <div id="card-nueva-tarea-mantenimiento" class="card mb-3 d-none">
                    <div class="card-header">
                        Nueva tarea de mantenimiento preventiva
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Zona --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('id_zona_tarea_nueva', 'Zona de tarea:', [
                                        'class' => 'control-label fs-7'
                                    ]) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select(
                                        'id_zona_tarea_nueva',
                                        $zonas->pluck('nombre_zona', 'id_zona_tarea'),
                                        null,
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => 'Seleccione una zona',
                                            'id' => 'id_zona_tarea_nueva'
                                        ]
                                    ) !!}
                                </div>
                            </div>
                            {{-- Ejecución --}}
                            <div class="col-md-6 d-flex justify-content-between">
                                <div class="form-group" style="90%;">
                                    {!! Form::label('id_ejecucion', 'Ejecución de tarea:') !!}

                                    {!! Form::select('id_ejecucion_nueva', $ejecuciones->pluck('nombre_ejecucion', 'id_ejecucion'), null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Seleccione una ejecución',
                                        'id' => 'id_ejecucion_nueva'
                                    ]) !!}

                                    {!! Form::text('ejecucion_nueva', null, [
                                        'class' => 'form-control mt-2',
                                        'placeholder' => 'Nueva ejecución',
                                        'id' => 'ejecucion_nueva',
                                        'style'=>'display:none;'
                                    ]) !!}
                                </div>

                                <div class="ms-2 mt-4">
                                    <button type="button" class="btn btn-success" onclick="mostrarInputEjecucion()">
                                        +
                                    </button>
                                </div>
                            </div>
                            {{-- Nombre tarea --}}
                            <div class="col-md-12 mt-3">
                                {!! Form::label('nombre_tarea_nueva', 'Nombre tarea:') !!}

                                {!! Form::text('nombre_tarea_nueva', null, [
                                    'class'=>'form-control',
                                    'placeholder'=>'Nombre de la tarea'
                                ]) !!}
                            </div>
                            <div class="col-md-12 mt-3 text-end">
                                <button type="button" class="btn btn-primary" onclick="guardarNuevaTarea()">
                                    Guardar nueva tarea
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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
<div class="modal fade" id="editarTareaPreventivaModal" tabindex="-1" aria-labelledby="editarTareaPreventivaModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Editar Tarea Preventiva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

                {!! Form::open([
                    'method'=>'PUT',
                    'id'=>'formEditarTareaPreventiva'
                ]) !!}
            <div class="modal-body">

                {!! Form::hidden('id_tarea_prev_x_activo', null, ['id'=>'edit_id_tarea_prev_x_activo']) !!}

                <div class="mb-3">
                    <label>Activo</label>
                    <input type="text" 
                           id="edit_nombre_activo" 
                           class="form-control" 
                           readonly>
                </div>

                <div class="mb-3">
                    <label>Tarea</label>
                    <input type="text" 
                           id="edit_nombre_tarea" 
                           class="form-control" 
                           readonly>
                </div>

                <div class="mb-3">
                    {!! Form::label('intervalo_dias','Intervalo días') !!}
                    {!! Form::number('intervalo_dias', null, [
                        'class'=>'form-control',
                        'id'=>'edit_intervalo_dias'
                    ]) !!}
                </div>

                <div class="mb-3">
                    {!! Form::label('cant_golpes','Cantidad golpes') !!}
                    {!! Form::number('cant_golpes', null, [
                        'class'=>'form-control',
                        'id'=>'edit_cant_golpes'
                    ]) !!}
                </div>

                <div class="mb-3">
                    {!! Form::label('fecha_ultima_ejecucion','Última ejecución') !!}
                    {!! Form::date('fecha_ultima_ejecucion', null, [
                        'class'=>'form-control',
                        'id'=>'edit_fecha_ultima_ejecucion'
                    ]) !!}
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    Guardar
                </button>

                <button type="button" 
                        class="btn btn-danger" 
                        data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>