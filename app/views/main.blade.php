<html>
    <head>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('/') }}/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ URL::to('/') }}favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('/') }}favicon/favicon-16x16.png">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <meta charset="UTF-8">
        <title> {{ $title }} </title>

        {{--GOOGLE IMAGE SEARCH--}}
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

        {{ HTML::script('assets/js/jquery.js', ["type" => "text/javascript"]); }}

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        {{ HTML::script('assets/main.min.js', ["type" => "text/javascript"]) }}
        {{ HTML::style('assets/main.min.css', ["type" => "text/css"]) }}

                <!-- BOOTSTRAP-VALIDATOR -->
        {{ HTML::script('assets/lib/bootstrapvalidator/dist/js/bootstrapValidator.min.js', ["type" => "text/javascript"]) }}
        {{ HTML::script('assets/lib/bootstrapvalidator/dist/js/language/be_NL.js', ["type" => "text/javascript"]) }}
        {{ HTML::style('assets/lib/bootstrapvalidator/dist/css/bootstrapValidator.min.css', ["type" => "text/css"]) }}

                <!-- LESS SCRIPTS -->
        {{ HTML::script('assets/js/border_sliding_panel.js', ["type" => "text/javascript"]) }}

                <!-- RATY -->
        {{ HTML::script('assets/lib/raty-2.7.0/lib/jquery.raty.js', ["type" => "text/javascript"]) }}
        {{ HTML::style('assets/lib/raty-2.7.0/lib/jquery.raty.css', ["type" => "text/css"]) }}

                <!-- TAGS -->
        {{ HTML::script('assets/lib/sliptree-bootstrap-tokenfield/bootstrap-tokenfield.js', ["type" => "text/javascript"]) }}
        {{ HTML::style('assets/lib/sliptree-bootstrap-tokenfield/css/bootstrap-tokenfield.min.css', ["type" => "text/css"]) }}

        {{--EDITABLE--}}
        <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
              rel="stylesheet">
        <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

        <!-- DATATABLES -->
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8"
                src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
        <link rel="stylesheet" type="text/css"
              href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">

        {{--Tweenlite--}}
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.17.0/TweenMax.min.js" type="text/javascript"></script>
    </head>
    <body>

        @section('header')
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Bibliomania</a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li>{{ HTML::link('getBooks', 'Boeken', array('id'=>'booksNavigationLink', 'title' => 'Boeken')) }}</li>
                            <li>{{ HTML::link('getAuthors', 'Auteurs', array('id'=>'authorsNavigationLink', 'title' => 'Auteurs')) }}</li>
                            <li class="dropdown navigation-dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">Lijsten
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu navigation-dropdown-menu" role="menu">
                                    <li>{{ HTML::link('getBooksList', 'Boeken', array('id'=>'booksListNavigationLink', 'title' => 'Boeken')) }}</li>
                                    <li>{{ HTML::link('getDraftBooksList', 'Onvolledige Boeken', array('id'=>'draftBooksListNavigationLink', 'title' => 'Onvolledige boeken')) }}</li>
                                    <li>{{ HTML::link('getAuthorsList', 'Auteurs', array('id'=>'authorsListNavigationLink', 'title' => 'Auteurs')) }}</li>
                                    <li>{{ HTML::link('getPublishersList', 'Uitgevers', array('id'=>'publishersListNavigationLink', 'title' => 'Uitgevers')) }}</li>
                                    <li>{{ HTML::link('getCountryList', 'Landen', array('id'=>'countryListNavigationLink', 'title' => 'Landen')) }}</li>
                                </ul>
                            </li>
                            <li>{{ HTML::link('goToStatistics', 'Statistieken', array('id'=>'goToStatisticsNavigationLink', 'title' => 'Statistieken')) }}</li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            @yield('navbarRight')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
            </nav>
        @show

        <div class="contentContainer">
            <div class="title-panel">
                @yield('title')
            </div>
            <div class="contentPanel">
                @yield('content')
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

        var baseUrl = "{{ URL::to('/') }}";
        @if(Auth::check())
            var username = "{{ Auth::user()->username }}";
        @endif

    </script>
    </body>
</html>