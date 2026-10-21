// window.onload = function() {
//     changeTdColor();
// };

window.addEventListener("load", changeTdColor);
window.addEventListener("pintarTabla", changeTdColor);

function changeTdColor22() {
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
            if (values[x].children[indexColumnaEstados[y]]) {
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
            
                     if (values[x].children[indexColumnaEstados[y]].innerHTML == "Cancelado" || values[x].children[indexColumnaEstados[y]].innerHTML == "Descartar") { // check if td has desired value
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
    }
    
    //Colores de los distintos estado
    
    //--------------------------------
    calcularDiferenciaFechas();
}

function calcularDiferenciaFechas() {
    const ahora = new Date();
    const hoy = Date.UTC(ahora.getFullYear(), ahora.getMonth(), ahora.getDate());
    const normalizar = texto => texto.trim().toLowerCase().normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '').replace(/\s+/g, ' ');
    const fecha = texto => {
        const valor = texto.trim();
        let partes = valor.match(/^(\d{4})-(\d{2})-(\d{2})(?:$|[ T])/);
        if (!partes) {
            const inversa = valor.match(/^(\d{2})-(\d{2})-(\d{4})(?:$|[ T])/);
            if (!inversa) return NaN;
            partes = [inversa[0], inversa[3], inversa[2], inversa[1]];
        }
        const anio = Number(partes[1]), mes = Number(partes[2]), dia = Number(partes[3]);
        const resultado = Date.UTC(anio, mes - 1, dia);
        const validacion = new Date(resultado);
        return validacion.getUTCFullYear() === anio && validacion.getUTCMonth() === mes - 1
            && validacion.getUTCDate() === dia ? resultado : NaN;
    };
    document.querySelectorAll('table').forEach(tabla => {
        const encabezados = Array.from(tabla.querySelectorAll('thead th')).map(celda => {
            const titulo = (celda.querySelector('.dt-column-title') || celda).cloneNode(true);
            titulo.querySelectorAll('button, .dt-column-order').forEach(control => control.remove());
            return normalizar(titulo.textContent);
        });
        const limite = encabezados.indexOf('fecha limite');
        if (limite === -1) return;
        const finalizacion = encabezados.indexOf('fecha finalizacion');
        const estado = encabezados.indexOf('estado');
        Array.from(tabla.tBodies).forEach(cuerpo => {
            Array.from(cuerpo.rows).forEach(fila => {
                const celda = fila.cells[limite];
                if (!celda) return;
                const vencimiento = fecha(celda.textContent);
                celda.style.backgroundColor = '';
                celda.style.color = '';
                if (!Number.isFinite(vencimiento)) return;
                const terminada = finalizacion !== -1 && fila.cells[finalizacion]
                    && Number.isFinite(fecha(fila.cells[finalizacion].textContent));
                const completa = estado !== -1 && fila.cells[estado]
                    && normalizar(fila.cells[estado].textContent) === 'completo';
                const dias = (vencimiento - hoy) / 86400000;
                celda.style.color = '#fff';
                celda.style.backgroundColor = terminada || completa ? '#bebebe'
                    : dias >= 10 ? '#109E09' : dias <= 5 ? '#E41111' : '#E46B11';
            });
        });
    });
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

function changeTdColorOpt() {
    const tablas = document.querySelectorAll("table");

    // Diccionario de estados y colores
    const colores = {
        "Continua": "#746cd6",
        "En proceso": "#00b0f0",
        "Espera": "#ff8001",
        "Pausa": "#ffc000",
        "Externo": "#ebd577",
        "Programado": "#997339",
        "Revisar": "#d4ea00",
        "Problema": "#f8696b",
        "Cancelado": "#d2cab5",
        "Descartar": "#d2cab5",
        "Completo": "#92d050",
        "Planos entregados": "#997339",
        "Orden creada": "#997339",
        "Piezas en fabricacion": "#ff8001",
        "Piezas listas": "#00b0f0",
        "Ajuste listo": "#d4ea00",
        "Ensamble listo": "#92d050",
        "Material encargado": "#ff8001",
        "Material preparado": "#00b0f0",
        "Mecanizado completo": "#d4ea00",
        "Pieza finalizada": "#92d050",
        "Temple": "#ebd577",
        "A Evaluar": "#d1d424",
        "Rechazado": "#d2cab5",
        "Aceptado": "#92d050"
    };

    // Recorrer todas las tablasy
    tablas.forEach((tabla) => {
        const filas = tabla.querySelectorAll("tr");
        let indexColEstado = -1;

        // Buscar la columna "Estado"
        for (let i = 0; i < filas.length; i++) {
            const celdas = filas[i].children;
            for (let j = 0; j < celdas.length; j++) {
                if (celdas[j].innerText.trim() === "Estado") {
                    indexColEstado = j;

                    // Recorremos las filas siguientes (datos)
                    for (let k = i + 1; k < filas.length; k++) {
                        const celda = filas[k].children[indexColEstado];
                        if (!celda) continue;

                        const valor = celda.innerText.trim();
                        celda.style.color = "#fff";

                        if (colores[valor]) {
                            celda.style.backgroundColor = colores[valor];
                        }
                    }

                    break; // una vez que encontramos "Estado", no seguimos buscando más encabezados
                }
            }

            if (indexColEstado !== -1) break;
        }
    });

    calcularDiferenciaFechas(); // Tu función externa
}

function changeTdColor() {
    const tablas = document.querySelectorAll("table");

    // Diccionario de estados y colores
    const colores = {
        "Continua": "#746cd6",
        "En proceso": "#00b0f0",
        "Espera": "#ff8001",
        "Pausa": "#ffc000",
        "Externo": "#ebd577",
        "Programado": "#997339",
        "Revisar": "#d4ea00",
        "Problema": "#f8696b",
        "Cancelado": "#d2cab5",
        "Descartar": "#d2cab5",
        "Completo": "#92d050",
        "Planos entregados": "#997339",
        "Orden creada": "#997339",
        "Piezas en fabricacion": "#ff8001",
        "Piezas listas": "#00b0f0",
        "Ajuste listo": "#d4ea00",
        "Ensamble listo": "#92d050",
        "Material encargado": "#ff8001",
        "Material preparado": "#00b0f0",
        "Mecanizado completo": "#d4ea00",
        "Pieza finalizada": "#92d050",
        "Temple": "#ebd577",
        "A Evaluar": "#d1d424",
        "Rechazado": "#d2cab5",
        "Aceptado": "#92d050",
        "Disponible": "#5d8d2a",
    };

    // Recorrer todas las tablas
    tablas.forEach((tabla) => {
        const filas = tabla.querySelectorAll("tr");

        // Buscar todas las columnas que contengan "Estado" en el encabezado
        const columnasEstado = [];

        for (let i = 0; i < filas.length; i++) {
            const celdas = filas[i].children;
            for (let j = 0; j < celdas.length; j++) {
                const texto = celdas[j].innerText.trim().toLowerCase();
                if (texto.includes("estado")) {
                    columnasEstado.push({colIndex: j, headerRow: i});
                }
            }
            if (columnasEstado.length > 0) break; // Solo necesitamos la primera fila de encabezados
        }

        // Pintar cada columna de estado
        columnasEstado.forEach(({colIndex, headerRow}) => {
            for (let k = headerRow + 1; k < filas.length; k++) {
                const celda = filas[k].children[colIndex];
                if (!celda) continue;

                const valor = celda.innerText.trim();
                celda.style.color = "#fff";

                if (colores[valor]) {
                    celda.style.backgroundColor = colores[valor];
                }
            }
        });
    });

    // Llamada a tu función externa
    calcularDiferenciaFechas();
}
