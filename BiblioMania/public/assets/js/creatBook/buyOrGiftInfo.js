$(function() {
    $("#buyRadioButton, #giftRadioButton").change(function () {
        if ($("#buyRadioButton").is(':checked')) {
            $('#giftInfoPanel').hide(200);
            $('#buyInfoPanel').show(200);
        }else{
            $('#buyInfoPanel').hide(200);
            $('#giftInfoPanel').show(200);
        }
    });
});