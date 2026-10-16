<!-- Modal -->
<div class="modal fade" id="verActEtapaOrdenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ver actualizaciones etapa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="modal-body-ver-act-etapa">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <label for="m-ver-act-etapa" class="control-label fs-7" style="white-space: nowrap;">Etapa:</label>
                            <input type="text" name="m-ver-act-etapa" id="m-ver-act-etapa" value="{{ old('m-ver-act-etapa') }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                            <label for="m-ver-act-eta-orden" class="control-label fs-7" style="white-space: nowrap;">Estado:</label>
                            <input type="text" name="orden" id="m-ver-act-eta-orden" value="{{ old('orden') }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="m-ver-act-eta-responsable" class="control-label fs-7" style="white-space: nowrap;">Responsable:</label>
                            <input type="text" name="m-ver-act-eta-responsable" id="m-ver-act-eta-responsable" value="{{ old('m-ver-act-eta-responsable') }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="table-responsive">
                            <div>
                            <table id="tablaAct" class="table table-hover mt-2" class="display">
                                <thead style="background-color: #5997d4">
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Codigo</th>
                                    <th class="text-center" scope="col" style="color:#fff;">Fecha carga</th>
                                    <th class="text-center" scope="col" style="color:#fff;">Descripcion</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:3%;">Estado</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:30%;">Responsable</th>                                                          
                                </thead>
                                <tbody id="cuadro-act-etapa">
                                    
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <button type="button" class="btn btn-warning" onclick="verCargarActEtaModal()">Nueva actualizacion etapa</button>
                    </div>
                </div>
                <div class="row" id="m-ver-act-eta-div" hidden>
                <form id="form-actualizacion-etapa" action="{{ route('actualizacion-etapa.crear', $proyecto->id_servicio) }}" method="POST" class="formulario">
                    @csrf
                    <input type="hidden" name="m-crear-act-eta-id_etapa" id="m_cae_id_etapa" value="{{ old('m-crear-act-eta-id_etapa') }}" class="form-control">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                <div class="form-group">
                                    <label for="m-ver-act-eta-descripcion" class="control-label" style="white-space: nowrap;">Descripcion:</label>
                                    <span class="obligatorio">*</span>
                                    <input type="text" name="m-ver-act-eta-descripcion" id="m-ver-act-eta-descripcion" value="{{ old('m-ver-act-eta-descripcion') }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    <label for="m-crear-act-eta-idestado" class="control-label" style="white-space: nowrap;">Estado:</label>
                                    <span class="obligatorio">*</span>
                                    <select name="m-crear-act-eta-idestado" id="m-crear-act-eta-idestado" class="form-select form-control" required>
                                        <option value="" {{ old('m-crear-act-eta-idestado') === null || old('m-crear-act-eta-idestado') === '' ? 'selected' : '' }}>Seleccionar</option>
                                        @foreach ($estados as $id => $nombre)
                                            <option value="{{ $id }}" {{ (string) old('m-crear-act-eta-idestado') === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    <label for="m-crear-act-eta-feclimite" class="control-label fs-7" style="white-space: nowrap;">Fecha limite:</label>
                                                
                                    <input type="date" name="m-crear-act-eta-feclimite" id="m-crear-act-eta-feclimite" value="{{ old('m-crear-act-eta-feclimite') }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                
                <button type="submit" class="btn btn-success" id="m-ver-act-eta-btn" form="form-actualizacion-etapa" hidden>Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>