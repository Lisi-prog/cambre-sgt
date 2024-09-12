<!-- Modal -->
<div class="modal fade" id="crearSSIModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear solicitud de servicio de ingenieria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    {!! Form::open(['route' => 's_s_i.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits', 'enctype' => 'multipart/form-data']) !!}
                    {{-- @include('layouts.modal.mensajes') --}}

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                {!! Form::label('selected-prioridad', 'Prioridad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                {!! Form::select('id_prioridad', $Prioridades, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select',
                                    'id' => 'selected-prioridad',
                                    'required'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3" id="fecha_req">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                            {!! Form::label('id_activo', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                {!! Form::select('id_activo', $activos, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select reset-input',
                                    'id' => 'activo',
                                ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <div class="form-group">
                                {!! Form::label('archivo', 'Archivo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <div class="input-group mb-3">
                                    <input name="archivos[]" type="file" class="form-control" id="inputGroupFile02" multiple>
                                    <label class="input-group-text" for="inputGroupFile02">Subir</label>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                {!! Form::label('descrip', 'Descripcion:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                <span class="obligatorio">*</span>
                                <textarea name='descripcion' id="descrip" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 40vh" required></textarea>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id='descrip_urgencia'>
                            {{-- <div class="form-group">
                                {!! Form::label('descrip', 'Descripcion:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                <span class="obligatorio">*</span>
                                <textarea name='descripcion' id="descrip" class="form-control" rows="54" cols="54" style="resize:none; height: 40vh"></textarea>
                            </div> --}}
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
