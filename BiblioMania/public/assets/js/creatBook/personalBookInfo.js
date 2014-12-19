$(document).ready(function() {
    	$("#star-rating").rating();
        var counter = 0;

        $(".reading-date-plus").click(function(){
            $('#reading-dates-table tr:last').after('<tr><td><input style="margin-bottom: 10px;" name="reading_date_counter" placeholder="select date" class="input-sm datepicker reading-date"></td></tr>');
            $(".datepicker").datepicker({
                format:"dd/mm/yyyy",
                autoclose: true
            });
        });

        $(".reading-date-min").click(function(){
            if($('#reading-dates-table tr').length > 1){
                $('#reading-dates-table tr:last').remove();
            }
        });

        $("#bookSubmitButton").click(function(){
           var dates = "";
           $(".reading-date").each(function(){
                dates = dates + $(this).val() + ",";
            });
           $("#personal_info_reading_date_input").val(dates);
        });

        $('#star').raty({
            score : 0,
            number: 10,
            path: 'assets/raty-2.7.0/lib/images',
            click: function(score, evt) {
                $('star-rating-input').val(score);
            }
        });
    });