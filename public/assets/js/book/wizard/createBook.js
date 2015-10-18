function validate(validationFunction) {
    if(validationFunction){
        var errorMessage = validationFunction();
        if (errorMessage) {
            showError("error-div", errorMessage);
            return false;
        }
    }

    hideError("error-div");
    NotificationRepository.addNotification({
        title: "Boek opgeslagen",
        message: "",
        type: "success"
    });
    return true;
}

function submitForm() {
    $('#createOrEditBookForm').bootstrapValidator('validate');
    var formValidation = $('#createOrEditBookForm').data('bootstrapValidator');

    if (formValidation.isValid() == true) {
        document.getElementById('createOrEditBookForm').submit();
    }
}