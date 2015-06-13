<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title> {{ $title }} </title>

    {{--GOOGLE IMAGE SEARCH--}}
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    {{ HTML::script('assets/js/jquery.js'); }}

    <!-- BOOTSTRAP -->
    {{ HTML::script('assets/js/bootstrap.js'); }}
    {{ HTML::style('/assets/css/bootstrap.css') }}
    {{ HTML::style('assets/css/bootstrap-theme.css') }}

    <!-- DATEPICKER -->
    {{ HTML::script('assets/lib/datepicker/js/bootstrap-datepicker.js') }}
    {{ HTML::style('assets/lib/datepicker/css/datepicker.css') }}

    <!-- JASNY -->
    {{ HTML::script('assets/lib/jasny-bootstrap/js/jasny-bootstrap.min.js') }}
    {{ HTML::style('assets/lib/jasny-bootstrap/css/jasny-bootstrap.min.css') }}

    <!-- AUTOCOMPLETE -->
    {{ HTML::script('assets/lib/jquery.autocomplete.min.js') }}

    <!-- BOOTSTRAP-VALIDATOR -->
    {{ HTML::script('assets/lib/bootstrapvalidator/dist/js/bootstrapValidator.min.js') }}
    {{ HTML::script('assets/lib/bootstrapvalidator/dist/js/language/be_NL.js') }}
    {{ HTML::style('assets/lib/bootstrapvalidator/dist/css/bootstrapValidator.min.css') }}

    <!-- COLLAPSIBLE -->
    {{ HTML::script('assets/lib/jquery.collapsible.js') }}

    <!-- LESS SCRIPTS -->
    {{ HTML::style('assets/css/custom.css') }}
    {{ HTML::script('assets/js/custom.js') }}

    <!-- STAR RATING -->
    {{ HTML::script('assets/lib/bootstrap-star-rating/js/star-rating.min.js') }}
    {{ HTML::style('assets/lib/bootstrap-star-rating/css/star-rating.min.css') }}

    <!-- RATY -->
    {{ HTML::script('assets/lib/raty-2.7.0/lib/jquery.raty.js') }}
    {{ HTML::style('assets/lib/raty-2.7.0/lib/jquery.raty.css') }}

    <!-- SHORTEN -->
    {{ HTML::script('assets/lib/jquery.shorten.js') }}
    <!-- ISLOADING -->
    {{ HTML::script('assets/lib/isLoading/jquery.isloading.min.js') }}
    <!-- JCAPSLIDE -->
    {{ HTML::script('assets/lib/jCapSlide/jquery.capSlide.js') }}
    {{ HTML::style('assets/lib/jCapSlide/css/style.css') }}

    <!-- DIALOG -->
    {{ HTML::script('assets/lib/bootstrap3-dialog-master/dist/js/bootstrap-dialog.js') }}
    {{ HTML::style('assets/lib/bootstrap3-dialog-master/dist/css/bootstrap-dialog.css') }}

    {{--EDITABLE--}}
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
          rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <!-- DATATABLES -->
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
</head>

<body>

@section('header')
    <nav class="navbar navbar-default" role="navigation">
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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Lijsten
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li>{{ HTML::link('getAuthorsList', 'Auteurslijst', array('id'=>'authorsListNavigationLink', 'title' => 'Auteurslijst')) }}</li>
                            <li>{{ HTML::link('getPublishersList', 'Uitgeverslijst', array('id'=>'publishersListNavigationLink', 'title' => 'Uitgeverslijst')) }}</li>
                            <li>{{ HTML::link('getCountryList', 'Landenlijst', array('id'=>'countryListNavigationLink', 'title' => 'Landenlijst')) }}</li>
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
    });

    function redirectOnChange(sel) {
        window.document.location = $("option:selected", sel).attr("href");
    }
    var baseUrl = "{{ URL::to('/') }}";
</script>
</body>
</html>