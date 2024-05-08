(function (){
    $('.form-prevent-multiple-submits').on('submit', function(){
        // console.log('hola');
        $('.button-prevent-multiple-submits').attr('disabled', 'true');
    })

    $('.form-prevent-multiple-submits-3sec').on('submit', function(){
        // console.log('hola');
        $('.button-prevent-multiple-submits-3sec').attr('disabled', 'true');
        setTimeout(function(){$('.button-prevent-multiple-submits-3sec').attr('disabled', false);},3000);
    })
})();