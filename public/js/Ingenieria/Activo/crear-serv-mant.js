function cargarServMant(activo){
    // document.getElementById('').value = activo;

    $.ajax({
        type: "post",
        url: 'activo/tareas-prev-pendientes', 
        data: {
            activo: activo,
        },
        success: function (res) {
            console.log(res)
            document.getElementById('activo_serv_mant').value = res.codigo_activo
        },
        error: function (error) {
            console.log(error);
        }
    });
}