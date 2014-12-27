<html>
    <head> 
        <meta charset="UTF-8">
        <title> {{ $title }} </title> 
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

        <!-- AUTOCOMPLETE -->
        {{ HTML::script('assets/js/jquery.autocomplete.min.js') }}

        <!-- BOOTSTRAP-VALIDATOR -->
        {{ HTML::script('assets/bootstrapvalidator/dist/js/bootstrapValidator.min.js') }}
        {{ HTML::script('assets/bootstrapvalidator/dist/js/language/be_NL.js') }}
        {{ HTML::style('assets/bootstrapvalidator/dist/css/bootstrapValidator.min.css') }}

        <!-- COLLAPSIBLE -->
        {{ HTML::script('assets/js/jquery.collapsible.js') }}

        <!-- LESS SCRIPTS -->
        {{ HTML::style('assets/css/custom.css') }}

        <!-- STAR RATING -->
        {{ HTML::script('assets/bootstrap-star-rating/js/star-rating.min.js') }}
        {{ HTML::style('assets/bootstrap-star-rating/css/star-rating.min.css') }}

        <!-- RATY -->
        {{ HTML::script('assets/raty-2.7.0/lib/jquery.raty.js') }}
        {{ HTML::style('assets/raty-2.7.0/lib/jquery.raty.css') }}

        <!-- SHORTEN -->
        {{ HTML::script('assets/js/jquery.shorten.js') }}


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
                <li><a href="#">Auteurs</a></li>
              </ul>
              
              <ul class="nav navbar-nav navbar-right">
                {{ Form::open(array('url' => 'getBooksFromSearch', 'method' => 'GET' ,'class' => 'navbar-form navbar-left')) }}
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Search" name="criteria">
                    </div>
                    {{ Form::submit('Search', array('class' => 'btn btn-default')) }}
                {{ Form::close() }}
              </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>

    @show

    <div class="container contentContainer">
            @yield('content')
    </div>
    <script type="text/javascript">
        $(function() {
            $(".datepicker").datepicker({
                format:"dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true,
                todayBtn: "linked"
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