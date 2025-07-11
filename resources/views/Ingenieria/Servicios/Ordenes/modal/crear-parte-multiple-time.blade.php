<!-- Modal -->
<div class="modal fade" id="verCargaMultiTime" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 80% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Carga Parte Multiple</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'partes.carga.multiple', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits-3sec carga-multiple-parte', 'id' => 'form-carga-parte-multiple']) !!}
            <div class="modal-body" id="modal-body-ver-partes-time">          
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('ope', 'Partes:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <table class="table table-striped mt-2" id="editableTableCPMT">
                                <thead>
                                  <tr>
                                    <th class='text-center' style="color:#fff; width: 10px !important;">N°</th>
                                    <th class='text-center' style="color:#fff;">Proyecto/Etapa/Orden</th>
                                    <th class='text-center' style="color:#fff; width: 25px !important;">Observaciones</th>
                                    <th class='text-center' style="color:#fff;">Hs. Ini.</th>
                                    <th class='text-center' style="color:#fff;">Hs. Fin</th>
                                    <th class='text-center' style="color:#fff;">Horas</th>
                                    <th class='text-center' style="color:#fff; width: 10px !important;"></th>
                                  </tr>
                                </thead>
                                <tbody id="table-body-CPMT">
                                </tbody>
                            </table>
                              
                              <!-- Botón para agregar filas -->
                              <button id="addRow" class="btn btn-primary mt-3">Agregar Fila</button>                        
                        </div>
                    </div>
                </div>
            </div>

            <div id="alert-cm" class="mx-3">
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits-3sec" id="">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>