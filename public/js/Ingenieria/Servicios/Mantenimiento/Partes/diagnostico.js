var tabla_diagnosticos
$(document).ready(function () {
    tabla_diagnosticos = $('#tabla_diagnosticos').DataTable({
        language: {
                lengthMenu: 'Mostrar _MENU_ registros por pagina',
                zeroRecords: 'No se ha encontrado registros',
                info: 'Mostrando pagina _PAGE_ de _PAGES_',
                infoEmpty: 'No se ha encontrado registros',
                infoFiltered: '(Filtrado de _MAX_ registros totales)',
                search: 'Buscar',
                paginate:{
                    first:"Prim.",
                    last: "Ult.",
                    previous: 'Ant.',
                    next: 'Sig.',
                },
            },
            "aaSorting": []
    });    
    activo = document.getElementById('activo').value;
    document.getElementById('herramental').value = activo;
});

var i = 0;

function agregarDiagnostico() {
    const ishikawa_categoria = document.getElementById('ishikawa_categoria_div');
    const ishikawa_causa = document.getElementById('ishikawa_causa_div');

    tabla_diagnosticos.row.add([
        i + 1,

        `<select required onchange="cambiarIshikawaCategoria(${i})"
            class="form-select"
            name="ishikawa_categoria[]"
            id="ishikawa_categoria_${i}">
            <option hidden value="">Seleccionar...</option>
            ${ishikawa_categoria.innerHTML}
        </select>`,

        `<div id="prev_ishikawa_cat_${i}">Primero elegir 5M</div>
         <select required hidden
            class="form-select"
            name="ishikawa_causa[]"
            id="ishikawa_causa_${i}">
            <option hidden value="">Seleccionar...</option>
            ${ishikawa_causa.innerHTML}
         </select>`,

        `<button type="button" class="btn btn-danger"
            onclick="eliminarDiagnostico(${i})">Eliminar</button>`
    ]).node().id = `diagnostico_${i}`;

    tabla_diagnosticos.draw(false);
    i++;
}


function cambiarIshikawaCategoria(indice){
    ishikawa_categoria = document.getElementById(`ishikawa_categoria_${indice}`).value;
    ishikawa_causa = document.getElementById(`ishikawa_causa_${indice}`);
    ishikawa_causa.removeAttribute('hidden');
    document.getElementById(`prev_ishikawa_cat_${indice}`).setAttribute('hidden', true);
    for (let j = 0; j < ishikawa_causa.options.length; j++) {
        if (ishikawa_causa.options[j].dataset.ishikawaCategoria == ishikawa_categoria) {
            ishikawa_causa.options[j].removeAttribute('hidden');
        }
        else{
            ishikawa_causa.options[j].setAttribute('hidden', true);
        }
    }
}

function eliminarDiagnostico(indice){
   tabla_diagnosticos.row('#diagnostico_'+indice).remove().draw();
   //Reordenar indices
   for (let j = 0; j < tabla_diagnosticos.rows().count(); j++) {
        const row = tabla_diagnosticos.row(j).node();
        row.id = `diagnostico_${j}`;
        row.querySelector('td').innerText = j + 1;
        row.querySelector('select').setAttribute('id', `ishikawa_categoria_${j}`);
        row.querySelectorAll('select')[1].setAttribute('id', `ishikawa_causa_${j}`);
        row.querySelector('button').setAttribute('onclick', `eliminarDiagnostico(${j})`);
        row.querySelector('select').setAttribute('onchange', `cambiarIshikawaCategoria(${j})`);
    }
    i= tabla_diagnosticos.rows().count();
}

