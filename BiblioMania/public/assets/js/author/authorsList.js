$(document).ready(function() {
    $.fn.editable.defaults.mode = 'inline';

    $('#authorEditList').DataTable({
        paging: false
    });

    $("#name, #firstname, #infix").editable({
        validate: function(value) {
            if($.trim(value) == '') {
                return 'This field is required';
            }
        }
    });
    $('#date_of_birth, #date_of_death').editable({
        validate: function(value) {
            var regex = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
            if(!regex.test(value)) {
                return 'Formaat dd-mm-yyyy';
            }
        }
    });
});