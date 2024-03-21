$(function(){
    $('#selected-prioridad').on('change', agregarUrgencia);
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
                            <input min="2023-01-01" max="2023-12" id="fec_req" class="form-control" name="fecha_req" type="date" value=`+fecha_de_hoy+` required> 
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
                    <input min="2023-01-01" max="2023-12" id="fec_req" class="form-control" name="fecha_req" type="date" value=`+fecha_de_hoy+` required> 
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