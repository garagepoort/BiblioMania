function CountryService() {
}

/*
 * options
 *      - countryId
 *      - onSuccess [optional]
 *      - onFailure [optional]
 *      - showNotifications [optional, default: false]
 * */
CountryService.deleteCountry = function (options) {
    var DELETE_COUNTRY_URL = baseUrl + "/deleteCountry";
    $.post(DELETE_COUNTRY_URL,
        {countryId: options.countryId},
        function (data, status) {
            if (status === "success") {
                if(options.onSuccess){
                    options.onSuccess();
                }
                if (options.showNotifications) {
                    showNotification('', 'Succesvol verwijdert.', 'success');
                }
            }
        })
        .fail(function (data) {
            if (options.onFailure) {
                options.onFailure();
            }
            if (options.showNotifications) {
                showNotification('Opgelet!', data.responseJSON.message, 'danger');
            }
        });
}