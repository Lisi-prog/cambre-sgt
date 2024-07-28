$(function(){
    document.querySelectorAll('.pmc').forEach(item => {
        item.addEventListener('change', event => {
            buscarYfiltrarPMAC('tablaPmACali');
        })
    });

    document.querySelectorAll('.pm').forEach(item => {
        item.addEventListener('change', event => {
            buscarYfiltrarPM('tablaPm');
        })
    });
});

function mostrarFiltroOpc(id){
    let cuadro_filtro = document.getElementById(id);
    if ($(cuadro_filtro).is(":hidden")) {
        cuadro_filtro.hidden = false;
    }else{
        cuadro_filtro.hidden = true;
    }
}

function buscarYfiltrarPMAC(tabla){
    let table = document.getElementById(tabla);
    tr = table.getElementsByTagName("tr");
    
    let estados = document.getElementsByName('est');
    let usuarios = document.getElementsByName('usu');

    let est = [];
    let usu = [];

    est = arrayForMe(estados);

    usu = arrayForMe(usuarios);

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        td2 = tr[i].getElementsByTagName("td")[4];
        // td3 = tr[i].getElementsByTagName("td")[5];
        
        if (td) {
            txtValu2 = td2.innerText;
            // txtValu3 = td3.innerText;
            if (usu.indexOf(txtValu2) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        } 
    }
}

function buscarYfiltrarPM(tabla){
    let table = document.getElementById(tabla);
    tr = table.getElementsByTagName("tr");
    
    let estados = document.getElementsByName('est1');
    let usuarios = document.getElementsByName('usu1');

    let usu = [];
    let est = [];

    est = arrayForMe(estados);
    usu = arrayForMe(usuarios);

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        td2 = tr[i].getElementsByTagName("td")[5];
        td3 = tr[i].getElementsByTagName("td")[7];
        if (td) {
            txtValu2 = td2.innerText;
            txtValu3 = td3.innerText;
            if (usu.indexOf(txtValu2) > -1 && est.indexOf(txtValu3) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        } 
    }
}

function arrayForMe(valores){
    let a = [];
    for (let index = 0; index < valores.length; index++) {
        
        if (valores[index].checked) {
            a.push(valores[index].value);
        }
    }
    return a;
}

