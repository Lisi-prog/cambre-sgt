function mostrarFiltroOpc(id){
    let cuadro_filtro = document.getElementById(id);
    if ($(cuadro_filtro).is(":hidden")) {
        cuadro_filtro.hidden = false;
    }else{
        cuadro_filtro.hidden = true;
    }
}

