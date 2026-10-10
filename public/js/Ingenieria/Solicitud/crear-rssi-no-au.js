$(function(){
    $('#selected-prioridad').on('change', agregarUrgencia);
    $('#activo').on('change', cargarSintomas);
});

function agregarUrgencia(){
    let prioridad = Number($(this).val());
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
                        <textarea name="descripcion_urgencia" id="descrip" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 25vh" required></textarea>
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
                if (Object.keys(res).length === 0) {
                    html = `<div class="col-12 d-flex justify-content-center">
                                <div id="msj-sin-sintomas">
                                    <strong>
                                        <span style="border:1px solid red; background:white; color:red; padding:10px;">
                                            &nbsp; El activo no posee síntomas asociados. &nbsp;
                                        </span>
                                    </strong>
                                </div>
                            </div>`;
                } else {
                    const sintomas = Object.values(res)
                        .flatMap(infoTipo => infoTipo.sintomas)
                        .sort((a, b) => a.nombre.localeCompare(b.nombre, 'es', { sensitivity: 'base' }));
                    let html_sintomas = '';
                    sintomas.forEach(s => {
                        html_sintomas += `<label class="mb-0"><input name="sintomas[]" type="checkbox" value="${s.id}"> ${s.nombre}</label>`;
                    });

                    html += `<div class="col-12">
                                <div class="card-body overflow-auto" style="max-height: 200px;">
                                    <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 8px 16px; overflow-wrap: anywhere;">
                                        ${html_sintomas}
                                    </div>
                                </div>
                            </div>`;
                }

                document.getElementById('sintomas-activo').innerHTML = html;
            },
            error: function (error) {
                console.log(error);
            }
    });
}
