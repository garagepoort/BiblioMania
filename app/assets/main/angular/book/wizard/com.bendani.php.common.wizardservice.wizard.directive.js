angular
    .module('com.bendani.php.common.wizardservice.wizard.directive', ['ngRoute', 'com.bendani.bibliomania.error.container', "com.bendani.bibliomania.dynamic.controller.directive"])
    .directive('wizard', function () {
        return {
            scope: {
                steps: "=",
                wizardPath: "@",
                onSaveStep: "&"
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
                    ErrorContainer.reset();

                    $scope.container = {};
                    $scope.container.model = {};
                    $scope.progressStep = 1;
                    $scope.currentStep = $scope.steps.filter(function(el){ return el.number == $routeParams.step; })[0];

                    if ($routeParams.modelId != undefined) {
                        retrieveModel();
                        setLocationOnSteps();
                    }
                }

                $scope.successHandler = function (response) {
                    var nextStep = parseInt($routeParams.step) + 1;
                    $location.path($scope.wizardPath + "/" + nextStep + "/" + response.data);
                };

                $scope.submitForm = function (successHandler) {
                    if ($routeParams.modelId === undefined || $routeParams.modelId == '') {
                        $http.post($scope.currentStep.modelUrl, $scope.container.model).then(function(response){
                            $scope.onSaveStep();
                            successHandler(response);
                        }, ErrorContainer.handleRestError);
                    }else{
                        $scope.container.model.id = $routeParams.modelId;
                        $http.put($scope.currentStep.modelUrl, $scope.container.model).then(function(response){
                            $scope.onSaveStep();
                            successHandler(response);
                        }, ErrorContainer.handleRestError);
                    }
                };

                $scope.getWizardClass = function(step){
                    if(step.number == $scope.currentStep.number){
                        return 'current';
                    }
                    if($scope.progressStep == 'COMPLETE' || step.number < $scope.currentStep.number){
                        return 'before';
                    }
                    if(step.number == $scope.progressStep){
                        return 'progress';
                    }
                    return '';
                };

                $scope.goToStep = function(step, formInvalid){
                    if(formInvalid){
                        ErrorContainer.setErrorMessage("Niet alle velden zijn correct ingevuld.");
                    }else if(step.number == $scope.currentStep.number+1 || step.number < $scope.currentStep.number){
                        var successHandler = function () {
                            $location.path(step.location);
                        };
                        $scope.submitForm(successHandler);
                    }
                };

                function setLocationOnSteps() {
                    for (var i = 0; i < $scope.steps.length; i++) {
                        var step = $scope.steps[i];
                        step.location = $scope.wizardPath + "/" + step.number + "/" + $routeParams.modelId;
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