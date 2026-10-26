<!-- Modal -->
<div class="modal fade" id="crearOrdenMecanizadoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Relacionar Orden Mecanizado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="det-tab" data-bs-toggle="tab" data-bs-target="#det_val" type="button" role="tab" onclick="">Nuevo</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="det_adju_tab" data-bs-toggle="tab" data-bs-target="#det_adju" type="button" role="tab" onclick="">Existente</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="det_val" role="tabpanel">
                        <form method="POST" action="{{ route('ordenes.validarmecanizado') }}" class="formulario form-prevent-multiple-submits">
                @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                                <div class="form-group">
                                    <label for="id_orden_manuf" class="control-label" style="white-space: nowrap; ">Id orden manufactura:</label>
                                    <input type="text" name="id_orden_manuf" value="{{ old('id_orden_manuf', $orden_manufactura->id_orden_manufactura) }}" style="disabled;" class="form-control" readonly id="id_orden_manuf">
                                    <input type="text" name="id_orden" value="{{ old('id_orden', $orden_manufactura->getOrden->id_orden) }}" style="disabled;" class="form-control" readonly id="id_orden">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                                <div class="form-group">
                                    <label for="num_etapa" class="control-label" style="white-space: nowrap; ">Id orden manufactura:</label>
                                    <input type="text" name="num_etapa" value="{{ old('num_etapa', $orden_manufactura->getorden->id_etapa) }}" style="disabled;" class="form-control" readonly id="num_etapa">
                                </div>
                            </div>
                        </div>
                        <div id="formulario-crear-orden">

                        </div>
                        <div class="row d-flex align-items-center justify-content-center">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="det_adju" role="tabpanel">
                        <form method="POST" action="{{ route('ordenes.relacionarmecanizado', $orden_manufactura->id_orden_manufactura) }}" class="formulario form-prevent-multiple-submits">
                @csrf
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="ord_mec_lib" class="control-label" style="white-space: nowrap; ">Orden de Mecanizado libre (Sin Orden de Manufactura asociado):</label>

                                                                        <select name="id_orden_mec" class="form-select form-control" id="id_orden_mec" required>

                                        <option value="" @if ((string) old('id_orden_mec', '') === '') selected @endif>Seleccionar</option>

                                        @foreach ($ord_mec_sin_manufactura as $opcionValor => $opcionTexto)

                                            <option value="{{ $opcionValor }}" @if ((string) old('id_orden_mec', '') === (string) $opcionValor) selected @endif>{{ $opcionTexto }}</option>

                                        @endforeach

                                    </select>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center justify-content-center">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button> --}}
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
