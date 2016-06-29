describe('com.bendani.bibliomania.series.overview.ui', function () {
    describe('SeriesOverviewController', function () {
        var BOOK_ID = 12;
        var OTHER_BOOK_ID = 13;
        var SERIE_ID = 123;
        var PUBLISHER_ID = 456;

        var TITLE = 'some title';
        var BOOK = {
            id: BOOK_ID
        };
        var OTHER_BOOK = {
            id: OTHER_BOOK_ID
        };
        var FULL_BOOK = {
            id: BOOK_ID,
            title: 'title'
        };
        var OTHER_FULL_BOOK = {
            id: OTHER_BOOK_ID,
            title: 'other title'
        };

        var SERIE = {
            id: SERIE_ID,
            name: 'serie',
            publisherId: PUBLISHER_ID
        };
        var SERIES = [SERIE];

        var $scope, $httpBackend, $controller, vm, Serie;
        var errorContainerMock, titlePanelServiceMock, locationMock, editSerieModalServiceMock, confirmationModalServiceMock;
        var show = function (title, successFunction) {
            successFunction();
        };

        var onBookSelectedHandler;

        var bookOverviewServiceMock = {
            registerHandler: function (handler) {
                onBookSelectedHandler = handler;
            },
            selectBook: function(){}
        };

        beforeEach(function () {
            errorContainerMock = jasmine.createSpyObj('errorContainerMock', ['handleRestError', 'setErrorCode']);
            titlePanelServiceMock = jasmine.createSpyObj('titlePanelServiceMock', ['setTitle', 'setShowPreviousButton', 'setRightPanel']);
            locationMock = jasmine.createSpyObj('locationMock', ['path']);

            editSerieModalServiceMock = jasmine.createSpyObj('editSerieModalServiceMock', ['show']);
            confirmationModalServiceMock = jasmine.createSpyObj('ConfirmationModalServiceMock', ['show']);
            confirmationModalServiceMock.show.and.callFake(show);
            spyOn(bookOverviewServiceMock, 'registerHandler').and.callThrough();
            spyOn(bookOverviewServiceMock, 'selectBook');

            module('ngRoute');
            module('ngResource');
            module('com.bendani.bibliomania.serie.model');
            module('com.bendani.bibliomania.series.overview.ui');

            inject(function (_$rootScope_, _$httpBackend_, _$controller_, _Serie_) {
                $scope = _$rootScope_.$new();
                $httpBackend = _$httpBackend_;
                $controller = _$controller_;
                Serie = _Serie_;
            });
        });

        function _createController(type) {
            $httpBackend.expectGET('../BiblioMania/series').respond(200, SERIES);

            vm = $controller('SeriesOverviewController', {
                $scope: $scope,
                ErrorContainer: errorContainerMock,
                TitlePanelService: titlePanelServiceMock,
                BookOverviewService: bookOverviewServiceMock,
                $location: locationMock,
                EditSerieModalService: editSerieModalServiceMock,
                ConfirmationModalService: confirmationModalServiceMock,
                client: Serie,
                title: TITLE,
                type: type
            });

            $httpBackend.flush();
        }

        describe('init', function () {

            beforeEach(function(){
                _createController('SERIE');
            });

            it('calls title panel service with title and sets show previous button to false', function () {
                expect(titlePanelServiceMock.setTitle).toHaveBeenCalledWith(TITLE);
                expect(titlePanelServiceMock.setShowPreviousButton).toHaveBeenCalledWith(false);
            });

            it('registers handler on bookOverviewService', function () {
                expect(bookOverviewServiceMock.registerHandler).toHaveBeenCalledWith(jasmine.any(Function));
            });

            it('initializes vm correctly', function () {
                expect(vm.searchSeriesQuery).toEqual('');
                expect(vm.predicate).toEqual('name');
                expect(vm.reverseOrder).toEqual(false);
                expect(vm.orderValues).toEqual([{key: 'Naam', predicate: 'name', width: '50'}]);
            });

            it('loads series', function () {
                expect(vm.series[0]).toEqual(jasmine.objectContaining(SERIE));
                expect(vm.loading).toBe(false);
            });

        });

        describe('on book selected', function () {

            beforeEach(function(){
                _createController('SERIE');
            });

            it('opens book detail panel with selected book when no book selected', function () {
                $httpBackend.expectGET('../BiblioMania/books/' + BOOK_ID).respond(200, FULL_BOOK);

                onBookSelectedHandler(BOOK);

                $httpBackend.flush();

                expect(vm.bookDetailPanelOpen).toBe(true);
                expect(vm.selectedBook).toEqual(jasmine.objectContaining(FULL_BOOK));
            });

            it('closes book detail panel when panel already open and same book selected', function () {
                vm.bookDetailPanelOpen = true;
                vm.selectedBook = FULL_BOOK;

                onBookSelectedHandler(BOOK);

                expect(vm.bookDetailPanelOpen).toBe(false);
                expect(vm.selectedBook).toEqual(jasmine.objectContaining(FULL_BOOK));
            });

            it('retrieves new book when panel already open and other book selected', function () {
                $httpBackend.expectGET('../BiblioMania/books/' + OTHER_BOOK_ID).respond(200, OTHER_FULL_BOOK);
                vm.bookDetailPanelOpen = true;
                vm.selectedBook = FULL_BOOK;

                onBookSelectedHandler(OTHER_BOOK);

                $httpBackend.flush();

                expect(vm.bookDetailPanelOpen).toBe(true);
                expect(vm.selectedBook).toEqual(jasmine.objectContaining(OTHER_FULL_BOOK));
            });
        });

        describe('search', function () {

            beforeEach(function(){
                _createController('SERIE');
            });

            it('returns true when searchSeriesQuery part of itemName', function () {
                vm.searchSeriesQuery = 'bla';

                expect(vm.search({name: 'ieublaoifej'})).toBe(true);
            });

            it('returns true when searchSeriesQuery not part of itemName', function () {
                vm.searchSeriesQuery = '123';

                expect(vm.search({name: 'ieublaoifej'})).toBe(false);
            });
        });

        describe('onImageClickBook', function () {

            beforeEach(function(){
                _createController('SERIE');
            });

            it('calls bookOverviewService', function () {
                vm.onImageClickBook(BOOK);

                expect(bookOverviewServiceMock.selectBook).toHaveBeenCalledWith(BOOK);
            });
        });

        describe('editSerie', function () {
            it('calls EditSerieModalService with empty filters when type BOOK', function () {
                _createController('SERIE');

                vm.editSerie(SERIE);

                expect(editSerieModalServiceMock.show).toHaveBeenCalledWith(SERIE, [], Serie, jasmine.any(Function));
            });

            it('calls EditSerieModalService with correct filters when type PUBLISHER', function () {
                _createController('PUBLISHER');

                vm.editSerie(SERIE);

                expect(editSerieModalServiceMock.show).toHaveBeenCalledWith(SERIE, [{id: "book-publisher", value: [{value: PUBLISHER_ID}]}], Serie, jasmine.any(Function));
            });
        });

        describe('onEditBook', function () {

            beforeEach(function(){
                _createController('SERIE');
            });

            it('redirects to edit book', function () {
                vm.onEditBook(BOOK);

                expect(locationMock.path).toHaveBeenCalledWith('/book-details/' + BOOK_ID);
            });
        });

        describe('deleteSerie', function () {

            beforeEach(function(){
                _createController('SERIE');
            });

            it('calls confirmationModalService and deletes', function () {
                $httpBackend.expectDELETE('../BiblioMania/series/' + SERIE_ID).respond(204);

                vm.deleteSerie(vm.series[0]);

                $httpBackend.flush();

                expect(confirmationModalServiceMock.show).toHaveBeenCalledWith('Bent u zeker dat u deze serie wilt verwijderen?', jasmine.any(Function));
                expect(vm.series.length).toEqual(0);
            });
        });
    });

});
