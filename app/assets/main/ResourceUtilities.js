function ResourceUtilities(){}

/*
* options
*       - url
*       - data
*       - onSuccess [optional]
*       - onFailure [optional]
*       - onSuccessNotification [optional]
*       - onFailureNotification [optional]
*       - showFailureNotification [optional]
* */
ResourceUtilities.doPost = function(options){
    $.post(options.url, options.data,
        function (data, status) {
            if (status === "success") {
                if(options.onSuccess){
                    options.onSuccess();
                }
                if (options.onSuccessNotification) {
                    showNotification('', options.onSuccessNotification, 'success');
                }
            }
        })
        .fail(function (data) {
            if (options.onFailure) {
                options.onFailure();
            }
            if (options.onFailureNotification) {
                showNotification('Opgelet!', options.onFailureNotification, 'danger');
            }else if(options.showFailureNotification === undefined || options.showFailureNotification === true){
                showNotification('Opgelet!', data.responseJSON.message, 'danger');
            }
        });
}