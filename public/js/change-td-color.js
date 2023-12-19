// window.onload = function() {
//     changeTdColor();
// };

window.addEventListener("load", changeTdColor);



function changeTdColor() {
    const values = document.querySelectorAll("tr");
    
    var text_var = "Estado"
    var elem = $('th').filter(function() {
        return $(this).text().trim() == text_var;
        });
    var row_index_first = elem.index();

    // console.log(row_index_first);

    // console.log(values[1].children[5].innerHTML);

    //Colores de los distintos estado
    for (let i = 0; i < values.length; i++) { // iterate all thorugh td
        values[i].children[row_index_first].style.color = "#fff";
        if (values[i].children[row_index_first].innerHTML == "Cancelado") { // check if td has desired value
          values[i].children[row_index_first].style.backgroundColor = "#FF160B"; // if matches, change color
        }
        if (values[i].children[row_index_first].innerHTML == "Completo") { // check if td has desired value
            values[i].children[row_index_first].style.backgroundColor = "#15B218"; // if matches, change color
        }
        if (values[i].children[row_index_first].innerHTML == "Continua") { // check if td has desired value
            values[i].children[row_index_first].style.backgroundColor = "#4E0DC8"; // if matches, change color
        }
        if (values[i].children[row_index_first].innerHTML == "En proceso") { // check if td has desired value
            values[i].children[row_index_first].style.backgroundColor = "#48F1D3"; // if matches, change color
        }
        if (values[i].children[row_index_first].innerHTML == "Espera") { // check if td has desired value
            values[i].children[row_index_first].style.backgroundColor = "#FA7D0D"; // if matches, change color
        }
        if (values[i].children[row_index_first].innerHTML == "Externo") { // check if td has desired value
            values[i].children[row_index_first].style.backgroundColor = "#F9CB24"; // if matches, change color
        }
        if (values[i].children[row_index_first].innerHTML == "Pausa") { // check if td has desired value
            values[i].children[row_index_first].style.backgroundColor = "#F9CB24"; // if matches, change color
        }
        if (values[i].children[row_index_first].innerHTML == "Problema") { // check if td has desired value
            values[i].children[row_index_first].style.backgroundColor = "#FF160B"; // if matches, change color
        }
        if (values[i].children[row_index_first].innerHTML == "Revisar") { // check if td has desired value
            values[i].children[row_index_first].style.backgroundColor = "#CFFF0B"; // if matches, change color
        }
    }
    //--------------------------------
    calcularDiferenciaFechas();
}

function calcularDiferenciaFechas(){
    let fecha_hoy = new Date();
    let mes = fecha_hoy.getMonth() + 1;
    let str_fechahoy = fecha_hoy.getFullYear()+'-'+mes+'-'+fecha_hoy.getDate();
    str_fechahoy = str_fechahoy.toString();

    var fechaInicio = new Date(str_fechahoy).getTime();

    const values = document.querySelectorAll("tr");
    
    var text_var = "Fecha limite"
    var elem = $('th').filter(function() {
        return $(this).text().trim() == text_var;
        });
    var row_index_first = elem.index();

    //Colores de los distintos estado
    for (let i = 1; i < values.length; i++) { // iterate all thorugh td
        values[i].children[row_index_first].style.color = "#fff";
        fechaFin    = new Date(castDate(values[i].children[row_index_first].innerHTML)).getTime();
        diff = fechaFin - fechaInicio;
        diasDife = diff/(1000*60*60*24);

        if (diasDife >= 10) {
            values[i].children[row_index_first].style.backgroundColor = "#109E09";
        }

        if (diasDife < 10) {
            values[i].children[row_index_first].style.backgroundColor = "#E46B11";
        }

        if (diasDife <= 5) {
            values[i].children[row_index_first].style.backgroundColor = "#E41111";
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

