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
                            {!! Form::label('m-ver-act-etapa', 'Etapa:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m-ver-act-etapa', null, [
                                'class' => 'form-control',
                                'id' => 'm-ver-act-etapa',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('m-ver-act-eta-estado', 'Estado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('orden', null, [
                                'class' => 'form-control',
                                'id' => 'm-ver-act-eta-orden',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('m-ver-act-eta-responsable', 'Responsable:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m-ver-act-eta-responsable', null, [
                                'class' => 'form-control',
                                'id' => 'm-ver-act-eta-responsable',
                                'readonly'
                            ]) !!}
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
                {!! Form::open(['route' => ['actualizacion-etapa.crear', $proyecto->id_servicio], 'method' => 'POST', 'class' => 'formulario']) !!}
                    {!! Form::text('m-crear-act-eta-id_etapa', null, ['class' => 'form-control', 'hidden', 'id' => 'm_cae_id_etapa']) !!}
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('descripcion', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('m-ver-act-eta-descripcion', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select('m-crear-act-eta-idestado', $estados, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'required',
                                            'id' => 'm-crear-act-eta-idestado'
                                        ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('fecha_limite', 'Fecha limite:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                                <span class="obligatorio">*</span>
                                    {!! Form::date('m-crear-act-eta-feclimite', null, [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'm-crear-act-eta-feclimite',
                                        'class' => 'form-control',
                                        'required'
                                    ]) !!}
                                </div>
                            </div>
                            {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        {!! Form::label('responsable', 'Responsable:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('responsable', $supervisores_admin, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'cbx_responsable_etapa'
                                        ]) !!}
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">Guardar</button> --}}
                <button type="submit" class="btn btn-success" id="m-ver-act-eta-btn" hidden>Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>