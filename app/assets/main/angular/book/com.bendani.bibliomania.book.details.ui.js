angular.module('com.bendani.bibliomania.book.details.ui', ['com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.date.selection.modal.service',
    'com.bendani.bibliomania.personal.book.info.model',
    'com.bendani.bibliomania.reading.date.model',
    'com.bendani.bibliomania.oeuvre.model',
    'com.bendani.bibliomania.personal.book.info.detail.directive',
    'com.bendani.bibliomania.book.detail.authors.directive',
    'com.bendani.bibliomania.book.detail.first.print.info.directive',
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
    .controller('BookDetailsController', ['$scope', '$rootScope', '$routeParams', 'Book', 'PersonalBookInfo', 'ReadingDate', 'ErrorContainer','DateService', 'DateSelectionModalService','TitlePanelService',
        'ConfirmationModalService', 'growl', '$compile', '$location', 'OeuvreItemSelectionModalService', 'Oeuvre', 'ReadingDateModalService', 'Wishlist',
        function($scope, $rootScope, $routeParams, Book, PersonalBookInfo, ReadingDate, ErrorContainer, DateService,
                 DateSelectionModalService, TitlePanelService, ConfirmationModalService, growl, $compile, $location, OeuvreItemSelectionModalService, Oeuvre, ReadingDateModalService, Wishlist){

            function init(){
                TitlePanelService.setTitle("Boek detail");
                TitlePanelService.setPreviousUrl('#/books');

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

            $scope.deleteBook = function(){
                var message = 'Zeker dat je dit boek wilt verwijderen?';
                ConfirmationModalService.show(message, function(){
                    Book.delete({id: $scope.book.id}, function () {
                        $location.path('/books');
                        growl.addSuccessMessage("Boek verwijderd");
                    }, ErrorContainer.handleRestError);
                });
            };

            function loadBook() {
                $scope.book = Book.get({id: $routeParams.id}, function (book) {

                    TitlePanelService.setTitle(book.title);
                    setRightTitlePanel();

                }, ErrorContainer.handleRestError);
            }

            function setRightTitlePanel(){
                var titlePanelRight = angular.element('<div class="book-detail-title-panel"><div class="float-right">' +
                    '<i ng-show="book.onWishlist" class="fa fa-heart margin-right-10"></i>' +
                    '<label class="label label-warning">{{ book.genre }}</label>' +
                    '<button ng-click="deleteBook()" class="margin-left-15 btn btn-danger btn-sm no-round-corners">DELETE</button>' +
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