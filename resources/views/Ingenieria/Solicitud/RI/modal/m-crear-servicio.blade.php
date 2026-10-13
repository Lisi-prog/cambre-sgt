<!-- Modal -->
<div class="modal fade" id="crearServicioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Servicio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('solicitud.aceptar', ['id' => $Req_ing->getSolicitud->id_solicitud, 'opcion' => 3]) }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="prefijo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Prefijo proyecto:</label>
                            <select name="prefijo_proyecto" id="prefijo_proyecto" class="form-select form-control">
                                <option value="" {{ old('prefijo_proyecto', null) === null || old('prefijo_proyecto', null) === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($prefijos as $valor => $etiqueta)
                                    <option value="{{ $valor }}" {{ (string) old('prefijo_proyecto', null) === (string) $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            <label for="codigo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Codigo proyecto:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="codigo_proyecto" id="codigo_proyecto" value="{{ old('codigo_proyecto') }}" class="form-control" style="text-transform:uppercase" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            <label for="nombre_proyecto" class="control-label" style="white-space: nowrap;">Nombre proyecto:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="{{ old('nombre_proyecto', $Req_ing->titulo_propuesta) }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="id_tipo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Tipo:</label>
                            <span class="obligatorio">*</span>
                            <select name="id_tipo_proyecto" id="id_tipo_proyecto" class="form-select form-control" required>
                                <option value="" {{ old('id_tipo_proyecto', null) === null || old('id_tipo_proyecto', null) === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($Tipos_servicios as $valor => $etiqueta)
                                    <option value="{{ $valor }}" {{ (string) old('id_tipo_proyecto', null) === (string) $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="lider" class="control-label fs-7" style="white-space: nowrap;">Lider:</label>
                                <span class="obligatorio">*</span>
                                <select name="lider" id="lider" class="form-select form-control">
                                <option value="" {{ old('lider', null) === null || old('lider', null) === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($empleados as $valor => $etiqueta)
                                    <option value="{{ $valor }}" {{ (string) old('lider', null) === (string) $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="id_activo" class="control-label fs-7" style="white-space: nowrap;">Activo:</label>
                                <select name="id_activo" id="id_activo" class="form-select form-control">
                                <option value="" {{ old('id_activo', $Req_ing->id_activo) === null || old('id_activo', $Req_ing->id_activo) === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($activos as $valor => $etiqueta)
                                    <option value="{{ $valor }}" {{ (string) old('id_activo', $Req_ing->id_activo) === (string) $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            <label for="prioridad" class="control-label fs-7" style="white-space: nowrap;">Prioridad:</label>
                            <span class="obligatorio">*</span>
                            
                            <input type="text" name="prioridad" id="prioridad" value="{{ old('prioridad', $prioridadMax) }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <label for="fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
                                        <span class="obligatorio">*</span>
                            <input type="date" name="fecha_ini" id="fec_ini" value="{{ old('fecha_ini', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
                            <span class="obligatorio">*</span>
                            <input type="date" name="fecha_req" id="fec_req" value="{{ old('fecha_req', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Aceptar y crear servicio</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Solicitud/buscar-prefijo.js') }}"></script>
