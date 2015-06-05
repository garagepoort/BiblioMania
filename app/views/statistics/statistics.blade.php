@extends('main')

@section('title')
    Statistieken
@stop
@section('content')
    {{ HTML::script('assets/js/statistics/statistics.js'); }}
    <!-- Chart Type -->
    <div class="statistics-container">
        <div id="bookReadPerMonthContainer" class="chartContainer">
            <table>
                <tr>
                    <td>
                        <div id="chart_div_books_read_per_month" class="chartDiv"></div>
                    </td>
                    <td>
                        <div class="charChoice">
                            @include('statistics.graphTypeSelect', array('selectId' => 'chartTypeBooksReadPerMonth'))
                            @include('statistics.yearsSelect', array('selectId' => 'yearsBooksReadPerMonth', 'years' => $years))
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div id="chart_div"></div>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load('visualization', '1.0', {'packages':['corechart']});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                drawChartWrapper('chart_div_books_read_per_month', baseUrl + "/getBooksPerMonth/2014", 'Boeken per maand', $('#chartTypeBooksReadPerMonth'));
                drawScatterChart(baseUrl + "/getBooksAndPublicationDate");
            }
        </script>
    </div>
@stop