<td class= 'text-center' >{{$orden->nombre_orden}}</td>
<td class= 'text-center' >{{$orden->conjunto_superior ?? '-'}}</td>
<td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->descripcion_etapa ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($orden->descripcion_etapa, 0, 16).'...' ?? "-"}} <i class="fas fa-eye"></i></abbr></td>
<td class= 'text-center' >{{$orden->nombre_estado}}</td>
<td class= 'text-center' style="vertical-align: middle;">
    <div class="progress position-relative" style="background-color: #b2baf8; z-index:1">
        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$orden->tot_mec_porcentaje}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
            <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$orden->tot_mec_completo}} / {{$orden->tot_mec}}</span>
        </div>
    </div>
</td>
<td class= 'text-center' >{{$orden->supervisor}}</td>
<td class= 'text-center' >{{$orden->fecha_limite}}</td>
<td class= 'text-center' >{{$orden->fecha_finalizacion}}</td>
<td class= 'text-center' >{{$orden->horas_estimada ?? '00:00'}}</td>
<td class= 'text-center' >{{$orden->horas_real ?? '00:00'}}</td>
<td>
    <div class="row justify-content-center" >
        <div class="row justify-content-center" >
            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenManufactura{{$orden->id_orden}}" aria-expanded="false" aria-controls="collapseOrdenManufactura{{$orden->id_orden}}">
                Opciones
            </button>
        </div>
        <div class="collapse" data-bs-parent="#cuadro-ordenes-manufactura"id="collapseOrdenManufactura{{$orden->id_orden}}">
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#verProgOrdenManModal" onclick="cargarModalProgreso({{$orden->id_orden}})">
                        Progreso
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarManufactura({{$orden->id_orden}}, {{ json_encode($orden->descripcion_etapa) }})">
                        Editar
                    </button>
                </div>
            </div>
            <div class="row ">
                <div class="col-12">
                    <form method="GET" action="{{ route('ordenes.manufacturamecanizado', $orden->id_orden) }}" style="display:inline">
                        <button type="submit" class="btn btn-success w-100">Agregar mecanizado</button>
                    </form>
                </div>
            </div>
            <div class="row ">
                <div class="col-12">
                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, 2)">
                        Partes
                    </button>
                </div>
            </div>
            <div class="row ">
                <div class="col-12">
                    <form method="GET" action="{{ route('orden.eliminar', $orden->id_orden) }}" style="display:inline" onclick="return confirm('¿Está seguro que desea BORRAR la orden y sus partes?');">
                            <button type="submit" class="btn btn-danger w-100">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</td>
