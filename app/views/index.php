<!DOCTYPE html>
<html lang="en" ng-app="BiblioMania">
    <head>
        <!--<link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('/') }}/favicon/favicon-32x32.png">-->
        <!--<link rel="icon" type="image/png" sizes="96x96" href="{{ URL::to('/') }}favicon/favicon-96x96.png">-->
        <!--<link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('/') }}favicon/favicon-16x16.png">-->
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <meta charset="UTF-8">
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
        <script type="text/javascript" src="assets/main.min.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/filter-service/filters.min.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/login-service/com.bendani.php.common.loginservice.authentication.model.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/login-service/com.bendani.php.common.loginservice.login.directive.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/uiframework/uiframework.min.js"></script>

        <link href="packages/bendani/php-common/filter-service/filters.min.css" rel="stylesheet">
        <link href="packages/bendani/php-common/uiframework/uiframework.min.css" rel="stylesheet">

        <link href="assets/main.min.css" rel="stylesheet">
        <script type="text/javascript" src="assets/js/angular/com.bendani.bibliomania.app.js"></script>
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
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Bibliomania</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <!--<li>{{ HTML::link('getBooks', 'Boeken', array('id'=>'booksNavigationLink', 'title' => 'Boeken')) }}</li>-->
                        <!--<li>{{ HTML::link('getAuthors', 'Auteurs', array('id'=>'authorsNavigationLink', 'title' => 'Auteurs')) }}</li>-->
                        <li class="dropdown navigation-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">Lijsten
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu navigation-dropdown-menu" role="menu">
                                <!--<li>{{ HTML::link('getBooksList', 'Boeken', array('id'=>'booksListNavigationLink', 'title' => 'Boeken')) }}</li>-->
                                <!--<li>{{ HTML::link('getDraftBooksList', 'Onvolledige Boeken', array('id'=>'draftBooksListNavigationLink', 'title' => 'Onvolledige boeken')) }}</li>-->
                                <!--<li>{{ HTML::link('getAuthorsList', 'Auteurs', array('id'=>'authorsListNavigationLink', 'title' => 'Auteurs')) }}</li>-->
                                <!--<li>{{ HTML::link('getPublishersList', 'Uitgevers', array('id'=>'publishersListNavigationLink', 'title' => 'Uitgevers')) }}</li>-->
                                <!--<li>{{ HTML::link('getCountryList', 'Landen', array('id'=>'countryListNavigationLink', 'title' => 'Landen')) }}</li>-->
                            </ul>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        @yield('navbarRight')
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
        </nav>

        <div class="contentContainer">
            <div class="title-panel">
                {{ title }}
                <div class="float-right vertical-align title-panel-buttons">
                    <!--set buttons on scope and loop over them-->
                </div>
            </div>
            <div class="contentPanel" ng-view>
                <!--use ng-view to insert content-->
            </div>
        </div>

        <script type="text/javascript">
            $(function () {
                $(".datepicker").datepicker({
                    format: "dd/mm/yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    todayBtn: "linked"
                });

                $(".multidatepicker").datepicker({
                    format: "dd/mm/yyyy",
                    multidate: true,
                    autoclose: true,
                    todayHighlight: true,
                    todayBtn: "linked"
                });
            });
        </script>
        <script type="text/javascript">
        $(window).load(function () {
            $(".clickableRow").click(function () {
                window.document.location = $(this).attr("href");
            });

            var d = new Date(),
                    month = d.getMonth();
            year = d.getYear();

            NotificationRepository.showNotifications();
        });

        function redirectOnChange(sel) {
            window.document.location = $("option:selected", sel).attr("href");
        }
//
//        var baseUrl = "{{ URL::to('/') }}";
//        @if(Auth::check())
//            var username = "{{ Auth::user()->username }}";
//        @endif

    </script>
    </body>
</html>