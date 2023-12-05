$(function(){
    $('#selected-prioridad').on('change', agregarUrgencia);
});

function agregarUrgencia(){
    let prioridad = $(this).val();
    let des = document.getElementById("descrip_urgencia");
    if (prioridad == 4) { //id de URGENTE
        html = '<div class="row" id="descrip_urgencia"> <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <div class="form-group"> <label for="desc_urg" class="control-label fs-7" style="white-space: nowrap; ">Descripcion urgencia</label> <span class="obligatorio">*</span> <textarea id="desc_urg" name="descripcion_urgencia" class="form-control" rows="54" cols="54" style="resize:none; height: 40vh"></textarea> </div> </div> </div>';
        des.innerHTML = html;
    } else {
        des.innerHTML = '';
    }
}