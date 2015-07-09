$(document).ready(function() {

    $.fn.editable.defaults.mode = 'inline';

    $('#bookEditList').DataTable({
        paging: false,
        initComplete: function (settings, json) {
        }
    });


    $('.detailPanelTrigger').each(function(){
        addSlidingPanelClickToElement($(this));
    });
});