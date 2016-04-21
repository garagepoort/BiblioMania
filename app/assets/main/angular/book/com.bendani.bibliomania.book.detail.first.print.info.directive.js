angular
    .module('com.bendani.bibliomania.book.detail.first.print.info.directive', [
        'com.bendani.bibliomania.book.model',
        'com.bendani.bibliomania.first.print.info.model',
        'com.bendani.bibliomania.first.print.selection.modal.service'
    ])
    .directive('bookDetailFirstPrintInfo', function () {
        return {
            scope: {
                book: '='
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-detail-first-print-info-directive.html",
            controller: ['$scope', '$location','FirstPrintInfo', 'FirstPrintSelectionModalService', 'ConfirmationModalService', 'DateService', 'Book', 'growl', 'ErrorContainer',
                function ($scope, $location, FirstPrintInfo, FirstPrintSelectionModalService, ConfirmationModalService, DateService, Book, growl, ErrorContainer) {

                    $scope.showSelectFirstPrintDialog = function () {
                        FirstPrintSelectionModalService.show(function (firstPrint) {
                            FirstPrintInfo.linkBook({id: firstPrint.id}, {bookId: $scope.book.id}, function(){
                                $scope.book.firstPrintInfo = FirstPrintInfo.get({id: firstPrint.id}, function(){}, ErrorContainer.handleRestError);
                                growl.addSuccessMessage('Eerste druk gewijzigd');
                            }, ErrorContainer.handleRestError);
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
                }]
        };
    });