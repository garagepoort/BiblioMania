describe('com.bendani.bibliomania.create.author.directive', function () {

    var AUTHOR_ID = 123;
    var AUTHOR = {
        id: AUTHOR_ID,
        name: {
            firstname: 'firstname',
            lastname: 'lastname'
        }
    };
    var IMAGE = 'image';

    var vm, html, $httpBackend, $compile, $scope, errorContainerMock, growlMock, titlePanelServiceMock, imageSelectionModalServiceMock;
    var imageSelectionModalServiceMockShow = function (searchQuery, successCallback) { successCallback(IMAGE); };

    beforeEach(function () {
        errorContainerMock = jasmine.createSpyObj('errorContainerMock', ['handleRestError', 'setErrorCode']);
        titlePanelServiceMock = jasmine.createSpyObj('titlePanelServiceMock', ['setTitle']);
        growlMock = jasmine.createSpyObj('growlMock', ['addSuccessMessage']);

        imageSelectionModalServiceMock = jasmine.createSpyObj('imageSelectionModalServiceMock', ['show']);
        imageSelectionModalServiceMock.show.and.callFake(imageSelectionModalServiceMockShow);

        html = '<create-author author-model="author" on-save="onSave"></create-author>';

        module('com.bendani.bibliomania.create.author.directive', function ($provide) {
            $provide.value('ErrorContainer', errorContainerMock);
            $provide.value('growl', growlMock);
            $provide.value('ImageSelectionModalService', imageSelectionModalServiceMock);
            $provide.value('TitlePanelService', titlePanelServiceMock);
        });

        inject(function (_$rootScope_, _$httpBackend_, _$compile_) {
            $scope = _$rootScope_.$new();
            $httpBackend = _$httpBackend_;
            $compile = _$compile_;
        });

        _createController();
    });

    function _createController() {
        $httpBackend.expectGET('../BiblioMania/views/partials/author/create-author-directive.html').respond(200, 'somehtml');
        var directive = $compile(html)($scope);
        $scope.$digest();
        $httpBackend.flush();
        vm = directive.controller('createAuthor');

        vm.model = AUTHOR;
        vm.onSave = function () {
        };

        spyOn(vm, 'onSave');
    }

    describe('init', function () {
        it('set vm variables correctly', function () {
            expect(titlePanelServiceMock.setTitle).toHaveBeenCalledWith('translation.author');
            expect(vm.submitAttempted).toBe(false);
        });
    });

    describe('searchAuthorImage', function () {
        it('sets authorImageQuery correct if author defined', function () {
            vm.searchAuthorImage();

            expect(vm.authorImageQuery).toEqual('firstname lastname');
        });

        it('does not set authorImageQuery if author undefined', function () {
            vm.model = undefined;

            vm.searchAuthorImage();

            expect(vm.authorImageQuery).toBeUndefined();
        });

        it('does not set authorImageQuery if authorName undefined', function () {
            vm.model = {id: AUTHOR_ID};

            vm.searchAuthorImage();

            expect(vm.authorImageQuery).toBeUndefined();
        });
    });

    describe('openSelectImageDialog', function () {
        it('calls imageSelectionModalService with emptySearchString of authorName is undefined', function () {
            vm.model = {
                id: AUTHOR_ID,
                name: undefined
            };

            vm.openSelectImageDialog();

            expect(imageSelectionModalServiceMock.show).toHaveBeenCalledWith('', jasmine.any(Function));
            expect(vm.model.imageUrl).toEqual(IMAGE);
            expect(vm.model.image).toEqual(IMAGE);
        });

        it('calls imageSelectionModalService correctly with correct search string', function () {

            vm.openSelectImageDialog();

            expect(imageSelectionModalServiceMock.show).toHaveBeenCalledWith('firstname lastname', jasmine.any(Function));
            expect(vm.model.imageUrl).toEqual(IMAGE);
            expect(vm.model.image).toEqual(IMAGE);
        });
    });

    describe('submitForm', function () {
        it('calls errorContainer when form not valid', function () {
            vm.submitForm(false);

            expect(vm.submitAttempted).toBe(true);
            expect(errorContainerMock.setErrorCode).toHaveBeenCalledWith('translation.not.all.fields.have.been.filled.in');
        });

        describe('on update', function () {
            it('updates author when model has an id', function () {
                $httpBackend.expectPUT('../BiblioMania/authors').respond(200, {id: AUTHOR_ID});

                vm.submitForm(true);

                $httpBackend.flush();

                expect(growlMock.addSuccessMessage).toHaveBeenCalledWith('Auteur opgeslagen');
                expect(vm.onSave).toHaveBeenCalledWith({authorId: AUTHOR_ID});
            });

            it('calls errorcontainer when update fails', function () {
                $httpBackend.expectPUT('../BiblioMania/authors', AUTHOR).respond(500);

                vm.submitForm(true);

                $httpBackend.flush();

                expect(errorContainerMock.handleRestError).toHaveBeenCalled();
            });
        });


        describe('on creation', function () {

            var authorForCreation = {
                name: {
                    firstname: 'firstname',
                    lastname: 'lastname'
                }
            };

            beforeEach(function () {
                vm.model = authorForCreation;
            });

            it('saves author when model has no id', function () {
                $httpBackend.expectPOST('../BiblioMania/authors', authorForCreation).respond(200, {id: AUTHOR_ID});

                vm.submitForm(true);

                $httpBackend.flush();

                expect(growlMock.addSuccessMessage).toHaveBeenCalledWith('Auteur opgeslagen');
                expect(vm.onSave).toHaveBeenCalledWith({authorId: AUTHOR_ID});
            });

            it('calls errorcontainer when save fails', function () {
                $httpBackend.expectPOST('../BiblioMania/authors', authorForCreation).respond(500);

                vm.submitForm(true);

                $httpBackend.flush();

                expect(errorContainerMock.handleRestError).toHaveBeenCalled();
            });
        });

    });

});