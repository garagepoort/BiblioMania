angular.module('com.bendani.bibliomania.book.details.ui', ['com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.date.service',
    'com.bendani.bibliomania.date.selection.controller',
    'com.bendani.bibliomania.personal.book.info.model',
    'com.bendani.bibliomania.first.print.info.model',
    'com.bendani.bibliomania.first.print.selection.controller',
    'angular-growl'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/book-details/:id', {
                templateUrl: '../BiblioMania/views/partials/book/book-detail.html',
                controller: 'BookDetailsController'
            });
    }])
    .controller('BookDetailsController', ['$scope', '$routeParams', 'Book', 'PersonalBookInfo', 'ErrorContainer','DateService', 'TitlePanelService', '$uibModal', 'growl', '$compile', '$location', 'FirstPrintInfo',
        function($scope, $routeParams, Book, PersonalBookInfo, ErrorContainer, DateService, TitlePanelService, $uibModal, growl, $compile, $location, FirstPrintInfo){

            function init(){
                TitlePanelService.setTitle("Boek detail");
                TitlePanelService.setPreviousUrl("/books");

                $scope.book = Book.get({id: $routeParams.id}, function(book){

                    TitlePanelService.setTitle(book.title);
                    setRightTitlePanel();

                }, ErrorContainer.handleRestError);
            }

            $scope.openAddReadingDateModal = function(){
                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/book/select-date-modal.html'
                });

                modalInstance.result.then(function (date) {
                    var readingDateToAdd = DateService.dateToJsonDate(date);
                    PersonalBookInfo.addReadingDate({id: $scope.book.personalBookInfo.id}, readingDateToAdd, function(){
                        $scope.book.personalBookInfo.readingDates = PersonalBookInfo.readingDates({id: $scope.book.personalBookInfo.id}, function(){}, ErrorContainer.handleRestError);
                        growl.addSuccessMessage('LeesDatum toegevoegd');
                    }, ErrorContainer.handleRestError);
                });
            };

            $scope.removeReadingDate= function (date){
                $scope.confirmationModal = {};
                $scope.confirmationModal.message = 'Wilt u deze datum verwijderen: ' + $scope.convertDate(date.date);

                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/confirmation-modal.html',
                    scope: $scope
                });

                modalInstance.result.then(function () {
                    PersonalBookInfo.deleteReadingDate({id: $scope.book.personalBookInfo.id}, {readingDateId: date.id}, function(){
                        $scope.book.personalBookInfo.readingDates = PersonalBookInfo.readingDates({id: $scope.book.personalBookInfo.id}, function(){}, ErrorContainer.handleRestError);
                        growl.addSuccessMessage('LeesDatum verwijderd');
                    }, ErrorContainer.handleRestError);
                });
            };

            $scope.showSelectAuthorDialog = function () {
                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/author/select-author-modal.html',
                    scope: $scope
                });

                modalInstance.result.then(function (author) {
                    linkAuthorToBook(author);
                });
            };

            $scope.showSelectFirstPrintDialog = function () {
                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/firstprint/select-first-print-modal.html',
                    scope: $scope
                });

                modalInstance.result.then(function (firstPrint) {
                    FirstPrintInfo.linkBook({id: firstPrint.id}, {bookId: $scope.book.id}, function(){
                        $scope.book.firstPrintInfo = FirstPrintInfo.get({id: firstPrint.id}, function(){}, ErrorContainer.handleRestError);
                        growl.addSuccessMessage('Eerste druk gewijzigd');
                    }, ErrorContainer.handleRestError);
                });
            };

            $scope.showCreateAuthorDialog = function () {
                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/author/create-author-modal.html',
                    scope: $scope,
                    windowClass: 'create-author-dialog'
                });

                modalInstance.result.then(function (author) {
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