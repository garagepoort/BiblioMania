angular
    .module('com.bendani.bibliomania.book.detail.oeuvre.items.directive', [
        'com.bendani.bibliomania.book.model',
        'com.bendani.bibliomania.oeuvre.model',
        'com.bendani.bibliomania.confirmation.modal.service',
        'com.bendani.bibliomania.oeuvre.item.selection.modal.service'
    ])
    .directive('bookDetailOeuvreItems', function () {
        return {
            scope: {
                book: '='
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-detail-oeuvre-items-directive.html",
            controller: ['$scope', '$location', 'OeuvreItemSelectionModalService', 'ConfirmationModalService', 'Oeuvre', 'Book', 'growl', 'ErrorContainer',
                function ($scope, $location, OeuvreItemSelectionModalService, ConfirmationModalService, Oeuvre, Book, growl, ErrorContainer) {
                    $scope.goToEditOeuvreItem = function(oeuvreItem){
                        $location.path('/edit-oeuvre-item/' + oeuvreItem.id);
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
                        $scope.book = Book.get({id: $scope.book.id}, function () {}, ErrorContainer.handleRestError);
                    }
                }]
        };
    });