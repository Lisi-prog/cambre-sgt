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
                            <table id="tablaAct" class="table table-hover mt-2" class="display">
                                <thead style="background-color:#00b1b1">
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Codigo</th>
                                    <th class="text-center" scope="col" style="color:#fff;">Fecha carga</th>
                                    <th class="text-center" scope="col" style="color:#fff;">Descripcion</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:3%;">Estado</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:30%;">Responsable</th>                                                          
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
                {!! Form::open(['route' => ['actualizacion.crear', $proyecto->id_servicio], 'method' => 'POST', 'class' => 'formulario']) !!}
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('descripcion', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('m-ver-act-descripcion', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select('m-ver-act-id_estado', $estados, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'required',
                                            'id' => 'm-ver-act-id_estado'
                                        ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('fecha_limite', 'Fecha limite:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                                <span class="obligatorio">*</span>
                                    {!! Form::date('m-ver-act-fecha_limite', null, [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'm-ver-act-fecha_limite',
                                        'class' => 'form-control',
                                        'required'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('lider', "Lider:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select('m-ver-act-lider', $supervisores_admin, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'required',
                                            'id' => 'm-ver-act-cbx_lider'
                                        ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">Guardar</button> --}}
                <button type="submit" class="btn btn-success" id="m-ver-act-btn" hidden>Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>