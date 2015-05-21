@extends('main')

@section('title')
    Statistieken
@stop
@section('content')
    {{ HTML::script('assets/js/statistics/statistics.js'); }}
    <!-- Chart Type -->
    <div class="statistics-container">
        <div id="bookReadPerMonthContainer">
            <h3>Boeken gelezen per maand</h3>
            <div class="form-container">
                @include('statistics.graphTypeSelect', array('selectId' => 'chartTypeBooksReadPerMonth'))
                @include('statistics.yearsSelect', array('selectId' => 'yearsBooksReadPerMonth', 'years' => $years))
            </div>
            <p>deodk</p>
            <div id="chart_div_books_read_per_month"></div>
        </div>

        <div id="bookRetrievedPerMonthContainer">
            <div class="form-container">
                <h3>Boeken verkregen per maand</h3>
                @include('statistics.graphTypeSelect', array('selectId' => 'chartTypeBooksRetrievedPerMonth'))
                @include('statistics.yearsSelect', array('selectId' => 'yearsBooksRetrievedPerMonth', 'years' => $years))
            </div>
            <p>deodk</p>
            <div id="chart_div_books_retrieved_per_month"></div>
        </div>

        <div id="chart_div"></div>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load('visualization', '1.0', {'packages':['corechart']});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                drawChartWrapper('chart_div_books_read_per_month', baseUrl + "/getBooksReadPerMonth/2014", '', $('#chartTypeBooksReadPerMonth'));
                drawChartWrapper('chart_div_books_retrieved_per_month', baseUrl + "/getBooksRetrievedPerMonth/2014", '', $('#chartTypeBooksRetrievedPerMonth'));
                drawScatterChart(baseUrl + "/getBooksAndPublicationDate");
            }
        </script>
    </div>
@stop