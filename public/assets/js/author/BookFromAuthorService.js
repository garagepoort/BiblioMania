function BookFromAuthorService() {
}

/*
 * options
 *      - bookFromAuthorId
 *      - onSuccess [optional]
 *      - onFailure [optional]
 *      - showNotifications [optional, default: false]
 * */
BookFromAuthorService.deleteBookFromAuthor = function (options) {
    var DELETE_BOOK_FROM_AUTHOR_URL = baseUrl + "/deleteBookFromAuthor";

    var postOptions = {
        url: DELETE_BOOK_FROM_AUTHOR_URL,
        data: {bookFromAuthorId: options.bookFromAuthorId},
        onSuccess: options.onSuccess,
        onFailure: options.onFailure
    }
    if(options.showNotifications){
        postOptions.onSuccessNotification = 'Succesvol verwijdert.';
    }

    ResourceUtilities.doPost(postOptions);
}

/*
 * options
 *      - bookFromAuthorId
 *      - bookId
 *      - onSuccess [optional]
 *      - onFailure [optional]
 *      - showNotifications [optional, default: false]
 * */
BookFromAuthorService.linkBook = function (options) {
    var LINK_BOOK_FROM_AUTHOR_URL = baseUrl + "/linkBookToBookFromAuthor";

    var postOptions = {
        url: LINK_BOOK_FROM_AUTHOR_URL,
        data: { book_from_author_id: options.bookFromAuthorId, book_id: options.bookId},
        onSuccess: options.onSuccess,
        onFailure: options.onFailure
    }
    if(options.showNotifications){
        postOptions.onSuccessNotification = 'Succesvol gelinkt aan boek.';
    }

    ResourceUtilities.doPost(postOptions);
}