<!-- Modal -->
<div class="modal fade" id="crearParteMultipleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Parte</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('partes.guardar.act') }}" class="formulario form-prevent-multiple-submits-3sec nuevo-agregar-parte" id="form-agregar-parte">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <label for="orden" class="control-label fs-7" style="white-space: nowrap; ">Orden:</label>
                            <input type="text" name="orden" value="{{ old('orden', '') }}" class="form-control" id="mv-orden" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            <label for="estado" class="control-label fs-7" style="white-space: nowrap; ">Estado:</label>
                            <input type="text" name="estado" value="{{ old('estado', '') }}" class="form-control" id="mv-estado" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <label for="etapa" class="control-label fs-7" style="white-space: nowrap; ">Etapa:</label>
                            <input type="text" name="etapa" value="{{ old('etapa', '') }}" class="form-control" id="mv-etapa" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="observaciones" class="control-label fs-7" style="white-space: nowrap; ">Observaciones:</label>
                                    <span class="obligatorio">*</span>
                                    <textarea name='observaciones' id="observaciones" maxlength="500" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label for="estado" class="control-label fs-7" style="white-space: nowrap;">Estado:</label>
                                <span class="obligatorio">*</span>

                                                                <select class="form-select" id="m-ver-parte-estado" name="estado">

                                                                    <option selected="selected" value="">Seleccionar</option>

                                                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label for="fecha_limite" class="control-label fs-7" style="white-space: nowrap;">Fecha limite:</label>
                                @role('SUPERVISOR')
                                    <input type="date" name="fecha_limite" value="{{ old('fecha_limite', '') }}" min="2023-01-01" max="{{ \Carbon\Carbon::now()->year . '-12-31' }}" id="m-ver-parte-fecha-limite" class="form-control">
                                @else
                                    <input type="date" name="fecha_limite" value="{{ old('fecha_limite', '') }}" min="2023-01-01" max="{{ \Carbon\Carbon::now()->year . '-12-31' }}" id="m-ver-parte-fecha-limite" class="form-control" readonly>
                                @endrole
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label for="fecha" class="control-label fs-7" style="white-space: nowrap;">Fecha:</label>
                                            <span class="obligatorio">*</span>
                                <input type="date" name="fecha" value="{{ old('fecha', \Carbon\Carbon::now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ \Carbon\Carbon::now()->year . '-12-31' }}" id="fecha" class="form-control" required>
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
                </div>


            </form>
                </div>
            <div class="modal-footer">
                <button type="submit" form="form-agregar-parte" class="btn btn-success button-prevent-multiple-submits" onclick="">Guardar</button>
                <button id="btn-cerrar-md" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>