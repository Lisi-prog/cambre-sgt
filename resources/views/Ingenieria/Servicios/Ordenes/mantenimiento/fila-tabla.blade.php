<td class='text-center' style="vertical-align: middle;" data-order="{{$orden->prioridad_servicio ?? 999}}">{{$orden->prioridad_servicio ?? 'S/P'}}</td>

<td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->nombre_servicio ?? '-'}}" style="text-decoration:none; font-variant: none;">{{$orden->codigo_servicio ?? '-'}} <i class="fas fa-eye"></i></abbr></td>

<td class='text-center' style="vertical-align: middle;" hidden>{{$orden->codigo_servicio ?? '-'}}</td>

<td class='text-start' style="vertical-align: middle;">{{$orden->nombre_orden ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{ $orden->nombre_tipo_orden_mantenimiento ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{ $orden->codigo_activo ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->nombre_estado ?? ''}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->nombre_empleado_asignado ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->horas ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->fecha_finalizacion ? substr($orden->fecha_finalizacion, 0, 10) : '-'}}</td>

<td class='text-center' style="vertical-align: middle;">
    <div class="row justify-content-center" >
        <div class="row justify-content-center" >
            <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenesMan{{$orden->id_orden}}" aria-expanded="false" aria-controls="collapseOrdenesMan{{$orden->id_orden}}">
                Opciones
            </button>
        </div>
        <div class="collapse" data-bs-parent="#accordion" id="collapseOrdenesMan{{$orden->id_orden}}">
            <div class="row">
                @switch($orden->nombre_tipo_orden_mantenimiento)
                    @case('DIAGNÓSTICO')
                        
                        <div class="col-12 mt-1">                               
                            <a target="_blank" href="{{ route('servicio_mantenimiento.gestionar', $orden->id_servicio) }}" type="button" class="btn btn-warning w-100">
                                Ir a gestionar
                            </a>
                        </div>
                        @break
                    @case('INSPECCIÓN')
                        
                        <div class="col-12 mt-1">                               
                            <a target="_blank" href="{{ route('servicio_mantenimiento.gestionar', $orden->id_servicio) }}" type="button" class="btn btn-warning w-100">
                                Ir a gestionar
                            </a>
                        </div>
                        @break
                    @case('AJUSTE')
                    @case('TAREA MANTENIMIENTO')
                        
                        <div class="col-12 mt-1">                               
                            <a target="_blank" href="{{ route('servicio_mantenimiento.gestionar', $orden->id_servicio) }}" type="button" class="btn btn-warning w-100">
                                Ir a gestionar
                            </a>
                        </div>
                        @break
                    @default
                        
                @endswitch
            </div>
        </div>
    </div>
</td>
