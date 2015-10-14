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

    var postOptions = {
        url: DELETE_COUNTRY_URL,
        data: {countryId: options.countryId},
        onSuccess: options.onSuccess,
        onFailure: options.onFailure
    }
    if(options.showNotifications){
        postOptions.onSuccessNotification = 'Succesvol verwijdert.';
    }

    ResourceUtilities.doPost(postOptions);
}