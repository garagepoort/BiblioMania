describe('com.bendani.bibliomania.book.detail.first.print.info.directive', function () {

    describe('BookDetailFirstPrintInfoController', function () {

        var BOOK = {
            id: 123, firstPrintInfo: {
                id: 321
            }
        };

        var NEW_FIRST_PRINT = {id: 987};

        var vm, html, $httpBackend, $compile, $scope;
        var growlMock, locationMock, errorContainerMock, firstPrintSelectionModalServiceMock;

        var firstPrintSelectionModalServiceMockShow = function (callback) { callback(NEW_FIRST_PRINT);};

        beforeEach(function () {
            errorContainerMock = jasmine.createSpyObj('errorContainerMock', ['handleRestError', 'setErrorCode']);
            locationMock = jasmine.createSpyObj('locationMock', ['path']);
            growlMock = jasmine.createSpyObj('growlMock', ['addSuccessMessage']);
            firstPrintSelectionModalServiceMock = jasmine.createSpyObj('firstPrintSelectionModalServiceMock', ['show']);
            firstPrintSelectionModalServiceMock.show.and.callFake(firstPrintSelectionModalServiceMockShow);

            html = '<book-detail-first-print-info book="book"></book-detail-first-print-info>';

            module('com.bendani.bibliomania.book.detail.first.print.info.directive', function ($provide) {
                $provide.value('$location', locationMock);
                $provide.value('ErrorContainer', errorContainerMock);
                $provide.value('growl', growlMock);
                $provide.value('FirstPrintSelectionModalService', firstPrintSelectionModalServiceMock);
            });

            inject(['$rootScope', '$httpBackend', '$compile', function (_$rootScope_, _$httpBackend_, _$compile_) {
                $scope = _$rootScope_.$new();
                $httpBackend = _$httpBackend_;
                $compile = _$compile_;
            }]);

        });

        function _createController() {
            $httpBackend.expectGET('../BiblioMania/views/partials/book/book-detail-first-print-info-directive.html').respond(200, 'somehtml');
            var directive = $compile(html)($scope);
            $scope.$digest();
            $httpBackend.flush();
            vm = directive.controller('bookDetailFirstPrintInfo');

            vm.book = BOOK;
        }

        describe('showSelectFirstPrintDialog', function () {
            it('opensDialog and links book on success', function () {
                _createController();

                $httpBackend.expectPOST('../BiblioMania/firstprints/' + NEW_FIRST_PRINT.id + '/books', {bookId: BOOK.id}).respond(204);
                $httpBackend.expectGET('../BiblioMania/firstprints/' + NEW_FIRST_PRINT.id).respond(200, NEW_FIRST_PRINT);

                vm.showSelectFirstPrintDialog();

                $httpBackend.flush();

                expect(vm.book.firstPrintInfo).toEqual(jasmine.objectContaining(NEW_FIRST_PRINT));
                expect(growlMock.addSuccessMessage).toHaveBeenCalledWith('Eerste druk gewijzigd');
            });

            it('handles error when linking fails', function () {
                _createController();

                $httpBackend.expectPOST('../BiblioMania/firstprints/' + NEW_FIRST_PRINT.id + '/books', {bookId: BOOK.id}).respond(500);

                vm.showSelectFirstPrintDialog();

                $httpBackend.flush();

                expect(vm.book.firstPrintInfo).toEqual(jasmine.objectContaining(BOOK.firstPrintInfo));
                expect(errorContainerMock.handleRestError).toHaveBeenCalled();
            });

            it('handles error when retrieving new FirstPrintInfo fails', function () {
                _createController();

                $httpBackend.expectPOST('../BiblioMania/firstprints/' + NEW_FIRST_PRINT.id + '/books', {bookId: BOOK.id}).respond(204);
                $httpBackend.expectGET('../BiblioMania/firstprints/' + NEW_FIRST_PRINT.id).respond(500);

                vm.showSelectFirstPrintDialog();

                $httpBackend.flush();

                expect(vm.book.firstPrintInfo).toEqual(jasmine.objectContaining(BOOK.firstPrintInfo));
                expect(errorContainerMock.handleRestError).toHaveBeenCalled();
            });
        });

        describe('createFirstPrintInfo', function () {
            it('redirects to create first print info', function () {
                _createController();

                vm.createFirstPrintInfo();

                expect(locationMock.path).toHaveBeenCalledWith('/create-first-print-and-link-to-book/' + BOOK.id);
            });
        });

        describe('editFirstPrintInfo', function () {
            it('redirects to edit first print info', function () {
                _createController();

                vm.editFirstPrintInfo();

                expect(locationMock.path).toHaveBeenCalledWith('/edit-first-print/' + BOOK.firstPrintInfo.id);
            });
        });

    });
});
