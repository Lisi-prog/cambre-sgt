var tabla_ajustes, tabla_mecanizado

$(document).ready(function () {
    tabla_ajustes = $('#tabla_ajustes').DataTable({
        autoWidth: false,
         columnDefs: [
            { className: "text-center", targets: [1,2,3,4] }, { width: '25%', targets:[0]}, {className: "text-start", targets: [0]}  
        ],
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
    $("#nombre_proyecto_ajuste").val($("#nombre_proyecto_i").val())
    tabla_mecanizado = $('#tablaOrdenMec').DataTable({
        autoWidth: false,
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
});
