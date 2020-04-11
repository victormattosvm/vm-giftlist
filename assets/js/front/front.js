$(document).ready(function(){
    if($('#entrega').is(':checked')){
        $('.dados-entrega').css('display', 'flex');
    }else{
        $('.dados-entrega').css('display', 'none');
    }
    if($('#credito').is(':checked')){
        $('.definir-entrega').css('display', 'none');
        $('#entrega').removeAttr('checked');
        $('.dados-entrega').css('display', 'none');
    }else{
        $('.definir-entrega').css('display', 'block');
    }
});

$('#credito').on('click', function(){
    if($('#credito').is(':checked')){
        $('.definir-entrega').css('display', 'none');
        $('#entrega').removeAttr('checked');
        $('.dados-entrega').css('display', 'none');
    }else{
        $('.definir-entrega').css('display', 'block');
    }
    
});

$('#entrega').on('click', function(){
    if($('#entrega').is(':checked')){
        $('.dados-entrega').css('display', 'flex');
    }else{
        $('.dados-entrega').css('display', 'none');
    }
    
});

var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' :
        '(00) 0000-00009';
},
spOptions = {
    onKeyPress: function (val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
};

$('.mask-phone').mask(SPMaskBehavior, spOptions);
$('.cep').mask('00000-000');


$('.nav-dados').on('click', function(){
    $('.nav-lista').removeClass('active');
    $('.nav-dados').addClass('active');
    $('.content-dados').css('display', 'block');
    $('.content-lista').css('display', 'none');
});

$('.nav-lista').on('click', function(){
    $('.nav-dados').removeClass('active');
    $('.nav-lista').addClass('active');
    $('.content-dados').css('display', 'none');
    $('.content-lista').css('display', 'block');
});

