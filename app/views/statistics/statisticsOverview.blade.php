<div class="statistics-tab-container ">
    <div id="overviewContainer" class="chartContainer-overview material-card">
        <div class="material-card-title">overview</div>
        <div class="material-card-content">
            <div id="chart_div_books_overview" class="chartDiv"></div>
        </div>
    </div>
    <div class="card-row">

        <div id="genreContainer" class="chartContainer-genre card-column-left material-card">
            <div class="material-card-title">Genres</div>
            <div class="material-card-content">
                <div id="chart_div_books_per_genre" class="chartDiv"></div>
            </div>
        </div>

        <div id="booksReadPerYearContainer" class="chartContainer-genre material-card card-column-right"
             style="width: 32%">
            <div class="material-card-title">Boeken gelezen per jaar</div>
            <div class="material-card-content">
                <div id="chart_div_books_read_per_year" class="chartDiv"></div>
            </div>
        </div>

        <div id="booksAddedToCollectionPerYearContainer" class="chartContainer-genre material-card card-column-right">
            <div class="material-card-title">Boeken verkregen per jaar</div>
            <div class="material-card-content">
                <div id="chart_div_books_added_per_year" class="chartDiv"></div>
            </div>
        </div>
    </div>

    <div id="bookReadPerMonthContainer" class="chartContainer material-card" style="clear: both;">
        <div class="material-card-title">Boeken gelezen per jaar</div>
        <div class="material-card-content">
            <div id="chart_div_books_read_per_month" class="chartDiv"></div>
            {{--<div class="charChoice">--}}
            {{--@include('statistics.yearsSelect', array('selectId' => 'yearsBooksReadPerMonth', 'years' => $years))--}}
            {{--</div>--}}
        </div>
    </div>

    <div id="demoContainer" class="chartContainer material-card">
        <div class="material-card-title">Demographic</div>
        <div class="material-card-content">
            <div id="chart_div"></div>
        </div>
    </div>


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1.1", {
            packages: ["corechart", "bar"]
        });
        google.setOnLoadCallback(drawBooksReadPerMonthChart);
        google.setOnLoadCallback(drawOverviewChart);
        google.setOnLoadCallback(drawGenreChart);
        google.setOnLoadCallback(drawBooksAddedPerYearChart);
        google.setOnLoadCallback(drawBooksReadPerYearChart);
        google.setOnLoadCallback(drawChartScatter);
        function drawBooksReadPerMonthChart() {
            drawColumnChartFromUrl('chart_div_books_read_per_month', baseUrl + "/getBooksPerMonth/2014", 1000, 400);
        }
        function drawChartScatter() {
            drawScatterChart(baseUrl + "/getBooksAndPublicationDate", 1000, 400);
        }
        function drawOverviewChart() {
            drawBarChartFromUrl('chart_div_books_overview', baseUrl + "/getOverviewChart", 1000, 200);
        }
        function drawGenreChart() {
            drawDonutChartFromUrl('chart_div_books_per_genre', baseUrl + "/getBooksPerGenreChart", 320, 320);
        }
        function drawBooksAddedPerYearChart() {
            drawDonutChartFromUrl('chart_div_books_added_per_year', baseUrl + "/getBooksAddedPerYearChart", 320, 320);
        }
        function drawBooksReadPerYearChart() {
            drawDonutChartFromUrl('chart_div_books_read_per_year', baseUrl + "/getBooksReadPerYearChart", 320, 320);
        }
    </script>
    {{ HTML::script('assets/js/statistics/statistics.js'); }}
</div>