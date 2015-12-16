<!DOCTYPE html>
<html lang="en" ng-app="BiblioMania">
    <head>
        <!--<link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('/') }}/favicon/favicon-32x32.png">-->
        <!--<link rel="icon" type="image/png" sizes="96x96" href="{{ URL::to('/') }}favicon/favicon-96x96.png">-->
        <!--<link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('/') }}favicon/favicon-16x16.png">-->

        <script type="text/javascript" src="assets/js/jquery.js"></script>

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

        <script type="text/javascript">
            $('.collapse').on('shown.bs.collapse', function (e) {
                $('.collapse').not(this).removeClass('in');
            });

            $('[data-toggle=collapse]').click(function (e) {
                $('[data-toggle=collapse]').parent('li').removeClass('active');
                $(this).parent('li').toggleClass('active');
            });
        </script>
    </head>
    <body ng-controller="MainController">

        <div growl></div>
        <div class="container">
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Bibliomania</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="dropdown" style="background-color: #ec971f">
                            <a href="#/books" data-toggle="collapse" data-target="#one">Boeken</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" data-toggle="collapse" data-target="#two">Auteurs</a>
                        </li>
                    </ul>
            </nav>
        </div>

        <div class="contentContainer">
            <title-panel></title-panel>
            <div class="contentPanel" ng-view>
                <!--use ng-view to insert content-->
            </div>
        </div>
    </body>
</html>