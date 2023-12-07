$(function(){
    $('#user_wb').on('change', agregarPass);
});

function agregarPass(){
    let opcion = Number($(this).val());
    let pass = document.getElementById("pass-input");
    let categoria = document.getElementById("categoria-input");
    switch (opcion) {
        case 0:
            pass.disabled = true;
            categoria.disabled = true;
            break;
        case 1:
            pass.disabled = false;
            categoria.disabled = false;
            break;
    }
}