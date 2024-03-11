<!-- Modal -->
<div class="modal fade" id="crearPMModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear propuesta de mejora</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {!! Form::open(['route' => 'p_m.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="form-group">
                            {!! Form::label('titulo-propuesta', 'Titulo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('titulo-propuesta', null, ['class' => 'form-control reset-input']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('nombre_emisor', 'Emisor:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_emisor', null, ['class' => 'form-control reset-input']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('id_activo', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {{--    ACTIVOS    --}}
                            {!! Form::select('id_activo', $activos, null, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select form-control reset-input',
                                'id' => 'id_activo',
                                'required'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('obj-propuesta', 'Objetivo de la propuesta:', ['class' => 'control-label fs-7 reset', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            <textarea name='obj-propuesta' id="obj-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>      
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('desc-propuesta', 'Descripcion de la propuesta:', ['class' => 'control-label fs-7 reset', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            <textarea name='desc-propuesta' id="desc-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('an-i-propuesta', 'Analisis de impacto de la propuesta:', ['class' => 'control-label fs-7 reset', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            <textarea name='an-i-propuesta' id="an-i-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('bene-propuesta', 'Beneficios de la propuesta:', ['class' => 'control-label fs-7 reset', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            <textarea name='bene-propuesta' id="bene-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>     
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('prob-propuesta', 'Problemas de la propuesta:', ['class' => 'control-label fs-7 reset', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            <textarea name='prob-propuesta' id="prob-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('eva-propuesta', 'Evaluacion de la propuesta:', ['class' => 'control-label fs-7 reset', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            <textarea name='eva-propuesta' id="eva-propuesta" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-success button-prevent-multiple-submits']) !!}
                {!! Form::close() !!}
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button> --}}
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Solicitud/crear-rssi-no-au.js') }}"></script>
