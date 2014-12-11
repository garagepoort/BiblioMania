<html ng-app="Huur">
    <head> 
        <title> {{ $title }} </title> 
    </head>

    {{ HTML::script('assets/js/jquery.js'); }}
    {{ HTML::script('assets/js/bootstrap.js'); }}
    {{ HTML::script('assets/datepicker/js/bootstrap-datepicker.js') }}

    <!-- JQUERY-UI -->
    {{ HTML::script('assets/jquery-ui/jquery-ui.js') }}
    {{ HTML::style('assets/jquery-ui/jquery-ui.css') }}

    {{ HTML::style('/assets/css/bootstrap.css') }}
    {{ HTML::style('assets/datepicker/css/datepicker.css') }}
    {{ HTML::style('assets/css/bootstrap-theme.css') }}
    {{ HTML::style('assets/css/myLayout.css') }}

    <!-- JASNY -->
    {{ HTML::script('assets/jasny-bootstrap/js/jasny-bootstrap.min.js') }}
    {{ HTML::style('assets/jasny-bootstrap/css/jasny-bootstrap.min.css') }}

    <!-- BOOTSTRAP-VALIDATOR -->
    {{ HTML::script('assets/bootstrapvalidator/dist/js/bootstrapValidator.min.js') }}
    {{ HTML::script('assets/bootstrapvalidator/dist/js/language/be_NL.js') }}
    {{ HTML::style('assets/bootstrapvalidator/dist/css/bootstrapValidator.min.css') }}
    <body>

    @section('header')
        <div class="titleBar navbar navbar-default navbar-fixed-top">
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

    <div class="container contentContainer" style="margin-top: 80px">
            @yield('content')
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