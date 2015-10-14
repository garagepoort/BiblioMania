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
    $.post(DELETE_BOOK_FROM_AUTHOR_URL,
        {bookFromAuthorId: options.bookFromAuthorId},
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