<!-- Modal -->
<div class="modal fade" id="guardaCaliModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Guardar calificacion de P.M. #{{$pm->getSolicitud->id_solicitud}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pm.calificar.guardar', $pm->id_propuesta_de_mejora) }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-group">
                            <label for="titulo" class="control-label fs-7" style="white-space: nowrap; ">Titulo:</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" readonly value="{{ old('titulo', $pm->titulo_propuesta) }}">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="emisor" class="control-label fs-7" style="white-space: nowrap; ">Emisor:</label>
                            <input type="text" name="emisor" id="emisor" class="form-control" readonly value="{{ old('emisor', $pm->nombre_emisor) }}">
                        </div>
                    </div>
                </div>
                <div class="row border-top border-2">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="input_vi_tec" class="control-label fs-7" style="white-space: nowrap; ">Viabilidad técnica:</label>
                            <input type="number" name="vi_tec" id="input_vi_tec" class="form-control" readonly required min="1" value="{{ old('vi_tec', 0) }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="input_vi_eco" class="control-label fs-7" style="white-space: nowrap; ">Viabilidad económica:</label>
                            <input type="number" name="vi_eco" id="input_vi_eco" class="form-control" readonly value="{{ old('vi_eco', 0) }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="input_vi_temp" class="control-label fs-7" style="white-space: nowrap; ">Viabilidad temporal:</label>
                            <input type="number" name="vi_temp" id="input_vi_temp" class="form-control" readonly value="{{ old('vi_temp', 0) }}">
                        </div>
                    </div>
                </div>

                <div class="row border-top border-2">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="input_vi_tot" class="control-label fs-7" style="white-space: nowrap; ">Viabilidad total:</label>
                            <input type="number" name="vi_tot" id="input_vi_tot" class="form-control" readonly value="{{ old('vi_tot', 0) }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="input_nece" class="control-label fs-7" style="white-space: nowrap; ">Necesidad:</label>
                            <input type="number" name="nece" id="input_nece" class="form-control" readonly value="{{ old('nece', 0) }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="input_inte" class="control-label fs-7" style="white-space: nowrap; ">Interés:</label>
                            <input type="number" name="inte" id="input_inte" class="form-control" readonly value="{{ old('inte', 0) }}">
                        </div>
                    </div>
                </div>
                <div class="row border-top border-2">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="input_cali" class="control-label fs-7" style="white-space: nowrap; ">Calificación:</label>
                            <input type="number" name="cali" id="input_cali" class="form-control" readonly value="{{ old('cali', 0) }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar calificacion</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Solicitud/buscar-prefijo.js') }}"></script>