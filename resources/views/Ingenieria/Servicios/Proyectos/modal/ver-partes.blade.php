<!-- Modal -->
<div class="modal fade" id="verPartesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ver Partes</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="modal-body-ver-partes">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <label for="mv-orden" class="control-label fs-7" style="white-space: nowrap;">Orden:</label>
                            <input type="text" name="orden" id="mv-orden" value="{{ old('orden') }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            <label for="mv-estado" class="control-label fs-7" style="white-space: nowrap;">Estado:</label>
                            <input type="text" name="estado" id="mv-estado" value="{{ old('estado') }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <label for="mv-etapa" class="control-label fs-7" style="white-space: nowrap;">Etapa:</label>
                            <input type="text" name="etapa" id="mv-etapa" value="{{ old('etapa') }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                    <div class="table-responsive tableFixHead">
                        <table class="table table-striped table-sm" id="verPartes" >
                            <thead id="encabezado_tabla_parte" style="background: #558540">
                                <th class="text-center" scope="col" style="color:#fff;">Cod.</th>
                                <th class="text-center" scope="col" style="color:#fff;">Fecha</th>
                                <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                                <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                <th class="text-center" scope="col" style="color:#fff;">Horas</th>
                                <th class="text-center" scope="col" style="color:#fff;">Observaciones</th>
                                <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                <th id="column-maq" class="text-center" scope="col" style="color:#fff;" hidden>Maquina</th>
                                <th id="column-hora-maq" class="text-center" scope="col" style="color:#fff;" hidden>Hora maquina</th>
                                <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                                <th class="text-center" scope="col" style="color:#fff;">Acciones</th>
                            </thead>
                            <tbody id="body_ver_parte">

                            </tbody>
                        </table>
                    </div>
                <div class="row mb-2">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 my-2">
                        <button type="button" class="btn btn-warning" onclick="nuevoParte()">Nuevo parte</button>
                    </div>
                </div>             
                <div class="row rounded border border-3 border-warning" id="m-ver-parte-div">
                    <h5 class="text-center control-label pt-2" id="titulo-parte">Nuevo parte</h5>
                    <form action="{{ route('partes.guardar.act') }}" method="POST" class="formulario form-prevent-multiple-submits-3sec nuevo-editar-parte" id="form-nuevo-parte">
                        @csrf
                    <input type="hidden" name="id_orden" id="m-ver-parte-orden" value="{{ old('id_orden') }}" class="form-control">
                    <input type="hidden" name="id_parte" id="m-id-parte" value="{{ old('id_parte') }}" class="form-control">
                    <input type="hidden" name="editar" id="m-editar" value="{{ old('editar', 0) }}" class="form-control">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group" >
                                <label for="observaciones" class="control-label fs-7" style="white-space: nowrap;">Observaciones:</label>
                                <span class="obligatorio">*</span>
                                <textarea name='observaciones' id="observaciones" maxlength="500" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh"  required>{{ old('observaciones') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <label for="m-ver-parte-estado" class="control-label fs-7" style="white-space: nowrap;">Estado:</label>
                            <span class="obligatorio">*</span>
                            <select class="form-select" id="m-ver-parte-estado" name="estado">
                                <option selected="selected" value="">Seleccionar</option>
                            </select>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label for="m-ver-parte-fecha-limite" class="control-label fs-7" style="white-space: nowrap;">Fecha limite:</label>
                                @role('SUPERVISOR')
                                    <input type="date" name="fecha_limite" id="m-ver-parte-fecha-limite" value="{{ old('fecha_limite') }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control">
                                @else
                                    <input type="date" name="fecha_limite" id="m-ver-parte-fecha-limite" value="{{ old('fecha_limite') }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control" readonly>
                                @endrole
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label for="fecha" class="control-label fs-7" style="white-space: nowrap;">Fecha:</label>
                                            <span class="obligatorio">*</span>
                                <input type="date" name="fecha" id="fecha" value="{{ old('fecha', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group"> 
                                <label for="horas" class="control-label" style="white-space: nowrap; ">Horas hombre:</label> 
                                <span class="obligatorio">*</span> 
                                <div class= "input-group">
                                    <input class="form-control" name="horas" type="number" min="0" value="00" id="horas" required>
                                    <span class="input-group-text">:</span>
                                    <input class="form-control" name="minutos" type="number" min="0" max="59" value="00" id="minutos" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="m-ver-parte-maquinaria">

                    </div>
                    </form>
                </div>
            </div>

            <div id="alert" class="mx-3">
                
            </div>

            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">Guardar</button> --}}
                <button type="submit" class="btn btn-success button-prevent-multiple-submits-3sec" id="m-ver-parte-orden-btn" form="form-nuevo-parte">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            
            {{-- <div class="alert alert-success alert-dismissible fade show " role="alert">
                'Parte creado con exito'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}
        </div>
    </div>
</div>