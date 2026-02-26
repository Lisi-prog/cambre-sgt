document.getElementById("formulario_informe").addEventListener("submit", function(e) {
    e.preventDefault();

    var url_php = $(this).attr("action"); 
    var type_method = $(this).attr("method"); 
    var form_data = $(this).serialize();

    $("#loading").show();
    $.ajax({
        type: type_method,
        url: url_php,
        data: form_data,
        timeout: 60000, // 60 segundos de espera
        success: function(res) {
            console.log(res);
            document.getElementById('ver-informes').hidden = true;
            document.getElementById('ver-informes-sin-datos').hidden = true;

            if (res.vacio == 0) {
                document.getElementById('ver-informes').hidden = false;

                document.getElementById('fec_ini_pdf').value = res.data.fecha_desde;
                document.getElementById('fec_fin_pdf').value = res.data.fecha_hasta;
                document.getElementById('id_tecnico_pdf').value = res.data.empleadoId;

                let trProyAv = '';
                let trEmpAv = '';
                let avPorSubord = '';
                let grafico = `<div class="" style="width: 30vw; height: 20vw; position: relative;">
                                    <img src="${res.data.chart}" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                </div>`;

                res.data.info.sort((a, b) => b.porcentaje - a.porcentaje).forEach(e => {
                    trProyAv += `<tr style="">
                                    <td class='text-end' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${e.codigo_servicio}</td>
                                                                        
                                    <td class='text-center' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${e.h_total}</td>
                                                                        
                                    <td class='text-center' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${e.porcentaje}%</td>
                                                                        
                                </tr>`;
                });

                res.data.datos_sub.sort((a, b) => a.name.localeCompare(b.name)).forEach(e => {
                    let trInfoSub = '';

                    trEmpAv += `<tr style="">
                                    <td class='text-end' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${e.name}</td>
                                                                        
                                    <td class='text-center' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${e.total_horas}</td>
                                                                        
                                </tr>`;
                    if (Number(e.total_horas) != 0) {
                        

                        e.info.forEach( i => {
                                trInfoSub += `<tr style="">
                                        <td class='text-end' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${i.codigo_servicio}</td>
                                                                            
                                        <td class='text-center' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${i.h_total}</td>

                                        <td class='text-center' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${i.porcentaje}%</td>
                                                                            
                                    </tr>`
                        })
                        
                        avPorSubord += `<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <div class="row border">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                                    <label class="control-label fs-7" style="white-space: nowrap; ">${e.name}</label>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="" style="width: 18vw; margin: auto;">
                                                        <img src="${e.chart}" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <table style="width: 100%">
                                                        <thead style="">
                                                            <th class='ml-3 text-center' style="color:#000; border: 1px solid #000; border-spacing: 0;">Proyecto</th>
                                                            <th class='text-center' style="color:#000; border: 1px solid #000; border-spacing: 0;">Horas</th>
                                                            <th class='text-center' style="color:#000; border: 1px solid #000; border-spacing: 0;">Porcentaje</th>
                                                        </thead>
                                                        <tbody>
                                                            ${trInfoSub}
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mt-2">
                                                    <h5>Total Hs: <strong>${e.total_horas}</strong></h5>
                                                </div>
                                            </div>
                                        </div>`;
                    }
                });

                document.getElementById('vista-grafico').innerHTML = `
                                                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-center border border-secondary">
                                                                        <div class="row">
                                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mt-2">
                                                                                <h3>Avance Supervisor</h3>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                                <label class="control-label fs-7" style="white-space: nowrap; ">Grafico:</label>
                                                                                ${grafico}
                                                                            </div>
                                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                                <label class="control-label fs-7" style="white-space: nowrap; ">Avance Proyectos:</label>
                                                                                <table>
                                                                                    <thead style="height:50px;">
                                                                                        <th class='ml-3 text-center' style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Proyecto</th>
                                                                                        <th class='text-center' style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Horas</th>
                                                                                        <th class='text-center' style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Porcentaje</th>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        ${trProyAv}
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mt-4">
                                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                                                                <h3>Total Hs: ${res.data.total_horas}</h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 border border-start-0 border-secondary">
                                                                        <div class="row">
                                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mt-2">
                                                                                <h3>Avance Subordinados</h3>
                                                                            </div>
                                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                                <label class="control-label fs-7" style="white-space: nowrap; ">Avance Subordinados:</label>
                                                                                <table>
                                                                                    <thead style="height:50px;">
                                                                                        <th class='ml-3 text-center' style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Empleado</th>
                                                                                        <th class='text-center' style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Horas</th>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        ${trEmpAv}
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                `;

                document.getElementById('avance-subor').innerHTML = avPorSubord;   
            } else {
                document.getElementById('ver-informes-sin-datos').hidden = false;
            }                                                     
        },
        complete: function() {
            $("#loading").hide(); 
        },
        error: function(jqXHR, textStatus) {
            $("#loading").hide();
            if (textStatus === "timeout") {
                alert("La generacion del informe tardo demaciado.");
            } else {
                alert("Error en la solicitud: " + textStatus);
            }
        }
    });
});