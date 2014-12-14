<html ng-app="Huur">
    <head> 
        <title> {{ $title }} </title> 
    </head>

    {{ HTML::script('assets/js/jquery.js'); }}

    <!-- BOOTSTRAP -->
    {{ HTML::script('assets/js/bootstrap.js'); }}
    {{ HTML::style('/assets/css/bootstrap.css') }}
    {{ HTML::style('assets/css/bootstrap-theme.css') }}

    <!-- DATEPICKER -->
    {{ HTML::script('assets/datepicker/js/bootstrap-datepicker.js') }}
    {{ HTML::style('assets/datepicker/css/datepicker.css') }}

    <!-- JASNY -->
    {{ HTML::script('assets/jasny-bootstrap/js/jasny-bootstrap.min.js') }}
    {{ HTML::style('assets/jasny-bootstrap/css/jasny-bootstrap.min.css') }}

    <!-- TYPEAHEAD -->
    {{ HTML::script('assets/js/typeahead.bundle.js') }}

    <!-- BOOTSTRAP-VALIDATOR -->
    {{ HTML::script('assets/bootstrapvalidator/dist/js/bootstrapValidator.min.js') }}
    {{ HTML::script('assets/bootstrapvalidator/dist/js/language/be_NL.js') }}
    {{ HTML::style('assets/bootstrapvalidator/dist/css/bootstrapValidator.min.css') }}

    <!-- COLLAPSIBLE -->
    {{ HTML::script('assets/js/jquery.collapsible.js') }}

    <!-- LESS SCRIPTS -->
    <link rel="stylesheet/less" type="text/css" href="assets/css/custom.less">
    <!-- LESS -->
    {{ HTML::script('assets/js/less.min.js') }}

    <!-- STAR RATING -->
    {{ HTML::script('assets/bootstrap-star-rating/js/star-rating.min.js') }}
    {{ HTML::style('assets/bootstrap-star-rating/css/star-rating.min.css') }}


    <body>

    @section('header')
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Bibliomania</a>
            </div>
             <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
              </ul>
              <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
              </form>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
        <!-- div class="titleBar navbar navbar-default navbar-fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <strong>{{ trans('messages.titelbalk.titel') }}</strong>
                </a>
                @if(UserManager::isLoggedIn() == true)
                    <button id="addButton" class="btn btn-primary clickableRow navbar-btn" href=" {{ URL::to('logOut') }}">
                        <span class="glyphicon glyphicon-log-out"></span> {{ trans('messages.titelbalk.afmelden') }}
                    </button>
                @endif
                <div class="pull-right navbar-btn" id="languageDiv">
                    {{ HTML::link('changeLanguage/nl', "nl", array('title' => 'NL')) }}
                    {{ HTML::link('changeLanguage/en', "en", array('title' => 'EN')) }}
                </div>
            </div>
        </div> -->
    @show

    <div class="container contentContainer" style="margin-top: 80px">
            @yield('content')
    </div>
    <script type="text/javascript">
        $(function() {
            $(".datepicker").datepicker({
                format:"dd/mm/yyyy",
                autoclose: true
            });
        });
    </script>
    <script type="text/javascript">
        $(window).load(function() {
            $(".clickableRow").click(function() {
                window.document.location = $(this).attr("href");
            });

            var d = new Date(),
            month = d.getMonth();
            year = d.getYear();
        });
        function redirectOnChange(sel){
            window.document.location = $("option:selected", sel).attr("href");
        }
    </script>
    </body>
</html>