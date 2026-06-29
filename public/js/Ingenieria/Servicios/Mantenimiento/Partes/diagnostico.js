var tabla_diagnosticos
$(document).ready(function () {
    tabla_diagnosticos = $('#tabla_diagnosticos').DataTable({
         columnDefs: [
            { className: "text-center", targets: [0,1,2,3] }
        ],
        language: {
                lengthMenu: 'Mostrar _MENU_ registros por pagina',
                zeroRecords: 'No se ha encontrado registros',
                info: 'Mostrando pagina _PAGE_ de _PAGES_',
                infoEmpty: 'No se ha encontrado registros',
                infoFiltered: '(Filtrado de _MAX_ registros totales)',
                search: 'Buscar',
                paginate:{
                    first:"Prim.",
                    last: "Ult.",
                    previous: 'Ant.',
                    next: 'Sig.',
                },
            },
            "aaSorting": []
    });    
    activo = document.getElementById('activo').value;
    // document.getElementById('herramental').value = activo;
    document.getElementById('nombreActivo').textContent = activo;
    $("#hs").val($("#horas_totales").val())
    $("#es").val($("#estado_actual").val())
    $("#nombre_proyecto_diagnostico").val($("#nombre_proyecto_i").val())
});

var i = 0;

function agregarDiagnostico() {
    const ishikawa_categoria = document.getElementById('ishikawa_categoria_div');
    const ishikawa_causa = document.getElementById('ishikawa_causa_div');

    tabla_diagnosticos.row.add([
        i + 1,
        `<select required onchange="cambiarIshikawaCategoria(${i})"
            class="form-select"
            name="ishikawa_categoria[]"
            id="ishikawa_categoria_${i}">
            <option hidden value="">Seleccionar...</option>
            ${ishikawa_categoria.innerHTML}
        </select>`,
        `<div id="prev_ishikawa_cat_${i}">Primero elegir 5M</div>
         <select required hidden
            class="form-select"
            name="ishikawa_causa[]"
            id="ishikawa_causa_${i}">
            <option hidden value="">Seleccionar...</option>
            ${ishikawa_causa.innerHTML}
         </select>`,
        `<button type="button" class="btn btn-danger"
            onclick="eliminarDiagnostico(${i})">Eliminar</button>`
    ]).node().id = `diagnostico_${i}`;

    tabla_diagnosticos.draw(false);
    i++;
    checkSendNuevoParteDiagnostico();
}


function cambiarIshikawaCategoria(indice){
    ishikawa_categoria = document.getElementById(`ishikawa_categoria_${indice}`).value;
    ishikawa_causa = document.getElementById(`ishikawa_causa_${indice}`);
    ishikawa_causa.removeAttribute('hidden');
    document.getElementById(`prev_ishikawa_cat_${indice}`).setAttribute('hidden', true);
    for (let j = 0; j < ishikawa_causa.options.length; j++) {
        if (ishikawa_causa.options[j].dataset.ishikawaCategoria == ishikawa_categoria) {
            ishikawa_causa.options[j].removeAttribute('hidden');
        }
        else{
            ishikawa_causa.options[j].setAttribute('hidden', true);
        }
    }
}

function eliminarDiagnostico(indice){
   tabla_diagnosticos.row('#diagnostico_'+indice).remove().draw();
   //Reordenar indices
   for (let j = 0; j < tabla_diagnosticos.rows().count(); j++) {
        const row = tabla_diagnosticos.row(j).node();
        row.id = `diagnostico_${j}`;
        row.querySelector('td').innerText = j + 1;
        row.querySelector('select').setAttribute('id', `ishikawa_categoria_${j}`);
        row.querySelectorAll('select')[1].setAttribute('id', `ishikawa_causa_${j}`);
        row.querySelector('button').setAttribute('onclick', `eliminarDiagnostico(${j})`);
        row.querySelector('select').setAttribute('onchange', `cambiarIshikawaCategoria(${j})`);
    }
    i= tabla_diagnosticos.rows().count();
    checkSendNuevoParteDiagnostico();
}

function checkSendNuevoParteDiagnostico(){
    if(tabla_diagnosticos.rows().count() > 0 && $("#fecha").val() && $("#horas").val() && $("#minutos").val()){
        $("#btnGuardarNuevoParteDiagnostico").removeAttr('disabled');
        $("#btnGuardarNuevoParteDiagnosticoCerrar").removeAttr('disabled');
    }
    else{
        $("#btnGuardarNuevoParteDiagnostico").attr('disabled', 'disabled');
        $("#btnGuardarNuevoParteDiagnosticoCerrar").attr('disabled', 'disabled');
    }
}


function openModalNuevoParteDiagnostico(id_orden){
    $('#nuevoParteDiagnosticoModal').modal('show');
    $("#btnAgregarFilaDiagnostico").show();
    tabla_diagnosticos.clear().draw();
    i = 0;
    $("#btnGuardarNuevoParteDiagnostico").show();
    $("#btnGuardarNuevoParteDiagnosticoCerrar").show();
    $('.obligatorio').show();
    $("#label_ob_diagnostico").show()
    $("#btnGuardarNuevoParteDiagnostico").attr('disabled', 'disabled');
    $("#btnGuardarNuevoParteDiagnosticoCerrar").attr('disabled', 'disabled');
    $("input:radio[name=a_resolver]").removeAttr('disabled');
    // $("#horas").val('');
    // $("minutos").val('');
    $("#horas").removeAttr('disabled');
    $("#minutos").removeAttr('disabled');
    let hoy = new Date()
    hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
    '-' + hoy.getDate().toString().padStart(2, 0)
    $("#fecha").val(hoy);
    $("#observaciones_diagonstico").val('');
    $("#observaciones_diagonstico").removeAttr('disabled');
    $("#completado_diagnostico").removeAttr('checked');
    $("#completado_diagnostico").removeAttr('disabled');
    $("#fecha").removeAttr('disabled');
    $("#herramental").val($("#activo").val());
    $("#id_orden").val(id_orden);
    $("input:radio").attr("checked", false);
}

function openModalVerParteDiagnostico(id_orden){
    $('#nuevoParteDiagnosticoModal').modal('show');
    $("#btnAgregarFilaDiagnostico").hide();
    $("#fecha").attr('disabled', 'disabled');
    $("#horas").attr('disabled', 'disabled');
    $("#minutos").attr('disabled', 'disabled');
    $('.obligatorio').hide();
    $("#label_ob_diagnostico").hide();
    $("#completado_diagnostico").prop('disabled', 'disabled');
    $("#observaciones_diagonstico").attr('disabled', 'disabled');
    $("#btnGuardarNuevoParteDiagnostico").hide();
    $("#btnGuardarNuevoParteDiagnosticoCerrar").hide();
    $("#herramental").val($("#activo").val());
    tabla_diagnosticos.column(3).visible(false);
    tabla_diagnosticos.clear()
    $.ajax({
        type: 'GET',
        url: '/get-parte-diagnostico-completado/' + id_orden,
        success: function(data) {
            if(!data.length){
                return;
            }
            let diag = data[0];
            $("#fecha").val(diag.get_parte.fecha);
            $("#observaciones_diagonstico").val(diag.get_parte.observaciones);
            $("#completado_diagnostico").prop('checked', true);
            if(diag.en_maquina == 1){
                $("input:radio[name=a_resolver][value='Máquina']").prop("checked", true);
            }
            else if(diag.en_banco == 1){
                $("input:radio[name=a_resolver][value='Banco']").prop("checked", true);
            }
            $("input:radio[name=a_resolver]").attr("disabled", true);
            let i = 1;
            data.forEach(diagnostico => {
                diagnostico.get_parte_diag_x_causa.forEach(parte_diag_x_causa => {
                    tabla_diagnosticos.row.add([
                        i,
                        parte_diag_x_causa.get_ishikawa_causa.get_categoria.nombre_categoria,
                        parte_diag_x_causa.get_ishikawa_causa.nombre_causa,
                        '-'
                    ]);
                    i++;
                });
            });
            let [hr, mn] = data[0].horas.split(':');
            $("#horas").val(hr);
            $("#minutos").val(mn);
            tabla_diagnosticos.columns.adjust();
            tabla_diagnosticos.draw();
        }
    });
}

function openModalParteDiagnosticoPendiente(id_orden){
    $('#nuevoParteDiagnosticoModal').modal('show');
    $("#btnAgregarFilaDiagnostico").show();
    tabla_diagnosticos.clear().draw();
    i = 0;
    $("#btnGuardarNuevoParteDiagnostico").show();
    $("#btnGuardarNuevoParteDiagnosticoCerrar").show();
    $('.obligatorio').show();
    $("#label_ob_diagnostico").show()
    $("#btnGuardarNuevoParteDiagnostico").attr('disabled', 'disabled');
    $("#btnGuardarNuevoParteDiagnosticoCerrar").attr('disabled', 'disabled');
    $("input:radio[name=a_resolver]").removeAttr('disabled');
    $("#horas").val('');
    $("#minutos").val('');
    $("#horas").removeAttr('disabled');
    $("#minutos").removeAttr('disabled');
    $("#observaciones_diagonstico").removeAttr('disabled');
    $("#completado_diagnostico").removeAttr('checked');
    $("#completado_diagnostico").removeAttr('disabled');
    $("#fecha").removeAttr('disabled');
    $("#herramental").val($("#activo").val());
    $("#id_orden").val(id_orden);

    let hoy = new Date()
    hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
    '-' + hoy.getDate().toString().padStart(2, 0)
    $("#fecha").val(hoy);
    $.ajax({
        type: 'GET',
        url: '/get-parte-diagnostico-completado/' + id_orden,
        success: function(data) {
            if(!data.length){
                return;
            }
            let diag = data[0];
            $("#observaciones_diagonstico").val(diag.get_parte.observaciones);
            $("#completado_diagnostico").prop('checked', false);
            if(diag.en_maquina == 1){
                $("input:radio[name=a_resolver][value='Máquina']").prop("checked", true);
            }
            else if(diag.en_banco == 1){
                $("input:radio[name=a_resolver][value='Banco']").prop("checked", true);
            }
            $("input:radio[name=a_resolver]").attr("disabled", false);
            let i = 0;
            let tabla_already = tabla_diagnosticos.rows().count();
            data.forEach(diagnostico => {
                diagnostico.get_parte_diag_x_causa.forEach(parte_diag_x_causa => {
                    tabla_diagnosticos.row.add([
                        (i + tabla_already + 1),
                        parte_diag_x_causa.get_ishikawa_causa.get_categoria.nombre_categoria,
                        parte_diag_x_causa.get_ishikawa_causa.nombre_causa,
                        '-'
                    ]);
                    i++;
                });
            });

            tabla_diagnosticos.columns.adjust();
            tabla_diagnosticos.draw();
        }
    });
}

function verParteDeDiagnostico(id_parte, completado){
    $('#nuevoParteDiagnosticoModal').modal('show');
    $("#btnAgregarFilaDiagnostico").hide();
    $("#fecha").attr('disabled', 'disabled');
    $("#horas").attr('disabled', 'disabled');
    $("#minutos").attr('disabled', 'disabled');
    $("#herramental_inspeccion").val($("#activo").val());
    $("#observaciones_diagonstico").attr('disabled', 'disabled');
    $("#btnGuardarNuevoParteDiagnostico").hide();   
    $("#btnGuardarNuevoParteDiagnosticoCerrar").hide();
    if(completado == 'Completo'){
        $("#completado_diagnostico").prop('checked', true)
    }
    else{
        $("#completado_diagnostico").prop('checked', false)
    }

    tabla_diagnosticos.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-diagnostico-porcion/' + id_parte,
        success: function(diag) {
            $("#observaciones_diagonstico").val(diag.get_parte.observaciones);
            $("#completado_diagnostico").prop('checked', false);
            if(diag.en_maquina == 1){
                $("input:radio[name=a_resolver][value='Máquina']").prop("checked", true);
            }
            else if(diag.en_banco == 1){
                $("input:radio[name=a_resolver][value='Banco']").prop("checked", true);
            }
            $("input:radio[name=a_resolver]").attr("disabled", true);
            let i = 0;
            let tabla_already = tabla_diagnosticos.rows().count();
            diag.get_parte_diag_x_causa.forEach(parte_diag_x_causa => {
                tabla_diagnosticos.row.add([
                    (i + tabla_already + 1),
                    parte_diag_x_causa.get_ishikawa_causa.get_categoria.nombre_categoria,
                    parte_diag_x_causa.get_ishikawa_causa.nombre_causa,
                    '-'
                ]);
                i++;
            });
            let [hr, mn] = diag.get_parte.horas.split(':');
            $("#horas").val(hr);
            $("#minutos").val(mn);
            $("#fecha").val(diag.get_parte.fecha);
            tabla_diagnosticos.columns.adjust();
            tabla_diagnosticos.draw();
        }
    });
}


function diagnosticoPreSubmit(tipo){
    if(tipo == 'C'){
        $("#completado_diagnostico").prop('checked', true);
    }
    else{
        $("#completado_diagnostico").prop('checked', false);
    }
    $("#formNuevoParteDiagnostico").trigger( "submit" );
}

function checkMinutos(input) {
    if (parseInt(input.value) > 59) {
        input.value = 59;
    }

    if (parseInt(input.value) < 0) {
        input.value = 0;
    }
}