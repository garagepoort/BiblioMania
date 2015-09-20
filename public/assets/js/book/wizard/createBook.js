var formSubmitting = false;

function setRedirectToPrevious() {
    $('#redirectInput').attr('value', 'PREVIOUS');
}

function setRedirectTo(value) {
    $('#redirectInput').attr('value', value);
}

function submitForm() {
    $('#createOrEditBookForm').bootstrapValidator('validate');
    var formValidation = $('#createOrEditBookForm').data('bootstrapValidator');

    if (formValidation.isValid() == true) {
        document.getElementById('createOrEditBookForm').submit();
    }
}
