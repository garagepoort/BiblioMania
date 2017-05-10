<!DOCTYPE html>
<html lang="en" ng-app="BiblioMania">
    <head>
        <!--<link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('/') }}/favicon/favicon-32x32.png">-->
        <!--<link rel="icon" type="image/png" sizes="96x96" href="{{ URL::to('/') }}favicon/favicon-96x96.png">-->
        <!--<link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('/') }}favicon/favicon-16x16.png">-->

        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/underscore.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/uiframework/uiframework.min.js"></script>

        <script type="text/javascript" src="assets/main.min.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/filter-service/filters.min.js"></script>
        <script type="text/javascript" src="packages/bendani/php-common/login-service/loginservice.min.js"></script>

        <link href="packages/bendani/php-common/filter-service/filters.min.css" rel="stylesheet"/>
        <link href="packages/bendani/php-common/uiframework/uiframework.min.css" rel="stylesheet"/>

        <link href="assets/main.min.css" rel="stylesheet">

        <!-- RATY -->
        <script type="text/javascript" src="assets/lib/raty-2.7.0/lib/jquery.raty.js"></script>
        <link href="assets/lib/raty-2.7.0/lib/jquery.raty.css">

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
    <body ng-controller="MainController" scrolling-directive>
        <div popover-close exclude-class="exclude">


            <div growl></div>

            <nav class="navbar navbar-toggleable-md navbar-default navbar-fixed-top" style="margin-bottom: 0px;">
                <a class="navbar-brand" href="#/books">Bibliomania</a>
                <div ng-if="loggedInUser" style="float: right; margin-right: 20px; margin-top: 10px;">
                    <button ng-click="logOut()" id="logout-button" class="btn btn-warning btn-sm">Log out</button>
                </div>
            </nav>

            <div class="row">
                <!-- uncomment code for absolute positioning tweek see top comment in css -->
                <!-- <div class="absolute-wrapper"> </div> -->
                <!-- Menu -->
                <div ng-if="loggedInUser" class="side-menu" style="text-align: left; margin-top: 50px;">

                    <nav class="navbar navbar-default" role="navigation">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <div class="brand-wrapper">
                                <!-- Hamburger -->
                                <button type="button" class="navbar-toggle">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                        </div>

                        <!-- Main Menu -->
                        <div class="side-menu-container">
                            <ul class="nav navbar-nav">

                                <li ng-class="{ active: isActive('/books')}"><a href="#/books"><i class="fa fa-book"></i> Boeken</a></li>
                                <li ng-class="{ active: isActive('/authors')}"><a href="#/authors"><i class="fa fa-user"></i> Auteurs</a></li>
                                <li ng-class="{ active: isActive('/publishers')}"><a href="#/publishers"><i class="fa fa-book"></i> Uitgevers</a></li>
                                <li ng-class="{ active: isActive('/series')}"><a href="#/series"><i class="fa fa-list"></i> Boeken reeksen</a></li>
                                <li ng-class="{ active: isActive('/publisherseries')}"><a href="#/publisherseries"><i class="fa fa-list"></i> Uitgever reeksen</a></li>
                                <li ng-class="{ active: isActive('/statistics')}"><a href="#/statistics"><i class="fa fa-line-chart"></i> Statistieken</a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </nav>

                </div>

                <!-- Main Content -->
                <div class="container-fluid">
                    <div class="side-body">
                        <div class="contentContainer">
                            <title-panel></title-panel>
                            <div class="contentPanel" ng-view>
                                <!--use ng-view to insert content-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
