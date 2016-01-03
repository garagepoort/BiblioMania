angular.module('com.bendani.bibliomania.book.details.ui', ['com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.author.selection.modal.service',
    'com.bendani.bibliomania.author.creation.modal.service',
    'com.bendani.bibliomania.date.selection.modal.service',
    'com.bendani.bibliomania.personal.book.info.model',
    'com.bendani.bibliomania.reading.date.model',
    'com.bendani.bibliomania.first.print.info.model',
    'com.bendani.bibliomania.currency.service',
    'com.bendani.bibliomania.oeuvre.model',
    'com.bendani.bibliomania.first.print.selection.modal.service',
    'com.bendani.bibliomania.confirmation.modal.service',
    'com.bendani.bibliomania.reading.date.modal.service',
    'com.bendani.bibliomania.oeuvre.item.selection.modal.service',
    'com.bendani.bibliomania.wishlist.model',
    'angular-growl'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/book-details/:id', {
                templateUrl: '../BiblioMania/views/partials/book/book-detail.html',
                controller: 'BookDetailsController'
            });
    }])
    .controller('BookDetailsController', ['$scope', '$rootScope', '$routeParams', 'Book', 'PersonalBookInfo', 'ReadingDate', 'ErrorContainer','DateService', 'AuthorSelectionModalService', 'AuthorCreationModalService', 'FirstPrintSelectionModalService', 'DateSelectionModalService','TitlePanelService',
        'ConfirmationModalService', 'growl', '$compile', '$location', 'FirstPrintInfo', 'OeuvreItemSelectionModalService', 'Oeuvre', 'ReadingDateModalService', 'CurrencyService', 'Wishlist',
        function($scope, $rootScope, $routeParams, Book, PersonalBookInfo, ReadingDate, ErrorContainer, DateService, AuthorSelectionModalService, AuthorCreationModalService, FirstPrintSelectionModalService,
                 DateSelectionModalService, TitlePanelService, ConfirmationModalService, growl, $compile, $location, FirstPrintInfo, OeuvreItemSelectionModalService, Oeuvre, ReadingDateModalService, CurrencyService, Wishlist){

            function init(){
                TitlePanelService.setTitle("Boek detail");
                $scope.getCurrencyViewValue = CurrencyService.getCurrencyViewValue;

                loadBook();
            }

            $scope.addTodayAsReadingDate = function(){
                var date = {
                    date: DateService.dateToJsonDate(new Date())
                };
                ReadingDateModalService.show($scope.book.personalBookInfo.id, function(){
                    retrieveReadingDates();
                }, date);
            };

            $scope.openEditReadingDateModal = function(date){
                if(!date){
                    date = {};
                }
                ReadingDateModalService.show($scope.book.personalBookInfo.id, function(){
                    retrieveReadingDates();
                }, date);
            };

            $scope.removeReadingDate= function (date){
                var message = 'Wilt u deze datum verwijderen: ' + $scope.convertDate(date.date);

                ConfirmationModalService.show(message, function(){
                    ReadingDate.delete({id: date.id}, function(){
                        retrieveReadingDates();
                        growl.addSuccessMessage('LeesDatum verwijderd');
                    }, ErrorContainer.handleRestError);
                });
            };

            $scope.showSelectAuthorDialog = function () {
                AuthorSelectionModalService.show(function (author) {
                    linkAuthorToBook(author);
                });
            };

            $scope.showSelectFirstPrintDialog = function () {
                FirstPrintSelectionModalService.show(function (firstPrint) {
                    FirstPrintInfo.linkBook({id: firstPrint.id}, {bookId: $scope.book.id}, function(){
                        $scope.book.firstPrintInfo = FirstPrintInfo.get({id: firstPrint.id}, function(){}, ErrorContainer.handleRestError);
                        growl.addSuccessMessage('Eerste druk gewijzigd');
                    }, ErrorContainer.handleRestError);
                });
            };

            $scope.showCreateAuthorDialog = function () {
                AuthorCreationModalService.show(function (author) {
                    linkAuthorToBook(author);
                });
            };

            $scope.createFirstPrintInfo = function(){
                $location.path('/create-first-print-and-link-to-book/'+ $scope.book.id);
            };

            $scope.editFirstPrintInfo = function(){
                $location.path('/edit-first-print/'+ $scope.book.firstPrintInfo.id);
            };

            $scope.convertDate = function(date){
                return DateService.dateToString(date);
            };

            $scope.editPersonalBookInfo = function(){
                $location.path('/edit-personal-book-info/'+ $scope.book.personalBookInfo.id);
            };

            $scope.editBookInformation = function(){
                $location.path('/edit-book/'+ $scope.book.id);
            };

            $scope.createPersonalBookInfo = function(){
                $location.path('/create-personal-book-info/'+ $scope.book.id);
            };

            $scope.unlinkAuthorFromBook = function(author) {
                var message = 'Wilt u auteur ' + author.name.firstname + " " + author.name.lastname +" verwijderen van het boek?";

                ConfirmationModalService.show(message, function(){
                    Book.unlinkAuthor({id: $scope.book.id}, {authorId: author.id}, function () {
                        var index = $scope.book.authors.indexOf(author);
                        $scope.book.authors.splice(index, 1);
                        growl.addSuccessMessage('Auteur verwijderd');
                    }, ErrorContainer.handleRestError);
                });
            };

            $scope.goToEditAuthor = function(author){
                $location.path('/edit-author/' + author.id);
            };

            $scope.goToEditOeuvreItem = function(oeuvreItem){
                $location.path('/edit-oeuvre-item/' + oeuvreItem.id);
            };

            $scope.addToWishlist = function(){
                Wishlist.addBook({id: $rootScope.loggedInUser.id}, {bookId: $scope.book.id}, function(){
                    growl.addSuccessMessage('Toegevoegd aan wishlist');
                    $scope.book.onWishlist = true;
                }, ErrorContainer.handleRestError);
            };

            $scope.removeFromWishlist = function(){
                Wishlist.removeBook({id: $rootScope.loggedInUser.id}, {bookId: $scope.book.id}, function(){
                    growl.addSuccessMessage('Verwijderd van wishlist');
                    $scope.book.onWishlist = false;
                }, ErrorContainer.handleRestError);
            };


            $scope.openSelectOeuvreItemDialog = function(){
                OeuvreItemSelectionModalService.show($scope.book.authors, function(oeuvreItem){
                    var shouldAdd = true;
                    for(var i = 0; i < $scope.book.oeuvreItems.length; i++){
                        if($scope.book.oeuvreItems[i].id === oeuvreItem.id){
                            shouldAdd = false;
                        }
                    }

                    if(shouldAdd){
                        Oeuvre.linkBook({id: oeuvreItem.id}, {bookId: $scope.book.id}, function () {
                            loadBook();
                            growl.addSuccessMessage("Oeuvre gewijzigd");
                        }, ErrorContainer.handleRestError);
                    }
                });
            };

            $scope.removeBookFromOeuvreItem = function(oeuvreItem){
                var message = 'Zeker dat je deze link wilt verwijderen: ' + oeuvreItem.title;
                ConfirmationModalService.show(message, function(){
                    Oeuvre.unlinkBook({id: oeuvreItem.id}, {bookId: $scope.book.id}, function () {
                        loadBook();
                        growl.addSuccessMessage("Oeuvre gewijzigd");
                    }, ErrorContainer.handleRestError);
                });
            };

            function loadBook() {
                $scope.book = Book.get({id: $routeParams.id}, function (book) {

                    TitlePanelService.setTitle(book.title);
                    setRightTitlePanel();

                }, ErrorContainer.handleRestError);
            }

            function linkAuthorToBook(author) {
                Book.linkAuthor({id: $scope.book.id}, {authorId: author.id}, function () {
                    $scope.book.authors.push(author);
                    growl.addSuccessMessage('Auteur toegevoegd');
                }, ErrorContainer.handleRestError);
            }

            function setRightTitlePanel(){
                var titlePanelRight = angular.element('<div class="book-detail-title-panel"><div class="float-right">' +
                    '<i ng-show="book.onWishlist" class="fa fa-heart margin-right-10"></i>' +
                    '<label class="label label-warning">{{ book.genre }}</label>' +
                    '</div></div>');
                $compile(titlePanelRight)($scope);
                TitlePanelService.setRightPanel(titlePanelRight);
            }

            function retrieveReadingDates() {
                $scope.book.personalBookInfo.readingDates = PersonalBookInfo.readingDates({id: $scope.book.personalBookInfo.id}, function () {
                }, ErrorContainer.handleRestError);
            }

            init();
    }]);