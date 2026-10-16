<td class= 'text-center' >{{$orden->nombre_orden}}</td>
<td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->descripcion_etapa ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($orden->descripcion_etapa, 0, 16).'...' ?? "-"}} <i class="fas fa-eye"></i></abbr></td>
<td class= 'text-center' >{{$orden->nombre_estado}}</td>
<td class= 'text-center' >{{$orden->supervisor}}</td>
<td class= 'text-center' >{{$orden->responsable}}</td>
<td class= 'text-center' >{{$orden->fecha_limite}}</td>
<td class= 'text-center' >{{$orden->fecha_finalizacion}}</td>
<td class= 'text-center' >{{$orden->horas_estimada}}</td>
<td class= 'text-center' >{{$orden->horas_real}}</td>
<td>
    <div class="row justify-content-center" >
        <div class="row justify-content-center" >
            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenTrabajo{{$orden->id_orden}}" aria-expanded="false" aria-controls="collapseOrdenTrabajo{{$orden->id_orden}}">
                Opciones
            </button>
        </div>
        <div class="collapse" data-bs-parent="#cuadro-ordenes-trabajo" id="collapseOrdenTrabajo{{$orden->id_orden}}">
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarTrabajo({{$orden->id_orden}}, {{ json_encode($orden->descripcion_etapa) }})">
                        Editar
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, 1)">
                        Partes
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form method="GET" action="{{ route('orden.eliminar', $orden->id_orden) }}" style="display:inline" onclick="return confirm('¿Está seguro que desea BORRAR la orden y sus partes?');">
                            <button type="submit" class="btn btn-danger w-100">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</td>
