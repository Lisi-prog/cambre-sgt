<td class='text-center chk-input' style="vertical-align: middle;" hidden><input class="form-check-input m-auto" type="checkbox" value="{{$orden->id_orden}}" id="flexCheck{{$orden->id_orden}}" name="id_ordenes[]"></td>

<td class='text-center' style="vertical-align: middle;" data-order="{{$orden->prioridad_servicio ?? 999}}">{{$orden->prioridad_servicio ?? 'S/P'}}</td>

<td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->nombre_servicio ?? '-'}}" style="text-decoration:none; font-variant: none;">{{$orden->codigo_servicio ?? '-'}} <i class="fas fa-eye"></i></abbr></td>

<td class='text-center' style="vertical-align: middle;" hidden>{{$orden->codigo_servicio ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->nombre_orden ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;"><abbr title={{ json_encode($orden->descripcion_etapa) }} style="text-decoration:none; font-variant: none;">{{substr($orden->descripcion_etapa, 0, 20)}} <i class="fas fa-eye"></abbr></td>

<td class= 'text-center' style="vertical-align: middle;">
    <div class="progress position-relative" style="background-color: #b2baf8">
        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$orden->tot_mec_porcentaje}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
            <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$orden->tot_mec_completo}} / {{$orden->tot_mec}}</span>
        </div>
    </div>
</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->nombre_estado ?? ''}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->supervisor ?? '-'}}</td>



<td class='text-center' style="vertical-align: middle;">{{$orden->total_horas ?? '-'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->fecha_limite ? substr($orden->fecha_limite, 0, 10) : '-'}}</td>



<td class='text-center' style="vertical-align: middle;">{{$orden->activo_tabla ? 'SI' : 'NO'}}</td>

<td class='text-center' style="vertical-align: middle;">{{$orden->asignado_tabla}}</td>

<td class='text-center' style="vertical-align: middle;">
    <div class="row justify-content-center" >
        @role('SUPERVISOR')
            <div class="row justify-content-center" >
                <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes{{$orden->id_orden}}" aria-expanded="false" aria-controls="collapseOrdenes{{$orden->id_orden}}">
                    Opciones
                </button>
            </div>
            <div class="collapse" data-bs-parent="#accordion" id="collapseOrdenes{{$orden->id_orden}}">
                @if ($orden->posee_ensamblado)
                    <div class="row my-2">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#activarOrdenManufacturaModal" onclick="cargarModalActivar({{$orden->id_orden}})">
                                Activar
                            </button>
                        </div>
                    </div>
                @endif
                
                <div class="row my-2">
                    <div class="col-12">
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden({{$orden->id_orden}}, {{$tipo_orden}})">
                            Ver
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#verProgOrdenManModal" onclick="cargarModalProgreso({{$orden->id_orden}})">
                            Progreso
                        </button>
                    </div>
                </div>
                
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
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarOrden({{$orden->id_orden}}, '{{$orden->descripcion_etapa}}')">
                            Editar
                        </button> 
                    </div>
                    @endcan
                </div>
                @if ($orden->tiene_mecanizados)
                    <div class="row my-2 justify-content-center">
                        <div class="col-12">
                            <form method="GET" action="{{ route('orden-de-mecanizado') }}" style="display:inline" target="_blank">
                                <input class="input-filter" name="flt_ord" type="hidden" value="{{ $orden->id_manufactura_tabla }}">
                                <button type="submit" class="btn btn-info w-100">Filtro</button>
                            </form>
                        </div>
                    </div>
                @endif
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
