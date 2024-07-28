// window.onload = function() {
//     changeTdColor();
// };

window.addEventListener("load", changeTdColor);
window.addEventListener("pintarTabla", changeTdColor);

function changeTdColor() {
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
                       
                  
                     //----------------
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Planos entregados") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#997339"; // if matches, change color
                     }
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Orden creada") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#997339"; // if matches, change color
                     }
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Piezas en fabricacion") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#ff8001"; // if matches, change color
                     }
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Piezas listas") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#00b0f0"; // if matches, change color
                     }
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Ajuste listo") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#d4ea00"; // if matches, change color
                     }
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Ensamble listo") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#92d050"; // if matches, change color
                     }
                     //-----------------
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Material encargado") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#ff8001"; // if matches, change color
                     }
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Material preparado") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#00b0f0"; // if matches, change color
                     }
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Mecanizado completo") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#d4ea00"; // if matches, change color
                     }
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Pieza finalizada") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#92d050"; // if matches, change color
                     }
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Temple") { // check if td has desired value
                         values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#ebd577"; // if matches, change color
                     }

                    //----------------
                    if (values[x].children[indexColumnaEstados[y]].innerHTML == "A Evaluar") { // check if td has desired value
                        values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#d1d424"; // if matches, change color
                    }
                    if (values[x].children[indexColumnaEstados[y]].innerHTML == "Rechazado") { // check if td has desired value
                        values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#d2cab5"; // if matches, change color
                    }
                    if (values[x].children[indexColumnaEstados[y]].innerHTML == "Aceptado") { // check if td has desired value
                        values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#92d050"; // if matches, change color
                    }
        }
    }
    
    //Colores de los distintos estado
    
    //--------------------------------
    calcularDiferenciaFechas();
}

function calcularDiferenciaFechas(){
    let fecha_hoy = new Date();
    let mes = fecha_hoy.getMonth() + 1;
    let str_fechahoy = fecha_hoy.getFullYear()+'-'+mes+'-'+fecha_hoy.getDate();
    str_fechahoy = str_fechahoy.toString();
    const values = document.querySelectorAll("tr");
    var fechaHoy = new Date(str_fechahoy).getTime();
    var fechaFinalizacion;
    var estado;
    var text_fecha_fin = "Fecha finalizacion";
    var indexColumnaFechaFinalizacion = [];
    
    
    var text_var = "Fecha limite"
    var elem = $('th').filter(function() {
        return $(this).text().trim() == text_var;
        });
    var row_index_first = elem.index();
    var row_index_first = elem.index();
    var indexFilaEncabezados = [];
    var indexColumnaFechaLimite = [];
    for (let x = 0; x < values.length; x++) {
        for (let y = 0; y < values[x].cells.length; y++) {
            if(values[x].cells[y].innerText == text_var){
                indexFilaEncabezados.push(x);
            }
        }
    }
    
    indexFilaEncabezados.push(values.length);
    indexColumnaFechaLimite = dameIndexColumnas(values, indexFilaEncabezados, text_var);
    indexColumnaFechaFinalizacion = dameIndexColumnas(values, indexFilaEncabezados, text_fecha_fin);
    indexColumnaEstados = dameIndexColumnas(values, indexFilaEncabezados, "Estado");

    for (let y = 0; y < indexColumnaFechaLimite.length; y++) {
        for (let x = indexFilaEncabezados[y]; x < indexFilaEncabezados[y+1]; x++) { // iterate all thorugh td
            values[x].children[indexColumnaFechaLimite[y]].style.color = "#fff";
            fechaLimite = new Date(values[x].children[indexColumnaFechaLimite[y]].innerHTML).getTime();
            try {
                fechaFinalizacion = new Date(values[x].children[indexColumnaFechaFinalizacion[y]].innerHTML).getTime();                
            } catch (error) {

            }            
            estado = values[x].children[indexColumnaEstados[y]].innerHTML
            diff = fechaLimite - fechaHoy;
            diasDife = diff/(1000*60*60*24);
            if(fechaFinalizacion || estado =='Completo'){
                values[x].children[indexColumnaFechaLimite[y]].style.backgroundColor = "#bebebe";
               
            }else{
                if (diasDife >= 10) {
                    values[x].children[indexColumnaFechaLimite[y]].style.backgroundColor = "#109E09";
                }

                if (diasDife < 10) {
                    values[x].children[indexColumnaFechaLimite[y]].style.backgroundColor = "#E46B11";
                }

                if (diasDife <= 5) {
                    values[x].children[indexColumnaFechaLimite[y]].style.backgroundColor = "#E41111";
                }
            }
        }
    }
    //--------------------------------
}

function castDate(str_fecha){
        str_fecha = str_fecha.replaceAll('-','');
        let dia = str_fecha.substring(0, 2);
        let mes = str_fecha.substring(2, 4);
        let anio = str_fecha.substring(4, 8);
        return anio+'-'+mes+'-'+dia;
}

function dameIndexColumnas(trValues,indexFilaEncabezados, text_encabezado){
    var indexColumnas = []
    indexFilaEncabezados.forEach(element => {
        try{
            for (let x = 0; x < trValues[element].cells.length; x++) {
                if(trValues[element].cells[x].innerText == text_encabezado){
                    indexColumnas.push(x)
                }
            }
        }catch{

        }
    });
    //console.log(text_encabezado)
    //console.log(indexFilaEncabezados)
    //console.log(indexColumnas)
    return indexColumnas;
}

function changeInteresColor() {
    const values = document.querySelectorAll("tr");
    var text_var = "Interes"
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
            if (values[x].children[indexColumnaEstados[y]].innerHTML >= 1 && values[x].children[indexColumnaEstados[y]].innerHTML < 8) { // check if td has desired value
                values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#e41111"; // if matches, change color
            }

            if (values[x].children[indexColumnaEstados[y]].innerHTML >= 8 && values[x].children[indexColumnaEstados[y]].innerHTML < 13) { // check if td has desired value
                values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#ff8001"; // if matches, change color
            }

            if (values[x].children[indexColumnaEstados[y]].innerHTML >= 13 && values[x].children[indexColumnaEstados[y]].innerHTML < 15) { // check if td has desired value
                values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#ffc000"; // if matches, change color
            }

            if (values[x].children[indexColumnaEstados[y]].innerHTML >= 15 && values[x].children[indexColumnaEstados[y]].innerHTML < 20) { // check if td has desired value
                values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#109e09"; // if matches, change color
            }

            if (values[x].children[indexColumnaEstados[y]].innerHTML >= 20) { // check if td has desired value
                values[x].children[indexColumnaEstados[y]].style.backgroundColor = "#109e09"; // if matches, change color
            }
        }
    }
}