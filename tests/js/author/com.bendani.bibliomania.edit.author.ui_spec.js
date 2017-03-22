describe('com.bendani.bibliomania.edit.author.ui', function () {

    var AUTHOR_ID = 123;
    var AUTHOR = {
        name: {
            firstname: 'firstname',
            lastname: 'lastname'
        }
    };
    var OEUVRE_ITEM = {
        id: 321,
        title: 'oeuvre title',
        linkedBooks: ['book1', 'book2']
    };

    var BOOKS = [];
    var OEUVRE = ["oeuvre1", "oeuvre2"];
    var $routeParams = {id: AUTHOR_ID};

    var vm;
    var confirmationModalServiceMock, addOeuvreItemsModalServiceMock, permissionServiceMock;
    var confirmationModalServiceMockShow = function (title, successCallback) {successCallback();};
    var addOeuvreItemsModalServiceMockShow = function (authorId, successCallback) { successCallback(); };

    describe('EditAuthorController', function () {

        var $scope, $httpBackend, $controller, errorContainerMock, modal, $location;

        beforeEach(function () {
            errorContainerMock = jasmine.createSpyObj('errorContainerMock', ['handleRestError']);
            confirmationModalServiceMock = jasmine.createSpyObj('confirmationModalServiceMock', ['show']);
            permissionServiceMock = jasmine.createSpyObj('permissionServiceMock', ['hasAllowedPermissions']);
            addOeuvreItemsModalServiceMock = jasmine.createSpyObj('addOeuvreItemsModalServiceMock', ['show']);

            confirmationModalServiceMock.show.and.callFake(confirmationModalServiceMockShow);
            addOeuvreItemsModalServiceMock.show.and.callFake(addOeuvreItemsModalServiceMockShow);

            module('ngRoute');

            module('com.bendani.bibliomania.edit.author.ui', function ($provide) {
                $provide.value('ErrorContainer', errorContainerMock);
                $provide.value('ConfirmationModalService', confirmationModalServiceMock);
                $provide.value('PermissionService', permissionServiceMock);
                $provide.value('AddOeuvreItemsModalService', addOeuvreItemsModalServiceMock);
                $provide.value('$routeParams', $routeParams);
            });

            inject(function (_$controller_, _$httpBackend_, _$location_) {
                $httpBackend = _$httpBackend_;
                $controller = _$controller_;
                $location = _$location_;
            });
        });

        function _createController() {
            $httpBackend.expectGET('../BiblioMania/authors/' + AUTHOR_ID).respond(200, AUTHOR);
            $httpBackend.expectGET('../BiblioMania/authors/' + AUTHOR_ID + '/books').respond(200, BOOKS);
            $httpBackend.expectGET('../BiblioMania/authors/' + AUTHOR_ID + '/oeuvre').respond(200, OEUVRE);

            $scope = {$parent: {}};
            vm = $controller('EditAuthorController', {
                $scope: $scope,
                $location: $location
            });

            $httpBackend.flush();
        }

        describe('init', function () {
            it('initializes correct values', function () {
                _createController();
                expect(vm.model).toEqual(jasmine.objectContaining(AUTHOR));
                expect(vm.books).toEqual(jasmine.objectContaining(BOOKS));
                expect(vm.oeuvre).toEqual(jasmine.objectContaining(OEUVRE));
            });
        });

        describe('searchAuthorImage', function () {
            it('sets authorImageQuery correct if author defined', function () {
                _createController();

                vm.searchAuthorImage();

                expect(vm.authorImageQuery).toEqual('firstname lastname');
            });

            it('does not set authorImageQuery if author undefined', function () {
                _createController();
                vm.model = undefined;

                vm.searchAuthorImage();

                expect(vm.authorImageQuery).toBeUndefined();
            });
        });

        describe('linkLabel', function () {

            it('returns success label if oeuvre item has linked books', function () {
                _createController();

                var label = vm.linkLabel(OEUVRE_ITEM);

                expect(label).toEqual('label-success');
            });

            it('returns danger label if oeuvre item has no linked books', function () {
                _createController();

                var label = vm.linkLabel({linkedBooks: []});

                expect(label).toEqual('label-danger');
            });
        });

        describe('deleteOeuvreItem', function () {
            it('should open confirmationModal and delete oeuvre item', function () {
                var oeuvre = ['this', 'that'];

                _createController();
                $httpBackend.expectDELETE('../BiblioMania/oeuvre/' + OEUVRE_ITEM.id).respond(200);
                $httpBackend.expectGET('../BiblioMania/authors/' + AUTHOR_ID + '/oeuvre').respond(200, oeuvre);

                vm.deleteOeuvreItem(OEUVRE_ITEM);

                $httpBackend.flush();

                expect(confirmationModalServiceMock.show).toHaveBeenCalledWith('Bent u zeker dat u dit item wilt verwijderen: ' + OEUVRE_ITEM.title, jasmine.any(Function));
                expect(vm.oeuvre).toEqual(jasmine.objectContaining(oeuvre));
            });

        });

        describe('showAddOeuvreItemsDialog', function () {
            it('opens add oeuvre dialog and retrieves new oeuvreItems', function () {
                var oeuvre = ['this', 'that'];

                _createController();
                $httpBackend.expectGET('../BiblioMania/authors/' + AUTHOR_ID + '/oeuvre').respond(200, oeuvre);

                vm.showAddOeuvreItemsDialog();

                $httpBackend.flush();

                expect(vm.oeuvre).toEqual(jasmine.objectContaining(oeuvre));
            });
        });

        describe('goToOeuvreItem', function () {
            it('should navigate to edit oeuvre item', function () {
                spyOn($location, 'path');
                _createController();

                vm.goToOeuvreItem(OEUVRE_ITEM);

                expect($location.path).toHaveBeenCalledWith('/edit-oeuvre-item/' + OEUVRE_ITEM.id);
            });
        });

        describe('goToBook', function () {
            var book = {id: 12345};

            it('should navigate to book overview', function () {
                spyOn($location, 'path');
                _createController();

                vm.goToBook(book);

                expect($location.path).toHaveBeenCalledWith('/book-details/' + book.id);
            });
        });
    });
});