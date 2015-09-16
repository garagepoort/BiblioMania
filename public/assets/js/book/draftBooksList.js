$(document).ready(function() {

    $.fn.editable.defaults.mode = 'inline';

    $('#bookEditList').DataTable({
        paging: false,
        initComplete: function (settings, json) {
        }
    });


    $('.editbook-goto').on('click', function(){
        var bookId = $(this).attr('bookId');
        window.location.href = baseUrl + "/createOrEditBook/step/1/" + bookId;
    });
});