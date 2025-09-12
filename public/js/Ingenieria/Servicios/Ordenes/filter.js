function mostrarFiltro(){
    let cuadro_filtro = document.getElementById("demo");
    if ($('#demo').is(":hidden")) {
        cuadro_filtro.hidden = false;
    }else{
        cuadro_filtro.hidden = true;
    }
}

function limpiarFiltro(){
    $('input[type=checkbox]').prop("checked", false);
    var table = $('#example').DataTable();
    table.draw();
}

document.querySelectorAll('input[name=filter]').forEach(item => {
    item.addEventListener('change', event => {
        if (item.checked) {
            //console.log("Checkbox is checked..");
            selects($(item).val());
        } else {
            //console.log("Checkbox is not checked..");
            deSelect($(item).val());
        }
        // validarFiltro();
    })
});

function selects(name){  
    var ele=document.getElementsByName(name);  
    for(var i=0; i<ele.length; i++){  
        if(ele[i].type=='checkbox')  
            ele[i].checked=true;  
    }  
}  

function deSelect(name){  
    var ele=document.getElementsByName(name);  
    for(var i=0; i<ele.length; i++){  
        if(ele[i].type=='checkbox')  
            ele[i].checked=false;  
            
    }  
}  

document.querySelectorAll('.input-filter').forEach(item => {
    item.addEventListener('change', event => {
        validarFiltro();
    })
});

function validarFiltro() {

    let btn = document.getElementById('btn-filtrar');
    let bandera = [];
    let filtroColumnas = ['cod_serv'];
    let cantidadNoSeleccionadas = 0;

    for (let i = 0; i < filtroColumnas.length; i++) {
        const cbx_col = document.getElementsByName(filtroColumnas[i]);
        // console.log(cbx_col);
        for (let i = 0; i < cbx_col.length; i++) {
            if (!cbx_col[i].checked) {
                cantidadNoSeleccionadas++;
            }
        }
        // console.log(cbx_col.length);
        // console.log(cantidadNoSeleccionadas);

        if (cbx_col.length == cantidadNoSeleccionadas) {
            bandera.push(1);
        }else{
            bandera.push(0);
        }
        cantidadNoSeleccionadas = 0;
    }

    // console.log(bandera);
    // console.log(bandera.includes(1));

    
    

    /*for (let i = 0; i < cbx_servicios.length; i++) {
        if (!checkboxes[i].checked) {
            cantidadNoSeleccionadas++;
        }
    }

    if (condition) {
        btn.disabled = true;
    } else {
        btn.disabled = false;
    } */
    // console.log(cantidadNoSeleccionadas);
}