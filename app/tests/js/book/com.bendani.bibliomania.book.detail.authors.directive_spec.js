describe('com.bendani.bibliomania.book.detail.authors.directive', function () {
    'use strict';

    describe('BookDetailAuthorsController', function () {
        var BOOK = {id: 123, authors: ['author1', AUTHOR]};
        var AUTHOR = {id: 321, name: {firstname: 'firstname', lastname: 'lastname'}};
        var CREATED_AUTHOR = {id: 465};

        var vm, html, $compile, $httpBackend, $scope;
        var errorContainerMock, growlMock, locationMock;

        var confirmationModalServiceMock, modalServiceMock;
        var confirmationModalServiceMockShow = function (message, successCallback) {successCallback();};
        var modalServiceMockShow = function (successCallback) { successCallback(CREATED_AUTHOR); };

        beforeEach(function () {
            errorContainerMock = jasmine.createSpyObj('errorContainerMock', ['handleRestError', 'setErrorCode']);
            locationMock = jasmine.createSpyObj('locationMock', ['path']);
            growlMock = jasmine.createSpyObj('growlMock', ['addSuccessMessage']);
            confirmationModalServiceMock = jasmine.createSpyObj('confirmationModalServiceMock', ['show']);
            modalServiceMock = jasmine.createSpyObj('modalServiceMock', ['show']);

            confirmationModalServiceMock.show.and.callFake(confirmationModalServiceMockShow);
            modalServiceMock.show.and.callFake(modalServiceMockShow);

            html = '<book-detail-authors book="book"></book-detail-authors>';

            module('com.bendani.bibliomania.book.detail.authors.directive', function ($provide) {
                $provide.value('$location', locationMock);
                $provide.value('ErrorContainer', errorContainerMock);
                $provide.value('growl', growlMock);
                $provide.value('AuthorSelectionModalService', modalServiceMock);
                $provide.value('AuthorCreationModalService', modalServiceMock);
                $provide.value('ConfirmationModalService', confirmationModalServiceMock);
            });

            inject(['$rootScope', '$httpBackend', '$compile', function (_$rootScope_, _$httpBackend_, _$compile_) {
                $scope = _$rootScope_.$new();
                $httpBackend = _$httpBackend_;
                $compile = _$compile_;
            }]);
        });

        function _createController() {
            $httpBackend.expectGET('../BiblioMania/views/partials/book/book-detail-authors-directive.html').respond(200, 'somehtml');
            var directive = $compile(html)($scope);
            $scope.$digest();
            $httpBackend.flush();
            vm = directive.controller('bookDetailAuthors');

            vm.book = BOOK;
        }

        describe('unlinkAuthorFromBook', function () {
            it('unlinks author from book and removes it from model', function () {
                _createController();

                $httpBackend.expectPUT('../BiblioMania/books/123/unlink-author', {authorId: AUTHOR.id}).respond(200);

                vm.unlinkAuthorFromBook(AUTHOR);

                $httpBackend.flush();

                expect(confirmationModalServiceMock.show).toHaveBeenCalledWith('Wilt u auteur ' + AUTHOR.name.firstname + " " + AUTHOR.name.lastname + " verwijderen van het boek?", jasmine.any(Function));
                expect(vm.book.authors).not.toContain(AUTHOR);
                expect(growlMock.addSuccessMessage).toHaveBeenCalledWith('Auteur verwijderd');
            });
        });


        describe('showCreateAuthorDialog', function () {
            it('opens dialog and links author to book on creation', function () {
                _createController();

                $httpBackend.expectPUT('../BiblioMania/books/123/authors', {authorId: CREATED_AUTHOR.id}).respond(200);

                vm.showCreateAuthorDialog();

                $httpBackend.flush();

                expect(modalServiceMock.show).toHaveBeenCalled();
                expect(growlMock.addSuccessMessage).toHaveBeenCalledWith('Auteur toegevoegd');
                expect(vm.book.authors).toContain(CREATED_AUTHOR);
            });

            it('handles rest error if linking fails', function () {
                _createController();

                $httpBackend.expectPUT('../BiblioMania/books/123/authors', {authorId: CREATED_AUTHOR.id}).respond(500);

                vm.showCreateAuthorDialog();

                $httpBackend.flush();

                expect(errorContainerMock.handleRestError).toHaveBeenCalled();
            });
        });

        describe('showSelectAuthorDialog', function () {
            it('opens dialog and links author to book on creation', function () {
                _createController();

                $httpBackend.expectPUT('../BiblioMania/books/123/authors', {authorId: CREATED_AUTHOR.id}).respond(200);

                vm.showSelectAuthorDialog();

                $httpBackend.flush();

                expect(modalServiceMock.show).toHaveBeenCalled();
                expect(growlMock.addSuccessMessage).toHaveBeenCalledWith('Auteur toegevoegd');
                expect(vm.book.authors).toContain(CREATED_AUTHOR);
            });

            it('handles rest error if linking fails', function () {
                _createController();

                $httpBackend.expectPUT('../BiblioMania/books/123/authors', {authorId: CREATED_AUTHOR.id}).respond(500);

                vm.showSelectAuthorDialog();

                $httpBackend.flush();

                expect(errorContainerMock.handleRestError).toHaveBeenCalled();
            });
        });


        describe('goToEditAuthor', function () {
            it('redirects to edit author', function () {
                var author = {id: 123};

                _createController();

                vm.goToEditAuthor(author);


                expect(locationMock.path).toHaveBeenCalledWith('/edit-author/' + author.id);
            });
        });
    });
});