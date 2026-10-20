var catalogoDiagnostico = [];
var secuenciaDiagnostico = 0;
var peticionCatalogoDiagnostico;
function textoDiagnostico(texto) {
    return $('<div>').text(texto || '').html();
}

function cargarCatalogoDiagnostico(idOrden, tabla) {
    catalogoDiagnostico = [];
    tabla.column(3).visible(true);
    $('#btnAgregarFilaDiagnostico').prop('disabled', true);
    $('#avisoCatalogoDiagnostico').remove();
    if (peticionCatalogoDiagnostico) peticionCatalogoDiagnostico.abort();
    peticionCatalogoDiagnostico = $.getJSON('/parte-diagnostico/categorias/' + idOrden)
        .done(function (categorias) {
            catalogoDiagnostico = categorias;
            const disponibles = categorias.some(categoria => categoria.get_diagnosticos.length);
            $('#btnAgregarFilaDiagnostico').prop('disabled', !disponibles);
            if (!disponibles) {
                $('#tabla_diagnosticos').after('<p id="avisoCatalogoDiagnostico" class="text-muted">No hay diagnósticos en uso en las categorías vinculadas al tipo de activo. Revise su configuración.</p>');
            }
        }).fail(function (_, estado) {
            if (estado !== 'abort') {
                $('#tabla_diagnosticos').after('<p id="avisoCatalogoDiagnostico" class="text-danger">No se pudieron cargar las categorías de diagnóstico. Vuelva a abrir el parte.</p>');
            }
        });
}

function agregarFilaDiagnostico(tabla) {
    if (!catalogoDiagnostico.length) return;
    const indice = secuenciaDiagnostico++;
    const categorias = catalogoDiagnostico.map(categoria =>
        `<option value="${categoria.id_diagnostico_categoria}">${textoDiagnostico(categoria.nombre_diagnostico_categoria)}</option>`).join('');
    tabla.row.add([
        tabla.rows().count() + 1,
        `<select required class="form-select" onchange="cambiarCategoriaDiagnostico(this, ${indice})"><option value="">Seleccionar...</option>${categorias}</select>`,
        `<select required class="form-select" name="diagnosticos[]" id="diagnostico-seleccion-${indice}"><option value="">Primero elegir categoría</option></select>`,
        `<button type="button" class="btn btn-danger" onclick="eliminarDiagnostico(${indice})">Eliminar</button>`
    ]).node().id = 'diagnostico_' + indice;
    tabla.draw(false);
    checkSendNuevoParteDiagnostico();
}

function cambiarCategoriaDiagnostico(select, indice) {
    const categoria = catalogoDiagnostico.find(item => String(item.id_diagnostico_categoria) === select.value);
    const diagnosticos = categoria ? categoria.get_diagnosticos : [];
    $('#diagnostico-seleccion-' + indice).html('<option value="">Seleccionar...</option>' + diagnosticos.map(diagnostico =>
        `<option value="${diagnostico.id_diagnostico}">${textoDiagnostico(diagnostico.nombre_diagnostico)}</option>`).join(''));
}

function enviarParteDiagnostico(tabla) {
    const formulario = document.getElementById('formNuevoParteDiagnostico');
    // DataTables retira del DOM las filas de otras páginas y las filtradas.
    const filas = tabla.rows().nodes().toArray();
    for (const fila of filas) {
        for (const select of fila.querySelectorAll('select')) {
            if (!select.checkValidity()) {
                tabla.search('').page.len(-1).draw();
                select.reportValidity();
                return;
            }
        }
    }
    tabla.search('').page.len(-1).draw();
    if (formulario.reportValidity()) formulario.requestSubmit();
}
