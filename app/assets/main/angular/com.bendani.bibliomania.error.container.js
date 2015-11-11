function ErrorContainer($scope, $location) {

    this.errorMessage="";

    this.handleRestError = function(data){
        if (data.status == undefined) {
            this.errorMessage = "unexpected error";
        } else if(data.status == 401){
            $location.path("/login");
        }else{
            this.errorMessage = "Er ging iets mis: " + data;
        }
    }

    this.setErrorMessage = function(message){
        this.errorMessage = message;
    }

};

angular.module('com.bendani.bibliomania.error.container', [])
    .service('ErrorContainer', ["$location", ErrorContainer]);