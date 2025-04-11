<div class="row">
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
        <div class="form-group">
            {!! Form::label('opt', 'Opciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="flexRadioEtp" name="op_act_se_eta" checked>
                <label class="form-check-label" for="flexRadioEtp">
                    Crear Servicio y etapa con estado "En proceso".
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value=1 id="siGestionar" checked name="gesti">
                <label class="form-check-label" for="siGestionar">
                Gestionar despues de guardar.
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value=1 id="sin-pri" name="sin-pri">
                <label class="form-check-label" for="sin-pri">
                    Sin prioridad.
                </label>
            </div>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
    </div>
</div>