function BookService() {
}


/*
 * options
 *      - bookId
 *      - onSuccess [optional]
 *      - onFailure [optional]
 *      - showNotifications [optional, default: false]
 * */
BookService.deleteBook = function (options) {
    var DELETE_BOOK_URL = baseUrl + "/deleteBook";

    var postOptions = {
        url: DELETE_BOOK_URL,
        data: {bookId: options.bookId},
        onSuccess: options.onSuccess,
        onFailure: options.onFailure
    }
    if(options.showNotifications){
        postOptions.onSuccessNotification = 'Succesvol verwijdert.';
    }

    ResourceUtilities.doPost(postOptions);
}