angular
    .module('com.bendani.bibliomania.book.detail.reading.dates.directive', [
        'com.bendani.bibliomania.book.model',
        'com.bendani.bibliomania.personal.book.info.model',
        'com.bendani.bibliomania.confirmation.modal.service',
        'com.bendani.bibliomania.reading.date.modal.service',
        'com.bendani.bibliomania.reading.date.model'
    ])
    .directive('bookDetailReadingDates', function () {
        return {
            scope: {
                book: '='
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-detail-reading-dates-directive.html",
            controller: ['$scope', '$location', 'ReadingDate', 'ReadingDateModalService', 'ConfirmationModalService', 'DateService', 'Book', 'PersonalBookInfo', 'growl', 'ErrorContainer',
                function ($scope, $location, ReadingDate, ReadingDateModalService, ConfirmationModalService, DateService, Book, PersonalBookInfo, growl, ErrorContainer) {

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

                    function retrieveReadingDates() {
                        $scope.book.personalBookInfo.readingDates = PersonalBookInfo.readingDates({id: $scope.book.personalBookInfo.id}, function () {
                        }, ErrorContainer.handleRestError);
                    }

                }]
        };
    });