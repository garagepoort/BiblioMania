angular.module('com.bendani.bibliomania.book.overview.service', ['com.bendani.bibliomania.reading.date.modal.service'])
.factory('BookOverviewService', ['DateService', 'ReadingDateModalService', 'growl', function BookOverviewServiceProvider(DateService, ReadingDateModalService, growl) {

    var selectedBook;
    var handlers = [];

    var selectBook = function(book) {
        selectedBook = book;
        _.each(handlers, function(handler){
            handler(book);
        });
    };

    var getSelectedBook = function() {
        return selectedBook;
    };

    var registerHandler = function(handler) {
        handlers.push(handler);
    };

    var deregisterHandler = function(handler) {
        var index  = handlers.indexOf(handler);
        if(index > -1){
            handlers.splice(index, 1);
        }
    };

    var getBookWarnings = function(book){
        var warnings = [];
        if(book.personalBookInfoId){
            if(book.read){
               warnings.push({
                    id: "bookread",
                    message: "Dit boek is gelezen",
                    icon: "images/check-circle-success.png",
                    handle: function(){
                        openEditReadingDateModal(book);
                    }
                });
            }else{
                warnings.push({
                    id: "bookread",
                    message: "Dit boek is niet gelezen",
                    icon: "images/check-circle-fail.png",
                    handle: function(){
                        openEditReadingDateModal(book);
                    }
                });
            }
        }
        if(!book.isLinkedToOeuvre){
            warnings.push({
                id: "bookIsNotLinkedToOeuvre",
                message: "Dit boek is niet gelinked aan een oeuvre",
                icon: "images/linked_warning.png"
            });
        }

        if(book.onWishlist){
            warnings.push({
                id: "bookIsOnWishlist",
                message: "Dit boek staat op je wishlist",
                icon: "images/heart.png"
            });
        }
        return warnings;
    };

    function openEditReadingDateModal(book){
        var date = {
            date: DateService.dateToJsonDate(new Date())
        };
        ReadingDateModalService.show(book.personalBookInfoId, function(){
            book.read = true;
            growl.addSuccessMessage('Leesdatum opgeslagen');
        }, date);

    }

    return {
        selectBook : selectBook,
        getSelectedBook : getSelectedBook,
        registerHandler : registerHandler,
        deregisterHandler : deregisterHandler,
        getBookWarnings : getBookWarnings
    };

}]);