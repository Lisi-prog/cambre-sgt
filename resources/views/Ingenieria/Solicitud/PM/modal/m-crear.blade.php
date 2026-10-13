<!-- Modal -->
<div class="modal fade" id="crearPMModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear propuesta de mejora</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('p_m.store') }}" method="POST" class="formulario form-prevent-multiple-submits" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="form-group">
                            <label for="titulo-propuesta" class="control-label fs-7" style="white-space: nowrap;">Titulo:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="titulo-propuesta" id="titulo-propuesta" class="form-control reset-input" value="{{ old('titulo-propuesta') }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <label for="nombre_emisor" class="control-label fs-7" style="white-space: nowrap;">Emisor:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="nombre_emisor" id="nombre_emisor" class="form-control reset-input" value="{{ old('nombre_emisor') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="form-group">
                            <label for="inputGroupFile02" class="control-label fs-7" style="white-space: nowrap;">Archivo:</label>
                            <div class="input-group mb-3">
                                <input name="archivos[]" type="file" class="form-control" id="inputGroupFile02" multiple>
                                <label class="input-group-text" for="inputGroupFile02">Subir</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <label for="id_activo" class="control-label fs-7" style="white-space: nowrap;">Activo:</label>
                            {{-- <span class="obligatorio">*</span> --}}
                            {{--    ACTIVOS    --}}
                            <select name="id_activo" id="id_activo" class="form-select form-control reset-input">
                                <option value="" {{ old('id_activo') == null ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($activos as $id => $nombre)
                                    <option value="{{ $id }}" {{ (string) old('id_activo') === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="obj-propuesta" class="control-label fs-7 reset" style="white-space: nowrap; ">Objetivo de la propuesta:</label>
                            <span class="obligatorio">*</span>
                            <textarea name='obj-propuesta' id="obj-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="desc-propuesta" class="control-label fs-7 reset" style="white-space: nowrap; ">Descripcion de la propuesta:</label>
                            <span class="obligatorio">*</span>
                            <textarea name='desc-propuesta' id="desc-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="an-i-propuesta" class="control-label fs-7 reset" style="white-space: nowrap; ">Analisis de impacto de la propuesta:</label>
                            <span class="obligatorio">*</span>
                            <textarea name='an-i-propuesta' id="an-i-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="bene-propuesta" class="control-label fs-7 reset" style="white-space: nowrap; ">Beneficios de la propuesta:</label>
                            <span class="obligatorio">*</span>
                            <textarea name='bene-propuesta' id="bene-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="prob-propuesta" class="control-label fs-7 reset" style="white-space: nowrap; ">Problemas de la propuesta:</label>
                            <span class="obligatorio">*</span>
                            <textarea name='prob-propuesta' id="prob-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="eva-propuesta" class="control-label fs-7 reset" style="white-space: nowrap; ">Evaluacion de la propuesta:</label>
                            <span class="obligatorio">*</span>
                            <textarea name='eva-propuesta' id="eva-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button> --}}
            </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Solicitud/crear-rssi-no-au.js') }}"></script>
