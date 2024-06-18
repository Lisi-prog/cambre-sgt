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
                if (response) {
                    let numeroDeProy = response.codigo_servicio.substr(e.options[e.selectedIndex].text.length);
                    let numeroDeProyLengInicial;
                    numeroDeProy = numeroDeProy.match(/[0-9]*/g);
                    numeroDeProyLengInicial = numeroDeProy[0].length //Largo del primer numero encontrado
                    numeroDeProy = String(Number(numeroDeProy[0])+1)
                    while(numeroDeProy.length < numeroDeProyLengInicial){
                        numeroDeProy = '0' + numeroDeProy
                    }
                    let prefijoMasNumero = e.options[e.selectedIndex].text + numeroDeProy
                    if (numeroDeProyLengInicial > 1) {
                        input_codigo_proyecto.value = prefijoMasNumero + response.codigo_servicio.substr(prefijoMasNumero.length);
                    } else {
                        input_codigo_proyecto.value = e.options[e.selectedIndex].text + '000' + numeroDeProy + response.codigo_servicio.substr(prefijoMasNumero.length);
                    }
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


