describe('com.bendani.bibliomania.book.detail.directive', function () {

    describe('BookDetailDirectiveController', function () {
        var BOOK_ID = 123;
        var BOOK = {id: BOOK_ID};
        var FULL_BOOK = {id: BOOK_ID, title: 'title'};

        var vm, html, $httpBackend, $compile, $scope, errorContainerMock, dateServiceMock, currencyServiceMock;

        var bookOverviewServiceMock = {
            registerHandler: function (callback) {
                this.selectBookCallback = callback;
            },
            selectBook: function (book) {
                this.selectBookCallback(book);
            }
        };

        beforeEach(function () {
            errorContainerMock = jasmine.createSpyObj('errorContainerMock', ['handleRestError', 'setErrorCode']);
            dateServiceMock = jasmine.createSpyObj('dateServiceMock', ['addSuccessMessage']);
            currencyServiceMock = jasmine.createSpyObj('currencyServiceMock', ['addSuccessMessage']);
            spyOn(bookOverviewServiceMock, ['registerHandler']).and.callThrough();

            html = '<book-detail></book-detail>';

            module('com.bendani.bibliomania.book.detail.directive', function ($provide) {
                $provide.value('ErrorContainer', errorContainerMock);
                $provide.value('BookOverviewService', bookOverviewServiceMock);
                $provide.value('DateService', dateServiceMock);
                $provide.value('CurrencyService', currencyServiceMock);
            });

            inject(['$rootScope', '$httpBackend', '$compile', function (_$rootScope_, _$httpBackend_, _$compile_) {
                $scope = _$rootScope_.$new();
                $httpBackend = _$httpBackend_;
                $compile = _$compile_;
            }]);
        });

        function _createController() {
            $httpBackend.expectGET('../BiblioMania/views/partials/book/book-detail-directive.html').respond(200, 'somehtml');
            var directive = $compile(html)($scope);
            $scope.$digest();
            $httpBackend.flush();
            vm = directive.controller('bookDetail');
        }

        describe('init', function () {
            it('registers handler on bookOverviewService', function () {
                _createController();

                expect(bookOverviewServiceMock.registerHandler).toHaveBeenCalledWith(jasmine.any(Function));
            });
        });

        describe('on bookSelected', function () {
            it('when no book selected, bookDetailPanelOpen is set to true and selectedBook is retrieved and set', function () {
                _createController();
                vm.bookDetailPanelOpen = false;

                $httpBackend.expectGET('../BiblioMania/books/' + BOOK_ID).respond(200, FULL_BOOK);

                bookOverviewServiceMock.selectBook(BOOK);

                $httpBackend.flush();

                expect(vm.bookDetailPanelOpen).toBe(true);
                expect(vm.selectedBook).toEqual(jasmine.objectContaining(FULL_BOOK));
            });

            it('when same book selected, bookDetailPanelOpen is set to false', function () {
                _createController();
                vm.bookDetailPanelOpen = true;
                vm.selectedBook = FULL_BOOK;

                bookOverviewServiceMock.selectBook(BOOK);

                expect(vm.bookDetailPanelOpen).toBe(false);
            });

            it('when a book selected and another book is selected, other book is retrieved', function () {
                var otherBook = {id: 42};
                var fullOtherBook = {id: 42, title: 'otherTitle'};

                _createController();

                vm.bookDetailPanelOpen = true;
                vm.selectedBook = FULL_BOOK;

                $httpBackend.expectGET('../BiblioMania/books/' + 42).respond(200, fullOtherBook);

                bookOverviewServiceMock.selectBook(otherBook);

                $httpBackend.flush();

                expect(vm.bookDetailPanelOpen).toBe(true);
                expect(vm.selectedBook).toEqual(jasmine.objectContaining(fullOtherBook));
            });
        });

        describe('closeBookDetailPanel', function () {
            it('sets bookDetailPanelOpen to false', function () {
                _createController();

                vm.bookDetailPanelOpen = true;

                vm.closeBookDetailPanel();

                expect(vm.bookDetailPanelOpen).toBe(false);
            });
        });


    });

});
