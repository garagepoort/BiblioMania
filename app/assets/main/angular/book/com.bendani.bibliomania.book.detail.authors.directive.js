angular
    .module('com.bendani.bibliomania.book.detail.authors.directive', [
        'com.bendani.bibliomania.book.model',
        'com.bendani.bibliomania.author.selection.modal.service',
        'com.bendani.bibliomania.confirmation.modal.service',
        'com.bendani.bibliomania.author.creation.modal.service'
    ])
    .directive('bookDetailAuthors', function () {
        return {
            scope: {
                book: '='
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-detail-authors-directive.html",
            controller: ['$scope', '$location', 'AuthorSelectionModalService', 'AuthorCreationModalService', 'ConfirmationModalService', 'Book', 'growl', 'ErrorContainer',
                function ($scope, $location, AuthorSelectionModalService, AuthorCreationModalService, ConfirmationModalService, Book, growl, ErrorContainer) {

                    $scope.unlinkAuthorFromBook = function (author) {
                        var message = 'Wilt u auteur ' + author.name.firstname + " " + author.name.lastname + " verwijderen van het boek?";

                        ConfirmationModalService.show(message, function () {
                            Book.unlinkAuthor({id: $scope.book.id}, {authorId: author.id}, function () {
                                var index = $scope.book.authors.indexOf(author);
                                $scope.book.authors.splice(index, 1);
                                growl.addSuccessMessage('Auteur verwijderd');
                            }, ErrorContainer.handleRestError);
                        });
                    };

                    $scope.showCreateAuthorDialog = function () {
                        AuthorCreationModalService.show(function (author) {
                            linkAuthorToBook(author);
                        });
                    };

                    $scope.showSelectAuthorDialog = function () {
                        AuthorSelectionModalService.show(function (author) {
                            linkAuthorToBook(author);
                        });
                    };

                    $scope.goToEditAuthor = function (author) {
                        $location.path('/edit-author/' + author.id);
                    };

                    function linkAuthorToBook(author) {
                        Book.linkAuthor({id: $scope.book.id}, {authorId: author.id}, function () {
                            $scope.book.authors.push(author);
                            growl.addSuccessMessage('Auteur toegevoegd');
                        }, ErrorContainer.handleRestError);
                    }

                }]
        };
    });