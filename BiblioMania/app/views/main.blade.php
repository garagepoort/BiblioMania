<html ng-app="Huur">
    <head> 
        <title> {{ $title }} </title> 
    </head>
    {{ HTML::script('assets/js/jquery.js'); }}
    {{ HTML::script('assets/js/jasny-bootstrap.js'); }}
    {{ HTML::script('assets/js/bootstrap.js'); }}
    {{ HTML::script('assets/datepicker/js/bootstrap-datepicker.js') }}

    <!-- ANGULAR FILES
    {{ HTML::script('assets/js/angular/angularjs.js'); }}
    {{ HTML::script('assets/js/angular/app.js'); }}
    -->
    {{ HTML::style('/assets/css/bootstrap.css') }}
    {{ HTML::style('/assets/css/jasny-bootstrap.css') }}
    {{ HTML::style('assets/datepicker/css/datepicker.css') }}
    {{ HTML::style('assets/css/bootstrap-theme.css') }}
    {{ HTML::style('assets/css/myLayout.css') }}

    <body>

    @section('header')
        <div class="navbar navbar-default navbar-fixed-top">
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
        </div>
    @show

    <div class="container" style="margin-top: 80px">
        <div class="row">
            @include('navigationbar')

            <div class="col-md-10">
                <div class="container well col-md-8 editorContainer">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $(".datepicker").datepicker({
                format:'dd/mm/yyyy',
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