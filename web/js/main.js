$(function(){
	
	/*$(".flash-message").each(function(){
		var n = noty({
            text        : $(this).html(),
            type        : $(this).data('type'),
            //dismissQueue: true,
            layout      : 'topRight',
            //closeWith   : ['click'],
            //theme       : 'zibonzahe',
            maxVisible  : 6,
            animation   : {
                open  : 'animated bounceInRight',
                close : 'animated bounceOutRight',
                easing: 'swing',
                speed : 500
            }
        });
    })*/

    /*$('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true
    })*/

    $('.input-group.date').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        language: "fr",
        todayBtn: "linked",
    })

    $('[data-toggle="tooltip"]').tooltip();

    

});

function afficherMenu(){
    $('#contBtMenu').removeClass('bt-1');
    $('#menuLeft').removeClass('cacherMenu');
    $('#theContenu').removeClass('afficherContenu');

    $('#menuLeft').addClass('afficherMenu');
    $('#theContenu').addClass('cacherContenu');
    $('#contBtMenu').addClass('bt-2');
}

function cacherMenu(){
    $('#contBtMenu').removeClass('bt-2');
    $('#menuLeft').removeClass('afficherMenu');
    $('#theContenu').removeClass('cacherContenu');

    $('#menuLeft').addClass('cacherMenu');
    $('#theContenu').addClass('afficherContenu');
    $('#contBtMenu').addClass('bt-1');
}


function confirmerSuppression(me){
    var id = $(me).closest('form').attr('id');
    $('#confirmDeleteModal .btOui').data('id-form', id);
    return false;
}

function validerSuppression(me){
    var idForm = $(me).data('id-form');
    $('#'+idForm).submit();
}