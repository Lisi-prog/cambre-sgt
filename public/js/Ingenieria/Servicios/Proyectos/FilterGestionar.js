$(function(){
    // $('.eta-ckb').on('change', aplicarFiltro);

    /*document.querySelectorAll('input[class=eta-ckb]').forEach(item => {
        item.addEventListener('change', event => {
            aplicarFiltro('tablaEtapas', 'cod_serv', 0);
        })
    });
    
    document.querySelectorAll('input[class=eta-est]').forEach(item => {
         item.addEventListener('change', event => {
             aplicarFiltro('tablaEtapas', 'est', 1);
         })
    });*/
    document.querySelectorAll('.eta-ckb').forEach(item => {
        item.addEventListener('change', event => {
            buscarYfiltrarEtapa('tablaEtapas');
        })
    });

    document.querySelectorAll('.ote-ckb').forEach(item => {
        item.addEventListener('change', event => {
            buscarYfiltrarOrdTrabajo('tablaOrdenTrabajo');
        })
    });

    document.querySelectorAll('.om-ckb').forEach(item => {
        item.addEventListener('change', event => {
            buscarYfiltrarOrdMan('tablaOrdenMan');
        })
    });

    document.querySelectorAll('.ome-ckb').forEach(item => {
        item.addEventListener('change', event => {
            buscarYfiltrarOrdMec('tablaOrdenMec');
        })
    });
});


function aplicarFiltro(tabla, chk_bx, columna){
    var input, filter, table, tr, td, i, txtValue;
    // filter = $(this).val();
    table = document.getElementById(tabla);
    tr = table.getElementsByTagName("tr");
    let filtro = document.getElementsByName(chk_bx);

    let busq = [];

    for (let index = 0; index < filtro.length; index++) {
        
        if (filtro[index].checked) {
            busq.push(filtro[index].value);
        }
    }
    // console.log(busq.indexOf("Alta de producto"));

    if ($(this).is(':checked')) {
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[columna];
            if (td) {
                txtValue = td.innerText;
                if (busq.indexOf(txtValue) > -1) {
                    tr[i].style.display = "";
                } else {
                    // tr[i].style.display = "none";
                }
            } 
        }
    } else {
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[columna];
            if (td) {
                txtValue = td.innerText;
                if (busq.indexOf(txtValue) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            } 
        }
    }
}

function buscarYfiltrarEtapa(tabla){
    let table = document.getElementById(tabla);
    tr = table.getElementsByTagName("tr");
    let etapas = document.getElementsByName('cod_serv');
    let estados = document.getElementsByName('est');
    let responsables = document.getElementsByName('res');
    // console.log(valores);

    let busq = [];
    let est = [];
    let res = [];

    busq = arrayForMe(etapas);

    est = arrayForMe(estados);

    res = arrayForMe(responsables);

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        td2 = tr[i].getElementsByTagName("td")[1];
        td3 = tr[i].getElementsByTagName("td")[2];
        if (td) {
            txtValue = td.innerText;
            txtValu2 = td2.innerText;
            txtValu3 = td3.innerText;
            if (busq.indexOf(txtValue) > -1 && est.indexOf(txtValu2) > -1 && res.indexOf(txtValu3) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        } 
    }
}

function buscarYfiltrarOrdTrabajo(tabla){
    let table = document.getElementById(tabla);
    tr = table.getElementsByTagName("tr");
    let etapas = document.getElementsByName('ot_etapa');
    let estados = document.getElementsByName('ot_est');
    let responsables = document.getElementsByName('ot_res');
    let supervisores = document.getElementsByName('ot_sup');
    // console.log(valores);

    let busq = [];
    let est = [];
    let res = [];
    let sup = [];

    busq = arrayForMe(etapas);

    est = arrayForMe(estados);

    res = arrayForMe(responsables);

    sup = arrayForMe(supervisores);

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; //etapa
        td2 = tr[i].getElementsByTagName("td")[2]; //estado
        td3 = tr[i].getElementsByTagName("td")[3]; //supervisor
        td4 = tr[i].getElementsByTagName("td")[4]; //responsable
        if (td) {
            // console.log(td.children[0].title);
            txtValue = td.children[0].title;
            txtValu2 = td2.innerText;
            txtValu3 = td3.innerText;
            txtValu4 = td4.innerText;
            if (busq.indexOf(txtValue) > -1 && est.indexOf(txtValu2) > -1 && sup.indexOf(txtValu3) > -1 && res.indexOf(txtValu4) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        } 
    }
}

function buscarYfiltrarOrdMan(tabla){
    let table = document.getElementById(tabla);
    tr = table.getElementsByTagName("tr");
    let etapas = document.getElementsByName('om_etapa');
    let estados = document.getElementsByName('om_est');
    // let responsables = document.getElementsByName('om_res');
    let supervisores = document.getElementsByName('om_sup');
    // console.log(valores);

    let busq = [];
    let est = [];
    // let res = [];
    let sup = [];

    busq = arrayForMe(etapas);

    est = arrayForMe(estados);

    // res = arrayForMe(responsables);

    sup = arrayForMe(supervisores);

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; //etapa
        td2 = tr[i].getElementsByTagName("td")[2]; //estado
        td3 = tr[i].getElementsByTagName("td")[4]; //supervisor
        // td4 = tr[i].getElementsByTagName("td")[5]; //responsable
        if (td) {
            // console.log(td.children[0].title);
            txtValue = td.children[0].title;
            txtValu2 = td2.innerText;
            txtValu3 = td3.innerText;
            // txtValu4 = td4.innerText;
            if (busq.indexOf(txtValue) > -1 && est.indexOf(txtValu2) > -1 && sup.indexOf(txtValu3) > -1 ) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        } 
    }
}

function buscarYfiltrarOrdMec(tabla){
    let table = document.getElementById(tabla);
    tr = table.getElementsByTagName("tr");
    let etapas = document.getElementsByName('ome_etapa');
    let estados = document.getElementsByName('ome_est');
    // let responsables = document.getElementsByName('ome_res');
    let supervisores = document.getElementsByName('ome_sup');
    // console.log(valores);

    let busq = [];
    let est = [];
    // let res = [];
    let sup = [];

    busq = arrayForMe(etapas);

    est = arrayForMe(estados);

    // res = arrayForMe(responsables);

    sup = arrayForMe(supervisores);

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2]; //etapa
        td2 = tr[i].getElementsByTagName("td")[3]; //estado
        td3 = tr[i].getElementsByTagName("td")[4]; //supervisor
        // td4 = tr[i].getElementsByTagName("td")[5]; //responsable
        if (td) {
            txtValue = td.children[0].title;
            txtValu2 = td2.innerText;
            txtValu3 = td3.innerText;
            // txtValu4 = td4.innerText;
            if (busq.indexOf(txtValue) > -1 && est.indexOf(txtValu2) > -1 && sup.indexOf(txtValu3) > -1) {
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
