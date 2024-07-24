<!-- Modal -->
<div class="modal fade" id="guardaCaliModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Guardar calificacion de P.M. #{{$pm->getSolicitud->id_solicitud}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => ['pm.calificar.guardar', $pm->id_propuesta_de_mejora], 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Titulo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('titulo', $pm->titulo_propuesta, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('emisor', 'Emisor:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('emisor', $pm->nombre_emisor, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>
                </div>
                <div class="row border-top border-2">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('vi_tec', 'Viabilidad técnica:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::number('vi_tec', 0, ['class' => 'form-control', 'id' => 'input_vi_tec','readonly', 'required', 'min' => 1]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('vi_eco', 'Viabilidad económica:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::number('vi_eco', 0, ['class' => 'form-control', 'id' => 'input_vi_eco', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('vi_temp', 'Viabilidad temporal:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::number('vi_temp', 0, ['class' => 'form-control', 'id' => 'input_vi_temp','readonly']) !!}
                        </div>
                    </div>
                </div>

                <div class="row border-top border-2">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('vi_tot', 'Viabilidad total:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::number('vi_tot', 0, ['class' => 'form-control', 'id' => 'input_vi_tot', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('nece', 'Necesidad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::number('nece', 0, ['class' => 'form-control', 'id' => 'input_nece', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('inte', 'Interés:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::number('inte', 0, ['class' => 'form-control', 'id' => 'input_inte','readonly']) !!}
                        </div>
                    </div>
                </div>
                <div class="row border-top border-2">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('cali', 'Calificación:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::number('cali', 0, ['class' => 'form-control', 'id' => 'input_cali', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar calificacion</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Solicitud/buscar-prefijo.js') }}"></script>