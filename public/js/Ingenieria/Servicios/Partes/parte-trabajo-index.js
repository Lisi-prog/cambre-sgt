$(function () {
    table = $('#tabla_parte_trabajo').DataTable({
                language: {
                        lengthMenu: 'Mostrar _MENU_ registros por pagina',
                        zeroRecords: 'No se ha encontrado registros',
                        info: 'Mostrando pagina _PAGE_ a _PAGES_ de _TOTAL_',
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
                order: [[0, 'desc']],
                drawCallback: function () {
                    changeTdColor();
                },
                columnDefs: [
                    { 
                        targets: [0, 4, 5, 6, 7, 8, 9], 
                        className: 'text-center',
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).css({
                                'vertical-align': 'middle',
                            });
                        }
                    }
                ],
            });

    cargarPartes(true);

    $('#buscar_parte_trabajo').on('submit', function (event) {
        event.preventDefault();
        cargarPartes();
    });

    $('#verParteTrabajoModal').on('hidden.bs.modal', function (e) {
        limpiarModal();
    })
});

function cargarPartes(cargaInicial = false){
    const formulario = $('#buscar_parte_trabajo');

    const datos = cargaInicial
        ? [{ name: '_token', value: formulario.find('input[name="_token"]').val() }]
        : formulario.serializeArray();
    datos.push({ name: 'carga_inicial', value: cargaInicial ? 1 : 0 });

    table.clear().draw();
    $.ajax({
        type: 'POST',
        url: formulario.attr('action'),
        data: datos,
        success: function(res) {
            let idCount = 0;
            let opciones = ''
            table.clear();
            
            res.forEach(e => {
                let urlLog = rutaLog.replace(':id', e.id_parte);

                table.row.add({
                    0: e.id_parte,
                    1: `<abbr title="${e.nombre_servicio ?? '-'}" style="text-decoration:none; font-variant: none;">
                            ${e.codigo_servicio ?? '-'} <i class="fas fa-eye"></i>
                        </abbr>`,
                    2: `<abbr title="${e.nombre_orden ?? '-'}" style="text-decoration:none; font-variant: none;">
                            ${(e.nombre_orden ?? '-').slice(0, 15) ?? '-'} <i class="fas fa-eye"></i>
                        </abbr>`,
                    3: `<abbr title="${e.descripcion_etapa ?? '-'}" style="text-decoration:none; font-variant: none;">
                            ${(e.descripcion_etapa ?? '-').slice(0, 15) ?? '-'} <i class="fas fa-eye"></i>
                        </abbr>`,
                    4: e.fecha ?? '-',
                    5: e.fecha_limite ?? '-',
                    6: e.estado ?? '-',
                    7: e.horas ?? '-',
                    8: e.responsable ?? '-',
                    9: e.supervisor ?? '-',
                    10: `<div class="d-flex">
                            <div class="me-1" style="width: 50% !important;">
                                <button title="Ver" type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#verParteTrabajoModal" onclick="cargarModalVerParteTrabajo(${e.id_parte})"><i class="fas fa-eye"></i></button>
                            </div>
                            <div class="me-1" style="width: 50% !important;">
                                <a href="${urlLog}" class="btn btn-info w-100" title="Logs"><i class="fas fa-clipboard-list"></i></a>
                            </div>
                        </div>`
                }).node().id = e.id_parte;     
                idCount++;
            });

            table.draw()      
        }
    });
}

function cargarModalVerParteTrabajo(id){
    let input_cod = document.getElementById("vp_cod");
    let input_res = document.getElementById("vp_res");
    let input_sup = document.getElementById("vp_sup");
    let input_observaciones = document.getElementById("vp_observaciones");
    let input_fec_limite = document.getElementById("vp_fec_limite");
    let input_fec = document.getElementById("vp_fecha");
    let input_horas = document.getElementById("vp_horas");
    let input_estado = document.getElementById("vp_estado");
    
    $.ajax({
        type: "post",
        url: '/parte-trabajo/obtener-una/'+id,
        data: {
            id_parte: id,
        },
        success: function (res) {
                input_cod.value = res.id_parte;
                input_res.value = res.responsable;
                input_sup.value = res.supervisor;
                input_observaciones.value = res.observaciones;
                input_fec_limite.value = res.fecha_limite;
                input_fec.value = res.fecha;
                input_horas.value = res.horas;
                input_estado.value = res.estado;
        },      
        error: function (error) {
            console.log(error);
        }
    });
    return ''
}

function limpiarModal(){
    document.getElementById("vp_cod").value = '';
    document.getElementById("vp_res").value = '';
    document.getElementById("vp_sup").value = '';
    document.getElementById("vp_observaciones").value = '';
    document.getElementById("vp_fec_limite").value = '';
    document.getElementById("vp_fecha").value = '';
    document.getElementById("vp_horas").value = '';
    document.getElementById("vp_estado").value = '';
}
