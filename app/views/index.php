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
        <script type="text/javascript" src="assets/js/border_sliding_panel.js"></script>

        <!-- RATY -->
        <script type="text/javascript" src="assets/lib/raty-2.7.0/lib/jquery.raty.js"></script>
        <link href="assets/lib/raty-2.7.0/lib/jquery.raty.css">

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
    <body ng-controller="MainController" scrolling-directive>
        <div popover-close exclude-class="exclude">
            <div growl></div>

            <nav class="navbar navbar-default customNavbar navbar-fixed-top" role="navigation">
                    <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#/books">Bibliomania</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" ng-controller="HeaderController">
                    <ul class="nav navbar-nav">
                        <li ng-class="{ active: isActive('/books')}"><a href="#/books">Boeken</a></li>
                        <li ng-class="{ active: isActive('/authors')}"><a href="#/authors">Auteurs</a></li>
                        <li ng-class="{ active: isActive('/publishers')}"><a href="#/publishers">Uitgevers</a></li>
                        <li ng-class="{ active: isActive('/series')}"><a href="#/series">Boeken reeksen</a></li>
                    </ul>
                </div>
            </nav>

            <div class="contentContainer">
                <title-panel></title-panel>
                <div class="contentPanel" ng-view>
                    <!--use ng-view to insert content-->
                </div>
            </div>
        </div>
    </body>
</html>