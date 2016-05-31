(function () {
    'use strict';

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
                controller: ['$location', 'AuthorSelectionModalService',
                    'AuthorCreationModalService', 'ConfirmationModalService', 'Book', 'growl',
                    'ErrorContainer', BookDetailAuthorsController],
                controllerAs: 'vm',
                bindToController: true
            };
        });

    function BookDetailAuthorsController($location, AuthorSelectionModalService, AuthorCreationModalService, ConfirmationModalService, Book, growl, ErrorContainer) {
        var vm = this;

        vm.unlinkAuthorFromBook = unlinkAuthorFromBook;
        vm.showCreateAuthorDialog = showCreateAuthorDialog;
        vm.showSelectAuthorDialog = showSelectAuthorDialog;
        vm.goToEditAuthor = goToEditAuthor;

        function unlinkAuthorFromBook(author) {
            var message = 'Wilt u auteur ' + author.name.firstname + " " + author.name.lastname + " verwijderen van het boek?";

            ConfirmationModalService.show(message, function () {
                Book.unlinkAuthor({id: vm.book.id}, {authorId: author.id}, function () {
                    var index = vm.book.authors.indexOf(author);
                    vm.book.authors.splice(index, 1);
                    growl.addSuccessMessage('Auteur verwijderd');
                }, ErrorContainer.handleRestError);
            });
        }

        function showCreateAuthorDialog() {
            AuthorCreationModalService.show(function (author) {
                linkAuthorToBook(author);
            });
        }

        function showSelectAuthorDialog() {
            AuthorSelectionModalService.show(function (author) {
                linkAuthorToBook(author);
            });
        }

        function goToEditAuthor(author) {
            $location.path('/edit-author/' + author.id);
        }

        function linkAuthorToBook(author) {
            Book.linkAuthor({id: vm.book.id}, {authorId: author.id}, function () {
                vm.book.authors.push(author);
                growl.addSuccessMessage('Auteur toegevoegd');
            }, ErrorContainer.handleRestError);
        }

    }
}());