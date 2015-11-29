angular.module('com.bendani.bibliomania.book.details.ui', ['com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.date.service',
    'com.bendani.bibliomania.date.selection.controller',
    'com.bendani.bibliomania.personal.book.info.model',
    'angular-growl'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/book-details/:id', {
                templateUrl: '../BiblioMania/views/partials/book/book-detail.html',
                controller: 'BookDetailsController'
            });
    }])
    .controller('BookDetailsController', ['$scope', '$routeParams', 'Book', 'PersonalBookInfo', 'ErrorContainer','DateService', 'TitlePanelService', '$uibModal', 'growl', '$compile',
        function($scope, $routeParams, Book, PersonalBookInfo, ErrorContainer, DateService, TitlePanelService, $uibModal, growl, $compile){

            function init(){
                TitlePanelService.setTitle("Boek detail");

                $scope.book = Book.get({id: $routeParams.id}, function(book){
                    TitlePanelService.setTitle(book.title);

                    var titlePanelRight = angular.element('<div class="book-detail-title-panel"><label style="float: right" class="label label-warning">{{ book.genre }}</label><div style="clear: both" class="star-detail"></div></div>');
                    $compile(titlePanelRight)($scope);
                    TitlePanelService.setRightPanel(titlePanelRight);

                    var rating = 0;
                    if(book.personalBookInfo !== undefined){
                        rating = book.personalBookInfo.rating;
                    }

                    $('.star-detail').raty({
                        score: rating,
                        number: 10,
                        readOnly: true,
                        path: '/BiblioMania/assets/lib/raty-2.7.0/lib/images'
                    });

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
                    Book.linkAuthor({id: $scope.book.id}, {authorId: author.id}, function(){
                        growl.addSuccessMessage('Auteur toegevoegd');
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
                });
            };


            $scope.convertDate = function(date){
                return DateService.dateToString(date);
            };

            init();
    }]);