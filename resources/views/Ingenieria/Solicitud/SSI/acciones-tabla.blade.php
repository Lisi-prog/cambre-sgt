@if ($esAdmin || $esTecnico || ($esExterno && $idEmpleado !== null && $Ssi->getSolicitud->id_empleado == $idEmpleado))
    <div class="row justify-content-center">
        <div class="row justify-content-center" >
            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSSI{{$Ssi->id_servicio_de_ingenieria}}" aria-expanded="false" aria-controls="collapseSSI{{$Ssi->id_servicio_de_ingenieria}}">
                Opciones
            </button>
        </div>
        <div class="collapse" data-bs-parent="#accordion" id="collapseSSI{{$Ssi->id_servicio_de_ingenieria}}">
            <div class="row my-2">
                <div class="col-12">
                    <form method="GET" action="{{ route('s_s_i.show', $Ssi->id_servicio_de_ingenieria) }}" style="display:inline">
                        <button type="submit" class="btn btn-primary w-100">Ver</button>
                    </form>
                </div>
            </div>
            @if ($esAdmin && $Ssi->getSolicitud->id_estado_solicitud < $id_estado_aceptado)
                <div class="row my-2">
                    <div class="col-12">
                        <form method="GET" action="{{ route('ssi.evaluar', $Ssi->id_servicio_de_ingenieria) }}" style="display:inline">
                            <button type="submit" class="btn btn-success w-100">Evaluar</button>
                        </form>
                    </div>
                </div>
            @endif
            <div class="row my-2">
                @if ($Ssi->getSolicitud->id_estado_solicitud >= $id_estado_aceptado)
                    <div class="col-12">
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#avanceProyectoModal" onclick="cargarModalProgresoServicio({{$Ssi->getSolicitud->id_solicitud}})">
                        Avance
                        </button>
                    </div>
                @endif
            </div> 
            <div class="row my-2">
            </div>
        </div>
    </div>
@else
    -
@endif
