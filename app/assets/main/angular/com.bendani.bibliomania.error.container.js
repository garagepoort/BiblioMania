function ErrorContainer($location) {

    this.errorMessage='';

    this.handleRestError = function(data){
        if(data === undefined || data.status === undefined){
            this.errorMessage = "Er ging iets mis: " + data;
        }

        else if(data.status == 401){
            $location.path("/login");
        }else{
            this.errorMessage = "Er is een onverwachte fout opgetreden: " + data;
        }
    };

    this.setErrorMessage = function(message){
        this.errorMessage = message;
    };

    this.reset = function(){
        this.errorMessage = '';
    }
}

angular.module('com.bendani.bibliomania.error.container', [])
    .service('ErrorContainer', ["$location", ErrorContainer]);