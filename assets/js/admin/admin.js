
jQuery(document).ready( function($) {

    jQuery('.datepicker').datepicker();
    
    
jQuery(".remove-giftlist-adm").on('click', function(e){
    jQuery(this).parents('tr').remove();
});

});
