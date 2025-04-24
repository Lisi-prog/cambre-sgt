<!-- Modal -->
<div class="modal fade" id="crearHdr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Hoja de Ruta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::model($orden, ['method' => 'PUT', 'route' => ['hdr.crear', $orden->getOrdenDe->id_orden_mecanizado], 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <button type="button" class="btn btn-primary-outline m-1 rounded" onclick="mostrarFiltro()">HDR anteriores <i class="fas fa-caret-down"></i></button> 
                </div>
                <div class="row" id="demo" hidden>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('proy_ant', 'Proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::select('proy', $proyectos, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'm-proy-ant',
                                            'required'
                                        ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('ord_ant', 'Orden Mecanizado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <select class="form-select form-group" id="m-ord-ant" name="ord">
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('hdr_ant', 'HDR:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <select class="form-select form-group" id="m-hdr-ant" name="hdr-ant" onchange="autocompletahdr(this.value)">
                            </select>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <div class="form-group">
                            {!! Form::label('m_id_pieza', 'ID PIEZA:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_id_pieza', $orden->nombre_orden, [
                                'class' => 'form-control reset-input',
                                'readonly',
                                'id' => 'm_id_pieza'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('m_confec', 'Confeccionó:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {{-- <span class="obligatorio">*</span> --}}
                            {!! Form::text('m_confec',  $orden->getSupervisor(), [
                                'class' => 'form-control reset-input',
                                'readonly',
                                'id' => 'm_confec'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <div class="form-group">
                            {!! Form::label('m_ubi', 'Ubicación/es:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_ubi', null, [
                                'class' => 'form-control reset-input',
                                'required',
                                'id' => 'm_ubi'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('m_cant', 'Cantidad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_cant', null, [
                                'class' => 'form-control reset-input',
                                'required',
                                'id' => 'm_cant'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('m_fec_carga', 'Fecha:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::date('m_fec_carga', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'm_fec_carga',
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('ope', 'Operaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <table class="table table-striped mt-2" id="editableTable">
                                <thead>
                                  <tr>
                                    <th class='text-center' style="color:#fff;">N°</th>
                                    <th class='text-center' style="color:#fff;">Operación</th>
                                    <th class='text-center' style="color:#fff;">Asignado</th>
                                    <th class='text-center' style="color:#fff;">Máquina</th>
                                    <th class='text-center' style="color:#fff;">Acciones</th>
                                  </tr>
                                </thead>
                                <tbody id="table-body">
                                </tbody>
                            </table>
                              
                              <!-- Botón para agregar filas -->
                              <button id="addRow" class="btn btn-primary mt-3">Agregar Fila</button>                        
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('observaciones', 'Observaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <textarea name='observaciones' id="m-obser" class="form-control reset-input" maxlength="500" rows="54" cols="54" style="resize:none; height: 20vh"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                        <div class="form-group">
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('archivo', 'Adjuntar Archivo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::file('archivo', array('class' => 'form-control', 'type' => 'file', 'id' => "inputGroupFile03", 'aria-describedby' => 'inputGroupFileAddon03', 'aria-label' => 'Upload')) !!}
                            {{-- <input type="file" class="form-control" name="archivo" required> --}}
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('m_ruta', 'Ruta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('m_ruta', null, [
                                'class' => 'form-control reset-input',
                                'id' => 'm_ruta'
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Servicios/Ordenes/modal/crear-hdr.js') }}"></script>