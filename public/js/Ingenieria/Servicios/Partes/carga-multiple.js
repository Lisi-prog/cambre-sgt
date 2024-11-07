$(function(){
    // $('#buscarubro').on('keyup', buscarRubro);
    // $('#addRow').on('click', nuevoCrono);
    $('#id_servicio').on('change', cargarCbxEtapas);
    $('#id_etapa').on('change', cargarCbxOrdenes);
    $('#id_orden').on('change', modificarModalVerPartesEstadoFechaLimite);
});

function cargarCbxEtapas(){
    // console.log('ingreso a cargar etapas')
    id = document.getElementById('id_servicio').value;
    cbx_etapas = document.getElementById('id_etapa');
    $.when($.ajax({
            type: "post",
            url: '/etapa/etapas-de-servicio/'+id, 
            data: {
                id: id,
            },
        success: function (response) {
            vaciarComboSinPlaceholder('id_etapa');
            vaciarComboSinPlaceholder('id_orden');
            habilitarBotonAgregarSiSeleccionado();
            response.forEach(function(opcion) { 
                var optionElement = document.createElement("option"); 
                optionElement.value = opcion.id_etapa; 
                optionElement.text = opcion.descripcion_etapa; 
                cbx_etapas.appendChild(optionElement); 
            });
        },
        error: function (error) {
            console.log(error);
        }
    }));
    
}

function cargarCbxOrdenes(){
    // console.log('ingreso a cargar orden')
    id = document.getElementById('id_etapa').value;
    cbx_ordenes = document.getElementById('id_orden');
    $.when($.ajax({
            type: "post",
            url: '/orden/obtener-ordenes-etapa/'+id, 
            data: {
                id: id,
            },
        success: function (response) {
            vaciarComboSinPlaceholder('id_orden');
            habilitarBotonAgregarSiSeleccionado();
            response.forEach(function(opcion) { 
                // console.log(opcion)
                var optionElement = document.createElement("option"); 
                optionElement.value = opcion.id_orden; 
                optionElement.text = opcion.nombre_orden; 
                cbx_ordenes.appendChild(optionElement); 
            });
        },
        error: function (error) {
            console.log(error);
        }
    }));
    
}


function modificarModalVerPartesEstadoFechaLimite(){
    id = document.getElementById('id_orden').value;
    let fecha_limite = document.getElementById('m-ver-parte-fecha-limite');
    let estado = document.getElementById('m-ver-parte-estado');
    let estado_tecnico = [1, 6, 7];
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-una-orden-etapa/'+id, 
        data: {
            
        },
    success: function (response) {
        // console.log(response)
        estado.value= response[0].id_estado;
        fecha_limite.value= response[0].fecha_limite;

        if (response[0].tec){ //Si es tecnico

            if (estado_tecnico.includes(response[0].id_estado)) { //si el estado del orden es uno de los validos para el tecnico
                document.querySelectorAll("#m-ver-parte-estado option").forEach(opt => {
                    if (!estado_tecnico.includes(parseInt(opt.value))) {
                        opt.style.display = 'none';
                    }
                });
            }
            else{
                document.querySelectorAll("#m-ver-parte-estado option").forEach(opt => {
                    if (opt.value != response[0].id_estado) {
                        opt.style.display = 'none';
                    }
                });

            }

        }
    },
    error: function (error) {
        console.log(error);
    }
    }));
    habilitarBotonAgregarSiSeleccionado();
}

function habilitarBotonAgregarSiSeleccionado() {
    const combo = document.getElementById('id_orden');
    const boton = document.getElementById('btn_agregar');

    if (combo.value !== "") {
        boton.disabled = false;
    }else{
        boton.disabled = true;
    }
}

function vaciarComboSinPlaceholder(comboId) {
    const combo = document.getElementById(comboId);

    for (let i = combo.options.length - 1; i >= 0; i--) {
        const option = combo.options[i];

        if (option.value !== "" && option.text !== "Seleccionar") {
            combo.remove(i);
        }
    }
}

function agregarRenglon(){
    const tabla = document.getElementById('accordion'); 
    const nuevaFila = tabla.insertRow(); // Añadir la primera celda 
    let html_act = '';
    let element = 'holi'
    html_act += `<tr>
                    <td class="text-center">`+element+`</td>
                    <td class="text-center">`+element+`</td>
                    <td class="text-center"><abbr title="`+element+`" style="text-decoration:none; font-variant: none;">`+element.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                    <td class="text-center">`+element+`</td>
                    <td class="text-center">`+element+`</td>
                    <td class="text-center">`+element+`</td>
                    <td class="text-center">`+element+`</td>
                    <td class="text-center">`+element+`</td>
                    <td class="text-center">`+element+`</td>
                </tr>`
    tabla.innerHTML = html_act;
}