angular
    .module('com.bendani.php.common.wizardservice.wizard.directive', ['ngRoute', 'com.bendani.bibliomania.error.container', "com.bendani.bibliomania.dynamic.controller.directive"])
    .directive('wizard', function () {
        return {
            scope: {
                steps: "=",
                progressStep: "@",
                wizardPath: "@",
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/wizard/wizard-directive.html",
            controller: ['$rootScope', '$scope', '$controller', '$routeParams', '$http', '$location','ErrorContainer', function ($rootScope, $scope, $controller, $routeParams, $http, $location, ErrorContainer) {

                function retrieveModel() {
                    $http.get(getStepUrl()).then(
                        function (response) {
                            $scope.container.model = response.data;
                        }, ErrorContainer.handleRestError);
                }

                function init() {
                    $scope.container = {};
                    $scope.container.model = {};
                    $scope.currentStep = $scope.steps[$routeParams.step];

                    if ($routeParams.modelId != undefined) {
                        retrieveModel();
                        setLocationOnSteps();
                    }
                }

                var handleSuccessResponse = function (response) {
                    var nextStep = parseInt($routeParams.step) + 1;
                    $location.path($scope.wizardPath + "/" + nextStep + "/" + response.data);

                    NotificationRepository.addNotification({
                        title: "Boek opgeslagen",
                        message: "",
                        type: "success"
                    });
                };

                $scope.submitForm = function () {
                    if ($routeParams.modelId === undefined || $routeParams.modelId == '') {
                        $http.post($scope.currentStep.modelUrl, $scope.container.model).then(handleSuccessResponse, ErrorContainer.handleRestError);
                    }else{
                        $scope.container.model.id = $routeParams.modelId;
                        $http.put($scope.currentStep.modelUrl, $scope.container.model).then(handleSuccessResponse, ErrorContainer.handleRestError);
                    }
                };

                function setLocationOnSteps() {
                    for (var i = 0; i < $scope.steps.length; i++) {
                        var step = $scope.steps[i];
                        step.location = $scope.wizardPath + "/" + i + "/" + $routeParams.modelId;
                    }
                }

                function getStepUrl() {
                    var url = $rootScope.baseUrl.concat($scope.currentStep.modelUrl);
                    if ($routeParams.modelId !== undefined) {
                        url = url.concat("/").concat($routeParams.modelId);
                    }
                    return url;
                }

                init();
            }]
        };
    });