<!DOCTYPE html>
<html lang="en" ng-app="BiblioMania">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- injector:js -->
        <script src="packages/bendani/php-common/uiframework/jquery.js"></script>
        <script src="packages/bendani/php-common/uiframework/uiframework.min.js"></script>
        <script src="assets/js/underscore.js"></script>
        <script src="assets/lib/match-media.js"></script>
        <script src="assets/lib/raty-2.7.0/lib/jquery.raty.js"></script>
        <script src="assets/main.min.716b5ac883.js"></script>
        <script src="packages/bendani/php-common/filter-service/filters.min.js"></script>
        <script src="packages/bendani/php-common/login-service/loginservice.min.js"></script>
        <!-- endinjector -->

        <!-- injector:css -->
        <link rel="stylesheet" href="packages/bendani/php-common/filter-service/filters.min.css">
        <link rel="stylesheet" href="packages/bendani/php-common/uiframework/uiframework.min.css">
        <link rel="stylesheet" href="assets/lib/raty-2.7.0/lib/jquery.raty.css">
        <link rel="stylesheet" href="assets/main.min.40bbc8051b.css">
        <!-- endinjector -->

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
                                <button type="button" class="navbar-toggle" ng-click="toggleSlideIn()">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                        </div>

                        <!-- Main Menu -->
                        <div class="side-menu-container">
                            <ul class="nav navbar-nav" ng-class="{'slide-in' : slideInOpen}">

                                <li ng-class="{ active: isActive('/books')}" ng-click="toggleSlideIn()"><a href="#/books"><i class="fa fa-book"></i> Boeken</a></li>
                                <li ng-class="{ active: isActive('/authors')}" ng-click="toggleSlideIn()"><a href="#/authors"><i class="fa fa-user"></i> Auteurs</a></li>
                                <li ng-class="{ active: isActive('/publishers')}" ng-click="toggleSlideIn()"><a href="#/publishers"><i class="fa fa-book"></i> Uitgevers</a></li>
                                <li ng-class="{ active: isActive('/series')}" ng-click="toggleSlideIn()"><a href="#/series"><i class="fa fa-list"></i> Boeken reeksen</a></li>
                                <li ng-class="{ active: isActive('/publisherseries')}" ng-click="toggleSlideIn()"><a href="#/publisherseries"><i class="fa fa-list"></i> Uitgever reeksen</a></li>
                                <li ng-class="{ active: isActive('/statistics')}" ng-click="toggleSlideIn()"><a href="#/statistics"><i class="fa fa-line-chart"></i> Statistieken</a></li>
                            </ul>

                            <!-- Main Menu -->
                            <div class="side-menu-container nav navbar-nav">
                                <random-fact ng-repeat="randomFact in randomFacts" fact="randomFact"></random-fact>
                            </div>
                        </div>
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
