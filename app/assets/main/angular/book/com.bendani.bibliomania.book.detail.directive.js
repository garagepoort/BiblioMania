angular
    .module('com.bendani.bibliomania.book.detail.directive', ['com.bendani.bibliomania.book.model', 'com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.date.service'])
    .directive('bookDetail', [ 'Book', 'ErrorContainer', 'DateService', function (Book, ErrorContainer, DateService){
        return {
            scope: {
                bookDetailPanelOpen : "="
            },
            restrict: "E",
            replace: true,
            templateUrl: "../BiblioMania/views/partials/book/book-detail-directive.html",
            link: function ($scope, element) {
                $scope.bookSlidingPanel = new BorderSlidingPanel($(element), "right", 0);
                $scope.imageStyle = "";

                $scope.currencies = [];
                $scope.currencies['EUR'] = '€';
                $scope.currencies['USD'] = '$';
                $scope.currencies['PND'] = '£';

                $(element).on('click', function(event){
                    event.stopPropagation();
                });

                function retrieveFullBook(newValue) {
                    $scope.book = Book.get({id: newValue}, function (data) {
                        $scope.openBookDetail();
                    }, ErrorContainer.handleRestError);
                }

                $scope.$parent.$watch('bookModel.selectedBookId', function(newValue) {
                    if(newValue){
                        retrieveFullBook(newValue);
                    }
                }, true);


                $scope.$watch('bookDetailPanelOpen', function(value){
                    if(value){
                        $scope.openBookDetail();
                    }else{
                        $scope.closeBookDetail();
                    }
                });

                $scope.closeBookDetail = function() {
                    $scope.bookSlidingPanel.close(function () {
                        $(element).removeClass('visible');
                    });
                };

                $scope.convertDate = function(date){
                    return DateService.dateToString(date);
                };

                $scope.openBookDetail = function() {
                    var rating = 0;
                    if($scope.book.personalBookInfo !== undefined){
                        rating = $scope.book.personalBookInfo.rating;
                    }

                    $('#star-detail').raty({
                        score: rating,
                        number: 10,
                        readOnly: true,
                        path: '/BiblioMania/assets/lib/raty-2.7.0/lib/images'
                    });
                    $scope.bookSlidingPanel.open(function(){
                        $(element).addClass('visible');
                    });
                };
            }
        };
    }]);