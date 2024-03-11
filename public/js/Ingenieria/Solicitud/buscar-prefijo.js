$(function(){
    $('#prefijo_proyecto').on('change', obtenerValorPrefijo);
});

function obtenerValorPrefijo(){
    id = $(this).val();
        input_codigo_proyecto = document.getElementById('codigo_proyecto');
        let e = document.getElementById('prefijo_proyecto');
        input_codigo_proyecto.value = '';
        if (id) {
            $.when($.ajax({
            type: "post",
            url: '/proyectos/obtener-mayor-prefijo/'+id, 
            data: {
                id: id,
            },
            success: function (response) {
                //console.log(response);
                
                if (response) {
                    let numeroDeProy = response.codigo_servicio.substr(e.options[e.selectedIndex].text.length);
                    let numeroDeProyLengInicial = numeroDeProy.length;
                    //console.log(numeroDeProy);
                    numeroDeProy = numeroDeProy.match(/[0-9]*/g);
                    numeroDeProy = String(Number(numeroDeProy[0])+1)
                    while(numeroDeProy.length < numeroDeProyLengInicial){
                        numeroDeProy = '0' + numeroDeProy
                    }
                    //console.log(numeroDeProy);
                    let prefijoMasNumero = e.options[e.selectedIndex].text + numeroDeProy
                    //console.log(prefijoMasNumero);
                    input_codigo_proyecto.value = prefijoMasNumero + response.codigo_servicio.substr(prefijoMasNumero.length);
                }else{
                    input_codigo_proyecto.value = e.options[e.selectedIndex].text;
                }
                
            },
            error: function (error) {
                console.log(error);
            }
            }));
    }
}


