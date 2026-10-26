<!-- Modal -->
<div class="modal fade" id="activarOrdenManufacturaModal" tabindex="-1" aria-labelledby="actOrdManModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="actOrdManModalLabel">Activar Orden de Manufactura</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('ordenes.ordenman.validar') }}" class="formulario form-prevent-multiple-submits activar-orden-manufactura">
                @csrf
            <input type="hidden" name="idord" value="{{ old('idord', '') }}" class="form-control" id="m_act_id_ord_man">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="proyecto" class="control-label" style="white-space: nowrap; ">Proyecto:</label>
                            <input type="text" name="proyecto" value="{{ old('proyecto', '') }}" class="form-control" id="m_act_ord_man_pry" readonly>
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-group">
                            <label for="prioridad" class="control-label" style="white-space: nowrap; ">Orden Manufactura:</label>
                            <input type="text" name="ordman" value="{{ old('ordman', '') }}" class="form-control" id="m_act_ord_man" readonly>
                        </div>
                    </div>
                </div>
                <label for="ope_ems" class="control-label" style="white-space: nowrap; ">Operacion de Ensamblado:</label>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label for="prioridad" class="control-label" style="white-space: nowrap; ">Prioridad:</label>
                            <input type="number" name="prioridad" value="{{ old('prioridad', '') }}" class="form-control" id="m_act_ord_man_pri">
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label for="operacion" class="control-label" style="white-space: nowrap; ">Operacion:</label>
                            <input type="text" name="operacion" value="{{ old('operacion', '') }}" class="form-control" id="m_act_ord_man_ope" readonly>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label for="maquina" class="control-label" style="white-space: nowrap; ">Maquina:</label>
                            <input type="text" name="maquina" value="{{ old('maquina', '') }}" class="form-control" id="m_act_ord_man_maq" readonly>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="asignado" class="control-label" style="white-space: nowrap; ">Asignado:</label>

                                                        <select name="asignado" class="form-select form-control" id="m_act_ord_man_asig">

                                <option value="" @if ((string) old('asignado', '') === '') selected @endif>Seleccionar</option>

                                @foreach ($tecnicosConManual as $opcionValor => $opcionTexto)

                                    <option value="{{ $opcionValor }}" @if ((string) old('asignado', '') === (string) $opcionValor) selected @endif>{{ $opcionTexto }}</option>

                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div id="alert-act-ord" class="mx-3">

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Activar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
