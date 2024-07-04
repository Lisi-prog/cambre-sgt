<!-- Modal -->
<div class="mcarga modal fade" id="crearProyectoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Proyecto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'proyectos.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('prefijo_proyecto', 'Prefijo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::select('prefijo_proyecto', $prefijos, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control reset-input',
                                            'id' => 'prefijo_proyecto'
                                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('codigo_proyecto', 'Codigo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('codigo_proyecto', null, [
                                'class' => 'form-control reset-input',
                                'style' => 'text-transform:uppercase',
                                'required' => 'required',
                                'id' => 'codigo_proyecto'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('nombre', "Nombre proyecto:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_proyecto', null, ['class' => 'form-control reset-input']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('id_tipo_proyecto', 'Tipo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('id_tipo_proyecto', $Tipos_servicios, null, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select reset-input',
                                'id' => 'id_tipo_proyecto',
                                'required'
                            ]) !!}
                        </div>
                    </div>
                </div>
                


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('lider', 'Lider:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                {!! Form::select('lider', $empleados, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select reset-input',
                                    'id' => 'lider'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('id_activo', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                {!! Form::select('id_activo', $activos, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select reset-input',
                                    'id' => 'id_activo'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('prioridad', 'Prioridad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            
                            {!! Form::text('prioridad', $prioridadMax, ['class' => 'form-control', 'readonly']) !!}

                            {{-- {!! Form::select('prioridad', $prioridades, null, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select',
                                'id' => 'prioridad',
                                'required'
                            ]) !!} --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('fec_ini', 'Fecha inicio:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                            {!! Form::date('fecha_ini', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fec_ini',
                                'class' => 'form-control reset-fecha-hoy'
                            ]) !!}
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('fec_req', 'Fecha requerida:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::date('fecha_req', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fec_req',
                                'class' => 'form-control reset-fecha-hoy'
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

<script>
    
    $(function(){
        $('#prefijo_proyecto').on('change', obtenerValorPrefijo);
    });

    function obtenerValorPrefijo(){
        id = $(this).val();
        input_codigo_proyecto = document.getElementById('codigo_proyecto');
        let e = document.getElementById('prefijo_proyecto');
        input_codigo_proyecto.value = '';
        if (id) {
            $.when($.ajax({
            type: "post",
            url: '/proyectos/obtener-mayor-prefijo/'+id, 
            data: {
                id: id,
            },
            success: function (response) {
                // console.log(response);
                if (response) {
                    let numeroDeProy = response.codigo_servicio.substr(e.options[e.selectedIndex].text.length);
                    let numeroDeProyLengInicial;
                    numeroDeProy = numeroDeProy.match(/[0-9]*/g);
                    numeroDeProyLengInicial = numeroDeProy[0].length //Largo del primer numero encontrado
                    numeroDeProy = String(Number(numeroDeProy[0])+1)
                    while(numeroDeProy.length < numeroDeProyLengInicial){
                        numeroDeProy = '0' + numeroDeProy
                    }
                    let prefijoMasNumero = e.options[e.selectedIndex].text + numeroDeProy;

                    if (numeroDeProyLengInicial > 1) {
                        input_codigo_proyecto.value = prefijoMasNumero + response.codigo_servicio.substr(prefijoMasNumero.length);
                    } else {
                        input_codigo_proyecto.value = e.options[e.selectedIndex].text + '000' + numeroDeProy + response.codigo_servicio.substr(prefijoMasNumero.length);
                    }
                    
                }else{
                    input_codigo_proyecto.value = e.options[e.selectedIndex].text;
                }
                
            },
            error: function (error) {
                console.log(error);
            }
            }));
        }
        /*
        input_codigo_proyecto = document.getElementById('codigo_proyecto');
        input_codigo_proyecto.value = '';
        $.when($.ajax({
        type: "post",
        url: '/proyectos/obtener-mayor-prefijo/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            //console.log(response);
            input_codigo_proyecto.value = response.codigo_servicio;
        },
        error: function (error) {
            console.log(error);
        }
        }));
        */
    }
</script>
