$(function () {
    $('#yearsBooksReadPerMonth').change(function () {
        drawColumnChartFromUrl('chart_div_books_read_per_month',
            baseUrl + "/getBooksPerMonth/" + $('#yearsBooksReadPerMonth').val(),
            '');
    });
});

function drawDonutChartFromUrl(div, url, width, height) {
    var options = {
        title: '',
        width: width,
        height: height,
        legend: {position: 'none'},
        pieHole: 0.4,
        animation: {
            duration: 1500,
            startup: true
        }
    };
    var columnChart = new google.visualization.PieChart(document.getElementById(div));
    var jsonData = getJsonData(url);
    data = new google.visualization.DataTable(jsonData);
    columnChart.draw(data, options);
}

function drawBarChartFromUrl(div, url, width, height) {
    var options = {
        title: '',
        width: width,
        height: height,
        bars: 'horizontal',
        legend: {position: 'none'},
        animation: {
            duration: 1500,
            startup: true
        }
    };
    var columnChart = new google.charts.Bar(document.getElementById(div));
    var jsonData = getJsonData(url);
    data = new google.visualization.DataTable(jsonData);
    columnChart.draw(data, options);
}

function drawColumnChartFromUrl(div, url, width, height) {
    var options = {
        title: '',
        width: width,
        height: height,
        animation: {
            duration: 1500,
            startup: true
        }
    };
    var columnChart = new google.visualization.ColumnChart(document.getElementById(div));
    var jsonData = getJsonData(url);
    data = new google.visualization.DataTable(jsonData);
    columnChart.draw(data, options);
}

function getJsonData(url) {
    return $.ajax({
        url: url,
        dataType: "json",
        async: false
    }).responseText;
}

function drawScatterChart(url, width, height) {
    var options = {
        width: width,
        height: height,
        chartArea: {
            left: 60,
            top: 10,
            width: "85%",
            height: "90%"
        },
        animation: {
            duration: 1500,
            startup: true
        },
        hAxis: {title: 'read in'},
        vAxis: {title: 'published in'},
        legend: 'none',
        tooltip: {isHtml: true}
    }

    data = getJsonData(url)

    var pubYearTable = new google.visualization.DataTable(data);

    var chart = new google.visualization.ScatterChart(document.getElementById("chart_div"));
    chart.draw(pubYearTable, options);

}