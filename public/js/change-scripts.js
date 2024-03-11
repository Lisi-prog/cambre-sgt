$(document).ready(function () {
    /* $('.collapse')
        .on('shown.bs.collapse', function() {
            $(this)
                .parent()
                .find(".fa-eye")
                .removeClass("fa-eye")
                .addClass("fa-eye-slash");
        })
        .on('hidden.bs.collapse', function() {
            $(this)
                .parent()
                .find(".fa-eye-slash")
                .removeClass("fa-eye-slash")
                .addClass("fa-eye");
        }); */

    $('.modal').modal({
        backdrop: 'static',
        keyboard: true
        })
    
    $('.modal').on('hidden.bs.modal', function (e) {
        resetInputs(this)
        resetHoras(this)
        resetFechas(this) //Pendiente
        $(this)
            // .find("select")
            //     .val('')
            //     .end()
            .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
    })
});

function resetInputs(document){
    let resetElements = document.getElementsByClassName('reset-input')
        //console.log(resetElements)
        for(var i = 0; i < resetElements.length; i++){
            //console.log(resetElements[i].value);
            resetElements[i].value = '';
        }
}

function resetHoras(document){
    let resetElements = document.getElementsByClassName('reset-horas')
        //console.log(resetElements)
        for(var i = 0; i < resetElements.length; i++){
            console.log(resetElements[i].value);
            resetElements[i].value = '00';
        }
}

function resetFechas(document){
    let resetElements = document.getElementsByClassName('reset-fecha')
        //console.log(resetElements)
        for(var i = 0; i < resetElements.length; i++){
            //console.log(resetElements[i].value);
            //resetElements[i].value = ''; 
        }
}