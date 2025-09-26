$(document).ready(function () { 
    
});

function cargarOperaciones(id) {
    let body_tb = document.getElementById('body_ope');
    body_tb.innerHTML = '';
    let fila_ope = '';
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-ope-hdr', 
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            response.forEach((op) => {

                if (op.activo != 1) {
                    tr = '<tr>'
                } else {
                    tr = '<tr style="background-color: #d3fccf">'
                }
                fila_ope += tr+`
                                    <td class= 'text-center' style="vertical-align: middle;">${op.id_hoja_de_ruta}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.numero}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.fecha ?? '-'}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.ultimo_res ?? '-'}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.codigo_maquinaria ?? '-'}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.nombre_operacion}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.nombre_estado_hdr}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.total_horas}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.medidas}</td>
                                    <td class='text-center' style="vertical-align: middle;">
                                        
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesOpeHdrModal" onclick="cargarModalVerPartesOpe(${op.id_ope_de_hdr})">
                                                            Partes
                                                        </button>
                                                    </div>
                                                
                                    </td>
                                </tr>
                                `; 
            });
            body_tb.innerHTML += fila_ope;
            changeTdColor();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarModalCrearHDR(id, orden, sup){
    // console.log(id, orden, sup);
    document.getElementById('m_id_pieza').value = orden;
    document.getElementById('m_confec').value = sup;
    let select_hdr = document.getElementById('m-hdr-ant');
    select_hdr.innerHTML = '';
    let html_hdr = '<option selected="selected" value="">Seleccionar</option>';
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-hdr-ant/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response)
            
            response.forEach(element => {
                html_hdr += `
                                    <option value="`+element.id_hoja_de_ruta+`">Cod: `+element.id_hoja_de_ruta+` Fecha: `+element.fecha_carga
                                    +`</option> 
                                    `
            });
            select_hdr.innerHTML += html_hdr;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarModalVerPartesOpe(id){
    let html = '';
    obtenerEstados(5);
    document.getElementById('m-id-ope-hdr').value = id;
    
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-hdr-parte/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response)
            let ultParte = response.partes_ope.length - 1;
            let idCount = 0;
            response.partes_ope.forEach(element => {
                html += `<tr>
                        <td class="text-center">`+element.id_parte+`</td>
                        <td class="text-center">`+element.fecha+`</td>
                        <td class="text-center">`+element.estado+`</td>
                        <td class="text-center">`+element.horas+`</td>
                        <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                        <td class="text-center">`+element.responsable+`</td>
                        <td class="text-center">`+element.medidas+`</td>
                        <td class="text-center">
                            <div class="row justify-content-center" >
                                <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes`+idCount+`" aria-expanded="false" aria-controls="collapseOrdenes`+idCount+`">
                                    Opciones
                                </button>
                            </div>
                            <div class="collapse" data-bs-parent="#body_ver_parte_ope" id="collapseOrdenes`+idCount+`">
                                <div class="row">
                                    <div class="col-12 my-1">
                                        <button type="button" class="btn btn-primary w-100" onclick="editarParte(`+element.id_parte+`)">
                                            Editar
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                </div>
                            </div>
                        </td>
                    </tr>`
                idCount ++;
            });

            if (response.medida_chk) {
                document.getElementById('section-medida').hidden = true;
            } else {
                document.getElementById('section-medida').hidden = false;
            }
            document.getElementById('body_ver_parte_ope').innerHTML = html;
            document.getElementById('mv-operacion').value = response.partes_ope[0].operacion;
            document.getElementById('mv-ord-mec').value = response.partes_ope[0].orden_mec;
            document.getElementById('mv-estado').value = response.partes_ope[0].estado;
            document.getElementById('m-ver-parte-estado').value = response.partes_ope[ultParte].id_estado;
            obtenerMaquinasPorOpe(response.partes_ope[0].id_operacion);
    },
    complete: function(){
        changeTdColor();
    },
    error: function (error) {
        console.log(error);
    }
    });
}

function obtenerMaquinasPorOpe(id){
    let select_maquinas = document.getElementById('m-ver-parte-maquina');
    select_maquinas.innerHTML = '<option value="">Seleccionar</option>';
    html_maquinas = '';
    let select_maq = null;
    $.ajax({
        type: "post",
        url: '/operacion/obtener-maquinas-ope-de/'+id, 
        data: {
        },
        success: function (res) {
            if (res.length == 1) {
                select_maq = 'selected';
            }

            res.forEach(element => {
                html_maquinas += `
                                    <option value="`+element.id_maquinaria+`" ${select_maq}>`+element.codigo_maquinaria
                                    +`</option> 
                                    `
            });
            select_maquinas.innerHTML += html_maquinas;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function obtenerEstados(opcion){
    let select_estados = document.getElementById('m-ver-parte-estado');
    select_estados.innerHTML = '<option value="">Seleccionar</option>';
    html_estados = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-estados-de/'+opcion, 
        data: {
            
        },
    success: function (response) {
        // console.log(response);
        response.forEach(element => {
            html_estados += `
                                <option value="`+element.id_estado+`">`+element.nombre
                                +`</option> 
                                `
        });
        select_estados.innerHTML += html_estados;
    /* c_bx_estados_man != '' ? c_bx_estados_man.innerHTML += html_estados_man : '';
        c_bx_estados_man_edit != '' ? c_bx_estados_man_edit.innerHTML += html_estados_man : ''; */
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

function cargarHdrReiniciar(id){
    document.getElementById('m_re_idhdr').value = id;
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-hdr/'+id, // Ruta para obtener las máquinas
        data: { id: id },
        success: function (response) {
            // console.log(response);
            document.getElementById('m_re_ubi').value = response.ubicacion;
            document.getElementById('m_re_cant').value = response.cantidad;
            document.getElementById('m_re_ruta').value = response.ruta;
            document.getElementById('m_re-obser').value = response.observaciones;
            document.getElementById('re_table-body').innerHTML = '';

            response.operaciones.forEach(function (op) {
                addRowRe().then((nuevaFila) => {
                    nuevaFila.querySelector(".input-ope").value = op.operacion;
                    nuevaFila.querySelector(".input-asig").value = op.asignado;
                    nuevaFila.querySelector(".input-maquina").value = op.maquina === '-' ? null : op.maquina;
                });
            });
            /*response.operaciones.forEach(function (op){
                console.log(op);
                const nuevaFila = addRowRe();

                // Esperar un breve momento para que la fila se agregue
                setTimeout(() => {
                    // console.log(nuevaFila)
                    nuevaFila.querySelector(".input-ope").value = op.operacion;
                    nuevaFila.querySelector(".input-asig").value = op.asignado;
                    nuevaFila.querySelector(".input-maquina").value = op.maquina == '-' ? null : op.maquina;
                }, 100);
            });*/
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarHdrVer(id){
    let html = '';
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-hdr/'+id,
        data: { id: id },
        success: function (response) {
            document.getElementById('m_ver_ubi').value = response.ubicacion;
            document.getElementById('m_ver_cant').value = response.cantidad;
            document.getElementById('m_ver_ruta').value = response.ruta;
            document.getElementById('m_ver-obser').value = response.observaciones;
            document.getElementById('m_ver-obser-razon').value = response.obser_fallo;

            if (response.obser_fallo) {
                document.getElementById('obser-fallo').hidden = false;
            }

            document.getElementById('ver-table-body').innerHTML = '';
            response.operaciones.forEach(function (op){
                html += `<tr>
                        <td class="text-center">`+1+`</td>
                        <td class="text-center">`+op.operacion+`</td>
                        <td class="text-center">`+op.asignado+`</td>
                        <td class="text-center">`+op.maquina ?? '-'+`</td>
                    </tr>`
            });
            document.getElementById('ver-table-body').innerHTML = html;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarHdrEdit(id){
    document.getElementById('m_edi_idhdr').value = id;
    limpiarModalHdrEdit();
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-hdr/'+id, // Ruta para obtener las máquinas
        data: { id: id },
        success: function (response) {
            // console.log(response);
            document.getElementById('m_edi_ubi').value = response.ubicacion;
            document.getElementById('m_edi_cant').value = response.cantidad;
            document.getElementById('m_edi_ruta').value = response.ruta;
            document.getElementById('m_edi-obser').value = response.observaciones;
            document.getElementById('edi_table-body').innerHTML = '';

            response.operaciones.forEach(function (op) {
                addRowEdi().then((nuevaFila) => {
                    nuevaFila.querySelector(".input-ope").value = op.operacion;
                    nuevaFila.querySelector(".input-asig").value = op.asignado;
                    nuevaFila.querySelector(".input-maquina").value = op.maquina === '-' ? null : op.maquina;
                });
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function limpiarModalHdrEdit(){
    document.getElementById('m_edi_ubi').value = null;
    document.getElementById('m_edi_cant').value = null;
    document.getElementById('m_edi_ruta').value = null;
    document.getElementById('m_edi-obser').value = null;
    document.getElementById('edi_table-body').innerHTML = '';
}