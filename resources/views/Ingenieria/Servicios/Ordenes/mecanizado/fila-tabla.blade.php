<td hidden class="chk-input" style="vertical-align: middle; padding: 0;">
    <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
        <input class="form-check-input" type="checkbox" value="{{$orden->id_orden}}" id="flexCheck{{$orden->id_orden}}" name="id_ordenes[]">
    </div>
</td>

<td class='text-center' style="vertical-align: middle;" data-order="{{$orden->prioridad_servicio ?? 999}}">{{$orden->prioridad_servicio ?? 'S/P'}}</td>

<td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->nombre_servicio ?? '-'}}" style="text-decoration:none; font-variant: none;">{{$orden->codigo_servicio ?? '-'}} <i class="fas fa-eye"></i></abbr></td>

<td class='text-center' style="vertical-align: middle;" hidden>{{$orden->codigo_servicio ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->nombre_orden ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->manufactura ?? '-'}}</td>

<td class= 'text-center' style="vertical-align: middle;">
    <div class="progress position-relative" style="background-color: #b2baf8">
        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$orden->getProgreso()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
            <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$orden->total_ope_completo.'/'.$orden->total_ope}}</span>
        </div>
    </div>
</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->nombre_estado ?? ''}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->ope_act ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->nom_est_ope_act ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->fecha_limite ? substr($orden->fecha_limite, 0, 10) : '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->total_horas_hdr ?? '00:00'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->cantidad ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;" hidden>{{$orden->responsable ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">
    <div class="row justify-content-center" >
        @role('SUPERVISOR')
            <div class="row justify-content-center" >
                <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes{{$orden->id_orden}}" aria-expanded="false" aria-controls="collapseOrdenes{{$orden->id_orden}}">
                    Opciones
                </button>
            </div>
            <div class="collapse" data-bs-parent="#accordion" id="collapseOrdenes{{$orden->id_orden}}">
                <div class="row my-2">
                    <div class="col-12">
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden({{$orden->id_orden}}, {{$tipo_orden}})">
                            Ver
                        </button>
                    </div>
                </div>

                @if ($tipo_orden === 3)
                    <div class="row my-2">
                        <div class="col-12">
                            <form method="GET" action="{{ route('ordenes.hdr', $orden->id_orden) }}" style="display:inline">
                                <input type="hidden" name="vieneDesde" value="2" class="form-control">
                                <button type="submit" class="btn btn-info w-100">HDR</button>
                            </form>
                        </div>
                    </div>
                @endif
                
                <div class="row my-2">
                    <div class="col-12">
                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, {{$tipo_orden}})">
                            Partes
                        </button>
                    </div>
                </div>
                <div class="row my-2">
                    @can('EDITAR-ORDENES')
                    <div class="col-12">
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarOrden({{$orden->id_orden}}, {{ json_encode($orden->descripcion_etapa) }})">
                            Editar
                        </button> 
                    </div>
                    @endcan
                </div>
                <div class="row my-2">
                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        @if ($orden->id_estado_mecanizado != 4 )
                            <button type="button" class="btn btn-warning" onclick="crearParteOrdMecEspera({{$orden->id_orden}})">Espera</button>
                        @endif

                        @if ($orden->id_estado_mecanizado != 5 )
                        <button type="button" class="btn btn-info" onclick="crearParteOrdMecEnProceso({{$orden->id_orden}})">En proceso</button>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="row my-2">
                <div class="col-12">
                    <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden({{$orden->id_orden}}, {{$tipo_orden}})">
                        Ver
                    </button>
                </div>
            </div>
        @endrole
        
    </div>
</td>
