@if ($esPropietario || Auth::user()->hasRole('SUPERVISOR'))
    <div class="row justify-content-center">
        <div class="row justify-content-center" >
            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePM{{$Pm->id_propuesta_de_mejora}}" aria-expanded="false" aria-controls="collapsePM{{$Pm->id_propuesta_de_mejora}}">
                Opciones
            </button>
        </div>
        <div class="collapse" data-bs-parent="#accordionPm" id="collapsePM{{$Pm->id_propuesta_de_mejora}}">
            <div class="row my-2">
                <div class="col-12">
                    @if ($Pm->getSolicitud->id_estado_solicitud >= $id_estado_aceptado)
                        <form method="GET" action="{{ route('p_m.show', $Pm->id_propuesta_de_mejora) }}" style="display:inline">
                        <button type="submit" class="btn btn-primary w-100">Ver</button>
                        </form>
                    @else
                        @can('EVALUAR-SOLICITUD')
                            <form method="GET" action="{{ route('pm.evaluar', $Pm->id_propuesta_de_mejora) }}" style="display:inline">
                            <button type="submit" class="btn btn-success w-100">Evaluar</button>
                            </form>
                        @endcan
                    @endif
                </div>
            </div> 

            <div class="row my-2">
                @if ($Pm->getSolicitud->id_estado_solicitud >= $id_estado_aceptado && $Pm->getSolicitud->id_estado_solicitud != 3)
                    <div class="col-12">
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#avanceProyectoModal" onclick="cargarModalProgresoServicio({{$Pm->getSolicitud->id_solicitud}})">
                        Avance
                        </button>
                    </div>
                @endif
            </div> 
            <div class="row my-2">
                @if (Auth::user()->hasRole('SUPERVISOR'))
                    <div class="col-12">
                        <form method="GET" action="{{ route('p_m.edit', $Pm->id_propuesta_de_mejora) }}" style="display:inline">
                        <button type="submit" class="btn btn-warning w-100">Editar</button>
                        </form>
                    </div>
                @else
                    @if ($esPropietario && $Pm->getSolicitud->id_estado_solicitud < $id_estado_aceptado)
                        <form method="GET" action="{{ route('p_m.edit', $Pm->id_propuesta_de_mejora) }}" style="display:inline">
                        <button type="submit" class="btn btn-warning w-100">Editar</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
@else
    -
@endif
