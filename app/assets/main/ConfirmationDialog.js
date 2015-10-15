function ConfirmationDialog(){

}

/*
* options
*   - title [optional]
*   - message [optional]
*   - onConfirmAction [optional]
*   - onCancelAction [optional]
*   - onConfirmNotification [optional]
*   - onCancelNotification [optional]
*
* */
ConfirmationDialog.show = function(options){
    if(!options.title){
        options.title = "Informatie"
    }
    BootstrapDialog.show({
        title: options.title,
        closable: false,
        message: options.message,
        buttons: [
            {
                icon: "fa fa-check-circle",
                label: 'Ja',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    if(options.onConfirmAction){ options.onConfirmAction(); }
                    if(options.onConfirmNotification){ showNotification('', options.onConfirmNotification, 'success');}
                    dialogItself.close();
                }
            },
            {
                icon: "fa fa-times-circle",
                label: 'Annuleer',
                cssClass: 'btn-warning',
                action: function(dialogItself){
                    if(options.onCancelAction){ options.onCancelAction(); }
                    if(options.onCancelNotification){ showNotification('', options.onCancelNotification, 'danger'); }
                    dialogItself.close();
                }
            }]
    });
}