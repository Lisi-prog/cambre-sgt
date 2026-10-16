<!-- Modal -->
<div class="modal fade" id="verActServOrdenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ver actualizaciones servicio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="modal-body-ver-act">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="table-responsive">
                            <div>
                            <table id="tablaAct" class="table table-hover mt-2 table-sm" class="display">
                                <thead style="background-color:#00b1b1">
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Codigo</th>
                                    <th class="text-center" scope="col" style="color:#fff;">Fecha carga</th>
                                    <th class="text-center" scope="col" style="color:#fff;">Descripcion</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:15%;">Estado</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:30%;">Lider</th>                                                          
                                </thead>
                                <tbody id="cuadro-act">
                                    
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <button type="button" class="btn btn-warning" onclick="verCargarActModal()">Nueva actualizacion</button>
                    </div>
                </div>
                <div class="row" id="m-ver-act-div" hidden>
                <form id="form-actualizacion-proyecto" action="{{ route('actualizacion.crear', $proyecto->id_servicio) }}" method="POST" class="formulario">
                    @csrf
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                <div class="form-group">
                                    <label for="m-ver-act-descripcion" class="control-label" style="white-space: nowrap;">Descripcion:</label>
                                    {{-- <span class="obligatorio">*</span> --}}
                                    <input type="text" name="m-ver-act-descripcion" id="m-ver-act-descripcion" value="{{ old('m-ver-act-descripcion') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    <label for="m-ver-act-id_estado" class="control-label" style="white-space: nowrap;">Estado:</label>
                                    <span class="obligatorio">*</span>
                                    <select name="m-ver-act-id_estado" id="m-ver-act-id_estado" class="form-select form-control" required>
                                        <option value="" {{ old('m-ver-act-id_estado') === null || old('m-ver-act-id_estado') === '' ? 'selected' : '' }}>Seleccionar</option>
                                        @foreach ($estados as $valor => $nombre)
                                            <option value="{{ $valor }}" {{ (string) old('m-ver-act-id_estado') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    <label for="m-ver-act-fecha_limite" class="control-label fs-7" style="white-space: nowrap;">Fecha limite:</label>
                                                <span class="obligatorio">*</span>
                                    <input type="date" name="m-ver-act-fecha_limite" id="m-ver-act-fecha_limite" value="{{ old('m-ver-act-fecha_limite') }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label for="m-ver-act-cbx_lider" class="control-label" style="white-space: nowrap;">Lider:</label>
                                    <span class="obligatorio">*</span>
                                    <select name="m-ver-act-lider" id="m-ver-act-cbx_lider" class="form-select form-control" required>
                                        <option value="" {{ old('m-ver-act-lider') === null || old('m-ver-act-lider') === '' ? 'selected' : '' }}>Seleccionar</option>
                                        @foreach ($supervisores_admin as $valor => $nombre)
                                            <option value="{{ $valor }}" {{ (string) old('m-ver-act-lider') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="eta_act_td_dv" hidden>
                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="flexRadioEtp" name="eta_p">
                                        <label class="form-check-label" for="flexRadioEtp">
                                            Completar etapas
                                        </label>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">Guardar</button> --}}
                <button type="submit" class="btn btn-success" id="m-ver-act-btn" form="form-actualizacion-proyecto" hidden>Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>