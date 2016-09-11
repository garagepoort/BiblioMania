describe('com.bendani.bibliomania.reading.date.modal.service', function () {

    var READING_DATE_MODEL_ID = 12;
    var PERSONAL_BOOK_INFO_ID = 123;

    var READING_DATE_MODEL = {
        id: READING_DATE_MODEL_ID,
        rating: 5,
        date: '5/4/3012'
    };
    var READING_DATE_MODEL_WITHOUT_RATING = {
        id: READING_DATE_MODEL_ID,
        date: '5/4/3012'
    };
    var READING_DATE_MODEL_WITHOUT_ID = {
        rating: 5,
        date: '5/4/3012'
    };

    var $scope, $httpBackend, $controller;
    var errorContainerMock;

    beforeEach(function () {
        errorContainerMock = jasmine.createSpyObj('errorContainerMock', ['handleRestError', 'setErrorCode']);

        module('com.bendani.bibliomania.reading.date.modal.service');

        inject(function (_$rootScope_, _$httpBackend_, _$controller_) {
            $scope = _$rootScope_.$new();
            $scope.$close = function(){};
            $httpBackend = _$httpBackend_;
            $controller = _$controller_;
        });

        spyOn($scope, '$close');
    });

    function _createController(model) {
        $controller('ReadingDateModalController', {
            $scope: $scope,
            ErrorContainer: errorContainerMock,
            personalBookInfo: {
                personalBookInfoId: PERSONAL_BOOK_INFO_ID
            },
            readingDateModel: model
        });
    }


    describe('init', function () {
        it('adds datepicker options to scope', function () {
            _createController(READING_DATE_MODEL);
            expect($scope.datepicker.opened).toBe(false);
        });
        it('sets rating invalid to false', function () {
            _createController(READING_DATE_MODEL);
            expect($scope.ratingInvalid).toBe(false);
        });
        it('sets scope model to reading date model', function () {
            _createController(READING_DATE_MODEL);
            expect($scope.model).toEqual(READING_DATE_MODEL);
        });
        it('sets scope model to empty object when no readingDateModel given', function () {
            _createController(undefined);
            expect($scope.model).toEqual({});
        });
    });

    describe('openDatePicker', function () {
        it('sets datepicker open to true', function () {
            _createController(READING_DATE_MODEL);

            $scope.openDatePicker();

            expect($scope.datepicker.opened).toBe(true);
        });
    });


    describe('submitForm', function () {
        it('sets ratingInvalid when no rating given', function () {
            _createController(READING_DATE_MODEL_WITHOUT_RATING);
            $scope.model.rating = undefined;

            $scope.submitForm();

            expect($scope.ratingInvalid).toBe(true);
        });

        it('saves model when model has no id and put personalBookInfoId on model', function () {
            var newModelId = 321;
            var readingDateModel = {
                rating: READING_DATE_MODEL_WITHOUT_ID.rating,
                date: READING_DATE_MODEL_WITHOUT_ID.date,
                personalBookInfoId: PERSONAL_BOOK_INFO_ID
            };

            $httpBackend.expectPOST('../BiblioMania/reading-dates', readingDateModel).respond(200, {id: newModelId});
            _createController(READING_DATE_MODEL_WITHOUT_ID);

            $scope.submitForm();
            $httpBackend.flush();

            expect($scope.model.id).toEqual(newModelId);
            expect($scope.$close).toHaveBeenCalledWith($scope.model);
        });

        it('updates model when model has id and put personalBookInfoId on model', function () {
            var newModelId = 321;
            var readingDateModel = {
                id: READING_DATE_MODEL.id,
                rating: READING_DATE_MODEL.rating,
                date: READING_DATE_MODEL.date,
                personalBookInfoId: PERSONAL_BOOK_INFO_ID
            };

            $httpBackend.expectPUT('../BiblioMania/reading-dates', readingDateModel).respond(200);
            _createController(READING_DATE_MODEL);

            $scope.submitForm();
            $httpBackend.flush();

            expect($scope.$close).toHaveBeenCalledWith($scope.model);
        });
    });

});
