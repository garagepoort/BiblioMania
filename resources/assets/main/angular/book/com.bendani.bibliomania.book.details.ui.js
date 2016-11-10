angular.module('com.bendani.bibliomania.book.details.ui', [
    'com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.currency.service',
    'com.bendani.bibliomania.date.selection.modal.service',
    'com.bendani.bibliomania.personal.book.info.model',
    'com.bendani.bibliomania.personal.book.info.detail.directive',
    'com.bendani.bibliomania.book.detail.authors.directive',
    'com.bendani.bibliomania.book.detail.first.print.info.directive',
    'com.bendani.bibliomania.book.detail.reading.dates.directive',
    'com.bendani.bibliomania.book.detail.oeuvre.items.directive',
    'com.bendani.bibliomania.confirmation.modal.service',
    'com.bendani.bibliomania.wishlist.model',
    'angular-growl'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/book-details/:id', {
                templateUrl: '../BiblioMania/views/partials/book/book-detail.html',
                controller: 'BookDetailsController'
            });
    }])
    .controller('BookDetailsController', ['$scope', '$rootScope', '$routeParams', 'Book', 'PersonalBookInfo',
        'ErrorContainer','DateService', 'CurrencyService', 'DateSelectionModalService','TitlePanelService',
        'ConfirmationModalService', 'growl', '$compile', '$location', 'Wishlist',
        function($scope, $rootScope, $routeParams, Book, PersonalBookInfo, ErrorContainer, DateService, CurrencyService,
                 DateSelectionModalService, TitlePanelService, ConfirmationModalService, growl, $compile, $location, Wishlist){

            function init(){
                TitlePanelService.setTitle("Boek detail");
                TitlePanelService.setPreviousUrl('#/books');

                loadBook();
            }

            $scope.convertDate = function(date){
                return DateService.dateToString(date);
            };

            $scope.getCurrencyViewValue = function(currency){
                return CurrencyService.getCurrencyViewValue(currency);
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

            $scope.addToWishlist = function(){
                Wishlist.addBook({bookId: $scope.book.id}, function(){
                    growl.addSuccessMessage('Toegevoegd aan wishlist');
                    $scope.book.onWishlist = true;
                }, ErrorContainer.handleRestError);
            };

            $scope.removeFromWishlist = function(){
                Wishlist.removeBook({bookId: $scope.book.id}, function(){
                    growl.addSuccessMessage('Verwijderd van wishlist');
                    $scope.book.onWishlist = false;
                }, ErrorContainer.handleRestError);
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
                    '<label id="book-genre-label" class="label label-warning">{{ book.genre }}</label>' +
                    '<button permission="DELETE_BOOK" ng-click="deleteBook()" class="margin-left-15 btn btn-danger btn-sm round-corners">DELETE</button>' +
                    '</div></div>');
                $compile(titlePanelRight)($scope);
                TitlePanelService.setRightPanel(titlePanelRight);
            }

            init();
    }]);