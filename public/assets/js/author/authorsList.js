$(document).ready(function() {
    showLoadingDialog();

    $.fn.editable.defaults.mode = 'inline';

    $('#authorEditList').DataTable({
        paging: false,
        initComplete: function(settings, json) {
            hideLoadingDialog();
        }
    });

    $("#name, #firstname").editable({
        validate: function(value) {
            if($.trim(value) == '') {
                return 'This field is required';
            }
        }
    });
    $('#date_of_birth, #date_of_death').editable({
        validate: function(value) {
            // regular expression to match required date format
            var re = /^\d{1,2}\-\d{1,2}\-\d{4}$/;
            if(value != '' && !value.match(re)) {
                return 'Formaat dd-mm-yyyy';
            }
        }

    });

    $('.authorlist-goto').on('click', function(){
        var trElement = $(this).parent().parent();
        var authorId = trElement.attr('author-id');
        window.location.href = baseUrl + "/getAuthor/" + authorId;
    });

});