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
});