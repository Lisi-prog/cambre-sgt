
                                                <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRI{{$Ri->id_requerimiento_de_ingenieria}}" aria-expanded="false" aria-controls="collapseRI{{$Ri->id_requerimiento_de_ingenieria}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseRI{{$Ri->id_requerimiento_de_ingenieria}}">
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                @if ($Ri->getSolicitud->id_estado_solicitud >= $id_estado_aceptado)
                                                                    <form method="GET" action="{{ route('r_i.show', $Ri->id_requerimiento_de_ingenieria) }}" style="display:inline">
                                                                    <button type="submit" class="btn btn-primary w-100">Ver</button>
                                                                    </form>
                                                                @else
                                                                    @can('EVALUAR-SOLICITUD')
                                                                        <form method="GET" action="{{ route('ri.evaluar', $Ri->id_requerimiento_de_ingenieria) }}" style="display:inline">
                                                                        <button type="submit" class="btn btn-success w-100">Evaluar</button>
                                                                        </form>
                                                                    @endcan
                                                                @endif
                                                            </div>
                                                        </div> 
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                <form method="GET" action="{{ route('r_i.edit', $Ri->id_requerimiento_de_ingenieria) }}" style="display:inline">
                                                                <button type="submit" class="btn btn-warning w-100">Editar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>