$("input[data-type='currency']").on({
    keyup: function() {
        // console.log($(this).val());
        controlInput($(this));
    }
});

function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "");
    // return n;
    // return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
  
}

function controlInput(in_put) {
    let input = in_put.val();
    // don't validate empty input
    if (input === "") { return; }
    
    // check for decimal
    if (input.indexOf(".") >= 0) {
        var decimal_pos = input.indexOf(".");
        var left_side = input.substring(0, decimal_pos);
        var right_side = input.substring(decimal_pos);
        right_side = right_side.replace('.', '');

        if(right_side.length >= 3){
        right_side = right_side.substring(0, 2);
        right_side  = formatNumber(right_side);
        }

        left_side = formatNumber(left_side);
        let numero = left_side +"."+right_side;
        in_put.val(numero);
    }else{
        input = formatNumber(input);
        in_put.val(input);
    }
}