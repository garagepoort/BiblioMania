$(document).ready(function() {
	$("#star-rating").rating();

    $(".reading-date-plus").click(function(){
        var table = $('#reading-dates-table');
        addReadingDateRowToTable(table, '');
    });

    $(".reading-date-min").click(function(){
        if($('#reading-dates-table tr').length > 1){
            $('#reading-dates-table tr:last').remove();
        }
    });

    var readingDateString = $("#personal_info_reading_date_input").val();
    readingDateArray = readingDateString.split(",");
    var arrayLength = readingDateArray.length;
    var table = $('#reading-dates-table');
    for (var i = 0; i < arrayLength; i++) {
        addReadingDateRowToTable(table, readingDateArray[i]);
    }

    function addReadingDateRowToTable(table, date){
        var tableRow = $('<tr></tr>');
        var tableData = $('<td></td>');
        tableRow.append(tableData);
        tableData.append('<input style="margin-bottom: 10px;" ' +
        'id="reading_date_input_' + $('#reading-dates-table tr').length + '"' +
        'name="reading_date_counter" ' +
        'placeholder="select date" ' +
        'class="input-sm datepicker reading-date" ' +
        'value='+ date +
        '>');
        table.append(tableRow);
        $(".datepicker").datepicker({
            format:"dd/mm/yyyy",
            autoclose: true
        });
    }


    $("#createOrEditBookForm").submit(function(){
       var dates = "";
       $(".reading-date").each(function(){
            dates = dates + $(this).val() + ",";
        });
       $("#personal_info_reading_date_input").val(dates);
        return true;
    });

    $('#star').raty({
        score: function() {
            return $('#star-rating-input').val();
        },
        number: 10,
        path: baseUrl + '/assets/lib/raty-2.7.0/lib/images',
        click: function(score, evt) {
            $('#star-rating-input').val(score);
        }
    });

    $('#personal-info-owned-checkbox').change(function() {
        if($(this).is(':checked')) {
            $('#reason-not-owned-panel').hide(250);
        }else{
            $('#reason-not-owned-panel').show(250);
        }    
    });

    if($('#personal-info-owned-checkbox').is(':checked')){
        $('#reason-not-owned-panel').hide(250);
    }else{
        $('#reason-not-owned-panel').show(250);
    }
});