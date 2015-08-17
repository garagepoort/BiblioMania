var formSubmitting = false;

function showError(errorMessage){
    $('#error-message').html(errorMessage);
    $('#error-div').show();
    window.scrollTo(0, 0);
}

function hideError(){
    $('#error-div').hide();
}

function setRedirectToPrevious(){
    $('#redirectInput').attr('value', 'PREVIOUS');
}

function setRedirectTo(value){
    $('#redirectInput').attr('value', value);
}

function submitForm(){
    document.getElementById('createOrEditBookForm').submit();
}