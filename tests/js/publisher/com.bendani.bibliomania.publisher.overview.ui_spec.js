describe('com.bendani.bibliomania.publisher.overview.ui', function () {
    describe('PublishersOverviewController', function () {

        var PUBLISHER_ID = 123;
        var PUBLISHER = {
            id: PUBLISHER_ID
        };
        var PUBLISHERS = [PUBLISHER];

        var vm, $scope, $httpBackend, $controller, errorContainerMock, titlePanelServiceMock, confirmationModalServiceMock;
        var show = function (title, successFunction) {successFunction();};

        beforeEach(function(){
            errorContainerMock = jasmine.createSpyObj('errorContainerMock', ['handleRestError', 'setErrorCode']);
            titlePanelServiceMock = jasmine.createSpyObj('titlePanelServiceMock', ['setTitle', 'setShowPreviousButton', 'setRightPanel']);
            confirmationModalServiceMock = jasmine.createSpyObj('ConfirmationModalServiceMock', ['show']);
            confirmationModalServiceMock.show.and.callFake(show);

            module('ngRoute');
            module('ngResource');
            module('com.bendani.bibliomania.publisher.overview.ui');

            inject(function (_$rootScope_, _$httpBackend_, _$controller_) {
                $scope = _$rootScope_.$new();
                $httpBackend = _$httpBackend_;
                $controller = _$controller_;
            });

            _createController();
        });

        function _createController(){
            $httpBackend.expectGET('../BiblioMania/publishers').respond(200, PUBLISHERS);

            vm = $controller('PublishersOverviewController', {
                $scope: $scope,
                ErrorContainer: errorContainerMock,
                TitlePanelService: titlePanelServiceMock,
                ConfirmationModalService: confirmationModalServiceMock
            });

            $httpBackend.flush();
        }

        describe('init', function () {
            it('initializes values correct', function () {
                expect(titlePanelServiceMock.setTitle).toHaveBeenCalledWith('translation.publishers');
                expect(titlePanelServiceMock.setShowPreviousButton).toHaveBeenCalledWith(false);

                expect(vm.publishers[0]).toEqual(jasmine.objectContaining(PUBLISHER));
                expect(vm.searchSeriesQuery).toEqual("");

                expect(vm.orderValues).toEqual([{key: 'Naam', predicate: 'name', width: '50'}]);
                expect(vm.reverseOrder).toBe(false);
                expect(vm.predicate).toEqual("name");

                expect(vm.loading).toBe(false);
            });
        });

        describe('deletePublisher', function () {
            it('calls confirmationModalService and deletes', function () {
                $httpBackend.expectDELETE('../BiblioMania/publishers/' + PUBLISHER_ID).respond(204);

                vm.deletePublisher(vm.publishers[0]);

                $httpBackend.flush();

                expect(confirmationModalServiceMock.show).toHaveBeenCalledWith('Bent u zeker dat u deze uitgever wilt verwijderen?', jasmine.any(Function));
                expect(vm.publishers.length).toEqual(0);
            });
        });

        describe('search', function () {
            it('returns true when searchQuery has part of name', function () {

                vm.searchPublisherQuery = 'bli';

                expect(vm.search({ name: 'publisher'})).toBe(true);
            });

            it('returns false when searchQuery does not have part of name', function () {
                vm.searchPublisherQuery = 'oiu';

                expect(vm.search({ name: 'publisher'})).toBe(false);
            });

            it('returns false when searchQuery undefined', function () {
                vm.searchPublisherQuery = undefined;

                expect(vm.search({ name: 'publisher'})).toBe(true);
            });
        });


    });

});
