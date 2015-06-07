$(function () {
    $('#yearsBooksReadPerMonth').change(function () {
        drawColumnChartFromUrl('chart_div_books_read_per_month',
            baseUrl + "/getBooksPerMonth/" + $('#yearsBooksReadPerMonth').val(),
            '');
    });
});

function drawColumnChartFromUrl(div, url, title) {
    var options = {
        title: title,
        width: 400,
        height: 300,
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

function drawScatterChart(url) {
    var options = {
        width: 800,
        height: 600,
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