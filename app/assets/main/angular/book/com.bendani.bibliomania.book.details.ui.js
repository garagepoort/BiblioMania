angular.module('com.bendani.bibliomania.book.details.ui', ['com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.date.service',
    'com.bendani.bibliomania.author.selection.modal.service',
    'com.bendani.bibliomania.author.creation.modal.service',
    'com.bendani.bibliomania.date.selection.modal.service',
    'com.bendani.bibliomania.personal.book.info.model',
    'com.bendani.bibliomania.first.print.info.model',
    'com.bendani.bibliomania.first.print.selection.modal.service',
    'com.bendani.bibliomania.confirmation.modal.service',
    'angular-growl'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/book-details/:id', {
                templateUrl: '../BiblioMania/views/partials/book/book-detail.html',
                controller: 'BookDetailsController'
            });
    }])
    .controller('BookDetailsController', ['$scope', '$routeParams', 'Book', 'PersonalBookInfo', 'ErrorContainer','DateService', 'AuthorSelectionModalService', 'AuthorCreationModalService', 'FirstPrintSelectionModalService', 'DateSelectionModalService','TitlePanelService', 'ConfirmationModalService', 'growl', '$compile', '$location', 'FirstPrintInfo',
        function($scope, $routeParams, Book, PersonalBookInfo, ErrorContainer, DateService, AuthorSelectionModalService, AuthorCreationModalService, FirstPrintSelectionModalService, DateSelectionModalService, TitlePanelService, ConfirmationModalService, growl, $compile, $location, FirstPrintInfo){

            function init(){
                TitlePanelService.setTitle("Boek detail");
                TitlePanelService.setPreviousUrl("/books");

                $scope.book = Book.get({id: $routeParams.id}, function(book){

                    TitlePanelService.setTitle(book.title);
                    setRightTitlePanel();

                }, ErrorContainer.handleRestError);
            }

            $scope.openAddReadingDateModal = function(){
                DateSelectionModalService.show(function(date){
                    var readingDateToAdd = DateService.dateToJsonDate(date);
                    PersonalBookInfo.addReadingDate({id: $scope.book.personalBookInfo.id}, readingDateToAdd, function(){
                        $scope.book.personalBookInfo.readingDates = PersonalBookInfo.readingDates({id: $scope.book.personalBookInfo.id}, function(){}, ErrorContainer.handleRestError);
                        growl.addSuccessMessage('LeesDatum toegevoegd');
                    }, ErrorContainer.handleRestError);
                });
            };

            $scope.removeReadingDate= function (date){
                var message = 'Wilt u deze datum verwijderen: ' + $scope.convertDate(date.date);

                ConfirmationModalService.show(message, function(){
                    PersonalBookInfo.deleteReadingDate({id: $scope.book.personalBookInfo.id}, {readingDateId: date.id}, function(){
                        $scope.book.personalBookInfo.readingDates = PersonalBookInfo.readingDates({id: $scope.book.personalBookInfo.id}, function(){}, ErrorContainer.handleRestError);
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

            function linkAuthorToBook(author) {
                Book.linkAuthor({id: $scope.book.id}, {authorId: author.id}, function () {
                    $scope.book.authors.push(author);
                    growl.addSuccessMessage('Auteur toegevoegd');
                }, ErrorContainer.handleRestError);
            }

            function setRightTitlePanel(){
                var titlePanelRight = angular.element('<div class="book-detail-title-panel"><label style="float: right" class="label label-warning">{{ book.genre }}</label><div style="clear: both"><uib-rating ng-model="book.personalBookInfo.rating" max="10" readonly="true" class="book-rating"></uib-rating></div></div>');
                $compile(titlePanelRight)($scope);
                TitlePanelService.setRightPanel(titlePanelRight);
            }

            init();
    }]);