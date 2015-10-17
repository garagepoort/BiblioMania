function validate(validationFunction) {
    var errorMessage = validationFunction();
    if (errorMessage) {
        showError("error-div", errorMessage);
        return false;
    }

    hideError("error-div");
    return true;
}

function submitForm() {
    $('#createOrEditBookForm').bootstrapValidator('validate');
    var formValidation = $('#createOrEditBookForm').data('bootstrapValidator');

    if (formValidation.isValid() == true) {
        document.getElementById('createOrEditBookForm').submit();
    }
}