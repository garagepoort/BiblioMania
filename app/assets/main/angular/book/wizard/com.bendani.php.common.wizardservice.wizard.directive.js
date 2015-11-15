angular
    .module('com.bendani.php.common.wizardservice.wizard.directive', ['ngRoute', 'com.bendani.bibliomania.error.container', "com.bendani.bibliomania.dynamic.controller.directive"])
    .directive('wizard', function () {
        return {
            scope: {
                steps: "=",
                progressStep: "@",
                modelId: "@"
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/wizard/wizard-directive.html",
            controller: ['$rootScope', '$scope', '$controller', '$routeParams', '$http', 'ErrorContainer', function ($rootScope, $scope, $controller, $routeParams, $http, ErrorContainer) {

                function retrieveModel() {
                    $http.get(getStepUrl()).then(
                        function (response) {
                            $scope.container.model = response.data;
                        }, ErrorContainer.handleRestError);
                }

                function init() {
                    $scope.container = {};
                    $scope.container.model = {};
                    $scope.$watch('steps', function (newValue) {
                        if ($scope.steps != undefined) {
                            $scope.currentStep = $scope.steps[0];
                            if ($scope.modelId != undefined) {
                                retrieveModel();
                            }
                        }
                    });
                }

                var handleSuccessResponse = function (response) {
                    NotificationRepository.addNotification({
                        title: "Boek opgeslagen",
                        message: "",
                        type: "success"
                    });
                };

                $scope.submitForm = function () {
                    if ($scope.modelId === undefined) {
                        $http.post($scope.currentStep.modelUrl, $scope.container.model).then(handleSuccessResponse, ErrorContainer.handleRestError);
                    }else{
                        $scope.container.model.id = $scope.modelId;
                        $http.put($scope.currentStep.modelUrl, $scope.container.model).then(handleSuccessResponse, ErrorContainer.handleRestError);
                    }
                };


                function getStepUrl() {
                    var url = $rootScope.baseUrl.concat($scope.currentStep.modelUrl);
                    if ($scope.modelId !== undefined) {
                        url = url.concat("/").concat($scope.modelId);
                    }
                    return url;
                }

                init();
            }]
        };
    });