<!-- Modal -->
<div class="modal fade" id="crearSSIModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Solicitud de Servicio de Ingenieria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pb-0">
                <div class="row">
                    <form class="formulario form-prevent-multiple-submits" enctype="multipart/form-data" action="{{route('s_s_i.store')}}" method="POST"> 
                    @csrf
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="selected-prioridad" class="control-label fs-7" style="white-space: nowrap;">Prioridad:</label>
                                <span class="obligatorio">*</span>

                                <select class="form-select" id="selected-prioridad" name="id_prioridad" required>
                                    <option selected="selected" value="">Seleccionar</option>
                                    @foreach ($Prioridades as $id => $nombre)
                                        <option value="{{ $id }}">
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" id="fecha_req">
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            <div class="form-group">
                                <label for="id_activo" class="control-label fs-7" style="white-space: nowrap;">Activo:</label>

                                <select class="form-select reset-input" id="activo" name="id_activo">
                                    <option selected="selected" value="">Seleccionar</option>
                                    @foreach ($activos as $id => $nombre)
                                        <option value="{{ $id }}">
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="row-sintomas" hidden>
                        <div class="form-group">
                            <label for="sintomas-activo" class="control-label fs-7" style="white-space: nowrap; ">Sintomas:</label>
                            <div class="row" id="sintomas-activo">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <div class="form-group">
                                <label for="archivo" class="control-label fs-7" style="white-space: nowrap; ">Archivo:</label>
                                <div class="input-group mb-3">
                                    <input name="archivos[]" type="file" class="form-control" id="inputGroupFile02" multiple>
                                    <label class="input-group-text" for="inputGroupFile02">Subir</label>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label for="descrip" class="control-label fs-7" style="white-space: nowrap; ">Descripcion:</label>
                                <span class="obligatorio">*</span>
                                <textarea name='descripcion' id="descrip" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 25vh" required></textarea>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id='descrip_urgencia'>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success button-prevent-multiple-submits" type="submit">Guardar</button>
                </form>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Solicitud/crear-rssi-no-au.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Solicitud/crear-rssi-no-au.js')) }}"></script>