<!DOCTYPE html>
<html lang="en" ng-app="BiblioMania">
    <head>
        <!--<link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('/') }}/favicon/favicon-32x32.png">-->
        <!--<link rel="icon" type="image/png" sizes="96x96" href="{{ URL::to('/') }}favicon/favicon-96x96.png">-->
        <!--<link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('/') }}favicon/favicon-16x16.png">-->
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
        <meta charset="UTF-8" />
        <title></title>

        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <!--GOOGLE IMAGE SEARCH-->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


        <!--ANGULAR-->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular-route.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular-resource.js"></script>

        <!--BiblioMania-->
        <script type="text/javascript" src="assets/js/underscore.js"></script>
        <script type="text/javascript" src="assets/main.min.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/filter-service/filters.min.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/login-service/com.bendani.php.common.loginservice.authentication.model.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/login-service/com.bendani.php.common.loginservice.login.directive.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/uiframework/uiframework.min.js"></script>

        <link href="packages/bendani/php-common/filter-service/filters.min.css" rel="stylesheet"/>
        <link href="packages/bendani/php-common/uiframework/uiframework.min.css" rel="stylesheet"/>

        <link href="assets/main.min.css" rel="stylesheet">
        <script type="text/javascript" src="assets/js/border_sliding_panel.js"></script>

        <!-- RATY -->
        <script type="text/javascript" src="assets/lib/raty-2.7.0/lib/jquery.raty.js"></script>
        <link href="assets/lib/raty-2.7.0/lib/jquery.raty.css">

        <!--TWEENLITE-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>

        <!--ABN TREE-->
        <link href="assets/lib/abntree/abn-tree.css" rel="stylesheet">
        <script type="text/javascript" src="assets/lib/abntree/abn-tree-directive.js"></script>
    </head>
    <body ng-controller="MainController">

        <div growl></div>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Bibliomania</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"></div>
            </div>
        </nav>

        <div class="contentContainer">
            <title-panel></title-panel>
            <div class="contentPanel" ng-view>
                <!--use ng-view to insert content-->
            </div>
        </div>
    </body>
</html>