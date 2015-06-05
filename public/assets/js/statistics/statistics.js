$(function () {
    $('#yearsBooksReadPerMonth').change(function () {
        drawChartWrapper('chart_div_books_read_per_month',
            baseUrl + "/getBooksReadPerMonth/" + $('#yearsBooksReadPerMonth').val(),
            '',
            $('#chartTypeBooksReadPerMonth'));
    });

    $('#yearsBooksRetrievedPerMonth').change(function () {
        drawChartWrapper('chart_div_books_retrieved_per_month',
            baseUrl + "/getBooksRetrievedPerMonth/" + $('#yearsBooksRetrievedPerMonth').val(),
            '',
            $('#chartTypeBooksRetrievedPerMonth'));
    });
});

function drawChartWrapper(div, url, title, chartTypeSwitcher) {
    var data = new google.visualization.DataTable(getJsonData(url));
    var wrap = new google.visualization.ChartWrapper({
        'chartType': chartTypeSwitcher.val(),
        'dataTable': data,
        'containerId': div,
        'options': {
            'title': title,
            'width': 600,
            'height': 300
        }
    });
    wrap.draw();
    chartTypeSwitcher.change(function () {
        wrap.setChartType(chartTypeSwitcher.val());
        wrap.draw();
    });
}

function drawBarChart(div, url, title) {
    var jsonData = getJsonData(url)

    var data = new google.visualization.DataTable(jsonData);
    var options = {
        'title': title,
        'width': 400,
        'height': 300
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.BarChart(document.getElementById(div));
    chart.draw(data, options);
}

function drawColumnChart(div, url, title) {
    var jsonData = getJsonData(url)

    var data = new google.visualization.DataTable(jsonData);
    var options = {
        'title': title,
        'width': 400,
        'height': 300
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.ColumnChart(document.getElementById(div));
    chart.draw(data, options);
}

function drawPieChart(div, url, title) {
    var jsonData = getJsonData(url);

    var data = new google.visualization.DataTable(jsonData);
    var options = {
        'title': title,
        'width': 400,
        'is3D': true,
        'height': 300
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById(div));
    chart.draw(data, options);
}

function getJsonData(url) {
    return $.ajax({
        url: url,
        dataType: "json",
        async: false
    }).responseText;
}

function drawScatterChart(url) {
    data = getJsonData(url)

    var pubYearTable = new google.visualization.DataTable(data);
    //pubYearTable.addColumn('date', 'read in');
    //pubYearTable.addColumn('date', 'published in');
    //pubYearTable.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
    //pubYearTable.addRows(84);
    //pubYearTable.setValue( 0, 0, new Date(2014, 7, 1) );
    //pubYearTable.setValue( 0, 1, new Date(1926, 1, 1) );
    //pubYearTable.setValue( 0, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/17399434">All the Sad Young Men</a><br><b>Read:</b> August  1, 2014' + "<br><b>Published:</b> " + 1926 );
    //pubYearTable.setValue( 1, 0, new Date(2014, 7, 27) );
    //pubYearTable.setValue( 1, 1, new Date(1937, 1, 1) );
    //pubYearTable.setValue( 1, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/11935305">Of Mice and Men</a><br><b>Read:</b> August 27, 2014' + "<br><b>Published:</b> " + 1937 );
    //pubYearTable.setValue( 2, 0, new Date(2014, 6, 2) );
    //pubYearTable.setValue( 2, 1, new Date(1949, 1, 1) );
    //pubYearTable.setValue( 2, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/3744438">Nineteen Eighty-Four</a><br><b>Read:</b> July  2, 2014' + "<br><b>Published:</b> " + 1949 );
    //pubYearTable.setValue( 3, 0, new Date(2015, 2, 23) );
    //pubYearTable.setValue( 3, 1, new Date(1979, 1, 1) );
    //pubYearTable.setValue( 3, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/531757">Tales of the Unexpected</a><br><b>Read:</b> March 23, 2015' + "<br><b>Published:</b> " + 1979 );
    //pubYearTable.setValue( 4, 0, new Date(2015, 1, 8) );
    //pubYearTable.setValue( 4, 1, new Date(2007, 1, 1) );
    //pubYearTable.setValue( 4, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/564882">Sold as a Slave (Penguin Great Journeys)</a><br><b>Read:</b> February  8, 2015' + "<br><b>Published:</b> " + 2007 );
    //pubYearTable.setValue( 5, 0, new Date(2014, 3, 3) );
    //pubYearTable.setValue( 5, 1, new Date(1993, 1, 1) );
    //pubYearTable.setValue( 5, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/18274584">The Virgin Suicides</a><br><b>Read:</b> April  3, 2014' + "<br><b>Published:</b> " + 1993 );
    //pubYearTable.setValue( 6, 0, new Date(2015, 3, 13) );
    //pubYearTable.setValue( 6, 1, new Date(1958, 1, 1) );
    //pubYearTable.setValue( 6, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/8882740">Things Fall Apart</a><br><b>Read:</b> April 13, 2015' + "<br><b>Published:</b> " + 1958 );
    //pubYearTable.setValue( 7, 0, new Date(2014, 9, 21) );
    //pubYearTable.setValue( 7, 1, new Date(2005, 1, 1) );
    //pubYearTable.setValue( 7, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/21528366">A Feast for Crows</a><br><b>Read:</b> October 21, 2014' + "<br><b>Published:</b> " + 2005 );
    //pubYearTable.setValue( 8, 0, new Date(2015, 3, 5) );
    //pubYearTable.setValue( 8, 1, new Date(2006, 1, 1) );
    //pubYearTable.setValue( 8, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/2848513">The Secret of Lost Things: A Novel</a><br><b>Read:</b> April  5, 2015' + "<br><b>Published:</b> " + 2006 );
    //pubYearTable.setValue( 9, 0, new Date(2015, 1, 15) );
    //pubYearTable.setValue( 9, 1, new Date(2004, 1, 1) );
    //pubYearTable.setValue( 9, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/985758">The Tent</a><br><b>Read:</b> February 15, 2015' + "<br><b>Published:</b> " + 2004 );
    //pubYearTable.setValue( 10, 0, new Date(2014, 1, 18) );
    //pubYearTable.setValue( 10, 1, new Date(1999, 1, 1) );
    //pubYearTable.setValue( 10, 2, '<a class="bookTitle" href="https://www.goodreads.com/book/show/903167">Timbuktu</a><br><b>Read:</b> February 18, 2014' + "<br><b>Published:</b> " + 1999 );
    //pubYearTable.setValue( 11, 0, new Date(2014, 11, 19) );

    var chart = new google.visualization.ScatterChart(document.getElementById("chart_div"));
    chart.draw(pubYearTable, {
        width: 1000,
        height: 600,
        chartArea:{
            left:60,
            top:10,
            width:"85%",
            height:"90%"
        },
        hAxis: {title: 'read in'},
        vAxis: {title: 'published in'},
        legend: 'none',
        tooltip: {isHtml: true}
    });

}