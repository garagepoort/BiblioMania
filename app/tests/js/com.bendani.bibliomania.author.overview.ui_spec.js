describe('com.bendani.bibliomania.author.overview.ui', function () {
    describe('AuthorsOverviewController', function () {
        var AUTHORS = ['author1', 'author2'];

        var $scope, $httpBackend, $controller, vm;
        var errorContainerMock, titlePanelServiceMock, authorCreationModalServiceMock, locationMock;
        var authorCreationModalServiceMock = {
            show: function (successFunction) {
                successFunction();
            }
        };

        beforeEach(function () {
            errorContainerMock = jasmine.createSpyObj('errorContainerMock', ['handleRestError', 'setErrorCode']);
            titlePanelServiceMock = jasmine.createSpyObj('titlePanelServiceMock', ['setTitle', 'setShowPreviousButton', 'setRightPanel']);
            locationMock = jasmine.createSpyObj('locationMock', ['path']);
            spyOn(authorCreationModalServiceMock, ['show']).and.callThrough();

            module('ngRoute');
            module('ngResource');
            module('com.bendani.bibliomania.author.overview.ui');

            inject(['$rootScope', '$httpBackend', '$controller', function (_$rootScope_, _$httpBackend_, _$controller_) {
                $scope = _$rootScope_.$new();
                $httpBackend = _$httpBackend_;
                $controller = _$controller_;
            }]);

            _createController();
        });

        function _createController() {
            $httpBackend.expectGET('../BiblioMania/authors').respond(200, AUTHORS);

            vm = $controller('AuthorsOverviewController', {
                $scope: $scope,
                $location: locationMock,
                AuthorCreationModalService: authorCreationModalServiceMock,
                ErrorContainer: errorContainerMock,
                TitlePanelService: titlePanelServiceMock
            });

            $httpBackend.flush();
        }

        describe('init', function () {
            it('initializes titlePanel correctly', function () {
                expect(titlePanelServiceMock.setTitle).toHaveBeenCalledWith('translation.authors');
                expect(titlePanelServiceMock.setShowPreviousButton).toHaveBeenCalledWith(false);
                expect(titlePanelServiceMock.setRightPanel).toHaveBeenCalled();
            });

            it('initializes variables correctly', function () {
                expect(vm.searchAuthorsQuery).toEqual('');
                expect(vm.predicate).toEqual('name.lastname');
                expect(vm.orderValues).toEqual([
                    {key: 'Voornaam', predicate: 'name.firstname', width: '50'},
                    {key: 'Naam', predicate: 'name.lastname', width: '50'}
                ]);
                expect(vm.reverseOrder).toBe(false);
                expect(vm.loading).toBe(false);
                expect(vm.authors).toEqual(jasmine.objectContaining(AUTHORS));
            });
        });

        describe('search', function () {
            it('returns true when firstname contains searchQuery', function(){
                var author = {name: {firstname: 'firstname', lastname: 'lastname'}};
                vm.searchAuthorsQuery = 'irst';

                expect(vm.search(author)).toBe(true);
            });

            it('returns true when lastname contains searchQuery', function(){
                var author = {name: {firstname: 'firstname', lastname: 'lastname'}};
                vm.searchAuthorsQuery = 'ast';

                expect(vm.search(author)).toBe(true);
            });

            it('returns false when lastname and firstname does not contains searchQuery', function(){
                var author = {name: {firstname: 'firstname', lastname: 'lastname'}};
                vm.searchAuthorsQuery = 'wwere';

                expect(vm.search(author)).toBe(false);
            });
        });

        describe('goToAuthorDetails', function(){
            it('redirects correctly', function(){
                var author = {id: 123};

                vm.goToAuthorDetails(author);

                expect(locationMock.path).toHaveBeenCalledWith('/edit-author/' + author.id);
            });
        });

        describe('showCreateAuthorDialog', function(){
           it('opens modal and retrieves authors on save', function(){
               $httpBackend.expectGET('../BiblioMania/authors').respond(200, AUTHORS);

               vm.showCreateAuthorDialog();

               $httpBackend.flush();

               expect(authorCreationModalServiceMock.show).toHaveBeenCalled();
           });
        });
    });
});