$(function(){
    $('#selected-prioridad').on('change', agregarUrgencia);
    // $('#ssi-mant-activo').on('change', cargarSintomas);
    $('#activo').on('change', cargarSintomas);
});

function agregarUrgencia(){
    let prioridad = Number($(this).val());
    // console.log(prioridad);
    let des = document.getElementById("descrip_urgencia");
    let fec = document.getElementById("fecha_req");
   let fecha_de_hoy = new Date(Date.now()).toISOString().split('T')[0];
    switch (prioridad) {
        case 1:
            fec.innerHTML = '';
            des.innerHTML = '';
            break;
        case 2:
            html_fecha = `<div class="form-group">
                            <label for="fec_req" class="control-label fs-7 reset-fecha" style="white-space: nowrap;">Fecha requerida:</label>
                            <span class="obligatorio">*</span>
                            <input min="2023-01-01" max="2023-12" id="fec_req" class="form-control reset-fecha" name="fecha_req" type="date" value=`+fecha_de_hoy+` required> 
                        </div>`;
            fec.innerHTML = html_fecha;
            des.innerHTML = '';
            break;
        case 3:
            html = `<div class="form-group"> 
                        <label for="descrip" class="control-label fs-7 " style="white-space: nowrap; ">Descripcion de la urgencia:</label>
                        <span class="obligatorio">*</span>
                        <textarea name="descripcion_urgencia" id="descrip" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 40vh" required></textarea>
                    </div>`;
            html_fecha = `<div class="form-group">
                    <label for="fec_req" class="control-label fs-7 reset-fecha" style="white-space: nowrap;">Fecha requerida:</label>
                    <span class="obligatorio">*</span>
                    <input min="2023-01-01" max="2023-12" id="fec_req" class="form-control reset-fecha" name="fecha_req" type="date" value=`+fecha_de_hoy+` required> 
                </div>`;
            fec.innerHTML = html_fecha;
            des.innerHTML = html;
            break;
         
        default:
            fec.innerHTML = '';
            des.innerHTML = '';
            break;
    }
}

let enviando = false;

document.getElementById('btn-guardar').addEventListener('click', function () {

    if (enviando) return;

    let tabActiva = document.querySelector('.tab-pane.active');
    let form = null;

    if (tabActiva.id === 'asistencia') {
        form = document.getElementById('form-asistencia');
    }

    if (tabActiva.id === 'mantenimiento') {
        form = document.getElementById('form-mantenimiento');
    }

    if (!form) return;

    if (form.id === 'form-mantenimiento') {
        const checkeados = form.querySelectorAll('input[name="sintomas[]"]:checked');

        if (checkeados.length === 0) {
            alert('Debe seleccionar al menos un síntoma.');
            return;
        }
    }

    enviando = true;

    this.disabled = true;
    this.innerHTML = 'Guardando...';

    form.requestSubmit(); // ✅ clave
});

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('invalid', () => {
        enviando = false;
        const btn = document.getElementById('btn-guardar');
        btn.disabled = false;
        btn.innerHTML = 'Guardar';
    }, true);
});

function cargarSintomas(){
    let activo = Number($(this).val());
    document.getElementById('sintomas-activo').innerHTML = '';
    let html = '';

    if (activo) {
        document.getElementById('row-sintomas').hidden = false;
    } else {
        document.getElementById('row-sintomas').hidden = true;
    }
    
    $.ajax({
            type: "post",
            url: 's_m_a/'+activo+'/cargar-causas', 
            success: function (res) {
                console.log(res);
                if (Object.keys(res).length === 0) {
                    html = `<div class="col-12 d-flex justify-content-center">
                                <div id="msj-sin-sintomas">
                                    <strong>
                                        <span style="border:1px solid red; background:white; color:red; padding:10px;">
                                            &nbsp; El tipo de activo no posee síntomas asociados. &nbsp;
                                        </span>
                                    </strong>
                                </div>
                            </div>`;
                } else {
                    Object.entries(res).forEach(([idTipo, infoTipo]) => {
                        let html_sintomas = '';
                        infoTipo.sintomas.forEach(s => {
                            html_sintomas += `<label class="ms-3"><input class="" name="sintomas[]" type="checkbox" value="${s.id}"> ${s.nombre}</label>`
                        });

                        html += `<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="row">
                                                <div class="d-flex flex-row align-items-start justify-content-around">
                                                    <div class="card-body d-flex flex-column" style="height: 200px;">
                                                        <div class="">
                                                            <label>${infoTipo.tipo}:</label>
                                                        </div>
                                                        <div class="d-flex flex-column overflow-auto">
                                                            ${html_sintomas}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`
                    });
                }

                document.getElementById('sintomas-activo').innerHTML = html;
            },
            error: function (error) {
                console.log(error);
            }
    });
}
