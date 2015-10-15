function PublisherService(){}

/*
 * options
 *      - publisher1_id
 *      - publisher2_id
 *      - onSuccess [optional]
 *      - onFailure [optional]
 *      - showNotifications [optional, default: false]
 * */
PublisherService.mergePublishers = function (options) {
    var MERGE_URL = baseUrl + "/mergePublishers";

    var postOptions = {
        url: MERGE_URL,
        data: { publisher1_id: options.publisher1_id, publisher2_id: options.publisher2_id},
        onSuccess: options.onSuccess,
        onFailure: options.onFailure
    }
    if(options.showNotifications){
        postOptions.onSuccessNotification = 'Succesvol samengevoegd.';
    }

    ResourceUtilities.doPost(postOptions);
}

/*
 * options
 *      - publisherId
 *      - onSuccess [optional]
 *      - onFailure [optional]
 *      - showNotifications [optional, default: false]
 * */
PublisherService.deletePublisher = function (options) {
    var DELETE_URL = baseUrl + "/deletePublisher";

    var postOptions = {
        url: DELETE_URL,
        data: { publisherId: options.publisherId},
        onSuccess: options.onSuccess,
        onFailure: options.onFailure
    }
    if(options.showNotifications){
        postOptions.onSuccessNotification = 'Succesvol verwijderd.';
    }

    ResourceUtilities.doPost(postOptions);
}