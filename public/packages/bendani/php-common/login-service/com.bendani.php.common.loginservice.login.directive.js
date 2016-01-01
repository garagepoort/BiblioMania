angular.module('com.bendani.php.common.loginservice.login.directive', ['com.bendani.php.common.loginservice.authentication.model', 'com.bendani.bibliomania.error.container'])
    .directive('login', ['Authentication', '$rootScope', 'ErrorContainer',function (Authentication, $rootScope, ErrorContainer){
        return {
            scope: true,
            restrict: "E",
            template : '<div ng-include="getTemplateUrl()"></div>',
            controller: ['$scope', function($scope) {
                $scope.login = function (user) {
                    Authentication.save(user, function (data){
                        $rootScope.loggedInUser = data;
                    },
                    function(error){
                        ErrorContainer.setErrorMessage("Login mislukt. Gebruikersnaam en/of wachtwoord is fout.");
                    });
                };

                $scope.getTemplateUrl = function(){
                    return $scope.$parent.baseUrl + "packages/bendani/php-common/login-service/login.html";
                }
            }]
        };
    }]);