function cargarModalProgresoServicio(id){
    // console.log('hola');
    let codigo = document.getElementById('cod_serv_input');
    let nombre = document.getElementById('nom_serv_input');
    let lider = document.getElementById('lider_input');
    let fec_ini = document.getElementById('fec_ini_input');
    let fec_lim = document.getElementById('fec_lim_input');
    let estado = document.getElementById('est_input');
    let btn_gest = document.getElementById('btn-avance-gest');
    let div_cuadro_etapas = document.getElementById("cuadro-ver-etapas");
    let html_etapa = '';
    let barra_progreso = document.getElementById('barra-progreso');
    let numero_progreso = document.getElementById('numero-progreso');

    $.when($.ajax({
        type: "post",
        url: '/solicitud/obtener-datos-proyecto/'+id,
        data: {
            id: id,
        },
        success: function (response) {
            codigo.value = response.cod_serv;
            nombre.value = response.nom_serv;
            lider.value = response.lider;
            fec_ini.value = response.fec_ini;
            fec_lim.value = response.fec_lim;
            estado.value = response.estado;

            try {
                btn_gest.href = window.location.protocol + "//" + window.location.host +"/proyectos/gestionar/"+ response.id_serv;
            } catch (error) {
                
            }
    
            barra_progreso.style.width = response.progreso+'%';
            numero_progreso.innerHTML = response.progreso+'%';
            response.etapas.forEach(element => {
                // console.log(element);
                html_etapa += `<tr>
                                    <td class= "text-center"> `+element.descripcion_etapa+`</td> 
                                    <td class= "text-center">`+element.nombre_estado+`</td> 
                                    <td class= "text-center">`+element.fecha_inicio+`</td>
                                    <td class= "text-center">`+element.fecha_limite+`</td>
                                    <td class= "text-center">
                                        <div class="progress position-relative" style="background-color: #b2baf8">
                                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: `+element.progreso+`%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">`+element.progreso+`% </span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                </tr>`;
            });

            div_cuadro_etapas.innerHTML = html_etapa;
            changeTdColor();
            // changeColorEt();
        },
        error: function (error) {
            console.log(error);
        }
    }));
}

function limpiarModal(){
    let codigo = document.getElementById('cod_serv_input');
    let nombre = document.getElementById('nom_serv_input');
    let lider = document.getElementById('lider_input');
    let fec_ini = document.getElementById('fec_ini_input');
    let fec_lim = document.getElementById('fec_lim_input');
    let estado = document.getElementById('est_input');
    let div_cuadro_etapas = document.getElementById("cuadro-ver-etapas");
    let barra_progreso = document.getElementById('barra-progreso');
    let numero_progreso = document.getElementById('numero-progreso');

    codigo.value = "-";
    nombre.value = "-";
    lider.value = "-";
    fec_ini.value = "-";
    fec_lim.value = "-";
    estado.value = "-";
    barra_progreso.style.width = 0+'%';
    numero_progreso.innerHTML = 0+'%';
    div_cuadro_etapas.innerHTML = '';
}

function changeColorEt(){
    const values = document.querySelectorAll("tr");
    var text_var = "Estado"
    //var elem = $('th').filter(function() {
    //    return $(this).text().trim() == text_var;
    //    });
    //var row_index_first = elem.index();
    var indexFilaEncabezados = [];
    var indexColumnaEstados = []
    for (let x = 0; x < values.length; x++) {
        for (let y = 0; y < values[x].cells.length; y++) {
            if(values[x].cells[y].innerText == text_var){
                indexFilaEncabezados.push(x);
            }
        }
    }

    indexFilaEncabezados.push(values.length);
    indexColumnaEstados = dameIndexColumnas(values,indexFilaEncabezados, text_var);

    for (let y = 0; y < indexColumnaEstados.length; y++) {
        for (let x = indexFilaEncabezados[y]; x < indexFilaEncabezados[y+1]; x++) {
            values[x].children[indexColumnaEstados[y]].style.color = "#fff";
            if (values[x].children[indexColumnaEstados[y]].innerHTML == "Continua") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#746cd6"; // if matches, change color
                     }
            
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "En proceso") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#00b0f0"; // if matches, change color
                     }
            
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Espera") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#ff8001"; // if matches, change color
                     }
            
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Pausa") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#ffc000"; // if matches, change color
                     }
            
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Externo") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#ebd577"; // if matches, change color
                     }
            
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Programado") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#997339"; // if matches, change color
                     }
            
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Revisar") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#d4ea00"; // if matches, change color
                     }
            
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Problema") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#f8696b"; // if matches, change color
                     }
            
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Cancelado") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#d2cab5"; // if matches, change color
                     }
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Completo") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#92d050"; // if matches, change color
                     }
                       
        }
    }
}