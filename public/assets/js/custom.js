var request;

function showConfirmDialog(title, message, action){
    BootstrapDialog.show({
        title: title,
        message: message,
        buttons: [
            {
                icon: "fa fa-check-circle",
                label: 'Ja',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    action();
                    dialogItself.close();
                }
            },
            {
                icon: "fa fa-times-circle",
                label: 'Annuleer',
                cssClass: 'btn-warning',
                action: function(dialogItself){
                    dialogItself.close();
                }
            }]
    });
}

function startLoadingPaged(url, page, action){
    $('#loader-icon').show();
    $('#no-results-message').hide();
    request = $.get(url + "&page=" + page,
        function(data, status){
            if(status === "success"){
                if(data.total !== 0) {
                    action(data);
                    if (data.current_page !== data.last_page) {
                        var nextPage = data.current_page + 1;
                        startLoadingPaged(url, nextPage, action);
                    } else {
                        $('#loader-icon').hide();
                    }
                }else{
                    $('#no-results-message').show();
                    $('#loader-icon').hide();
                }
            }
        }
    );
}

function abortLoadingPaged(){
    request.abort();
}

function showLoadingDialog(){
    $.isLoading({
        text: "Loading",
        'class': "icon-refresh",
        'tpl': '<span class="isloading-wrapper %wrapper%">%text%<i class="%class% fa fa-refresh fa-spin"></i></span>'
    });
}

function hideLoadingDialog(){
    $.isLoading("hide");
}