function validateBuyInfo() {
    var errorMessage = null;
    if($('#buy_info_city').val() != '' && $('#buy_info_country').val() == ''){
        errorMessage = "Land mag niet leeg zijn als stad winkel is ingevuld";
    }
    return errorMessage;
}

$(function() {
    togglePanels();


    $('#buy_info_country').autocomplete({
        lookup: window.country_names
    });

    $("#buyRadioButton, #giftRadioButton").change(function () {
        togglePanels();
    });

    function togglePanels(){
        if ($("#buyRadioButton").is(':checked')) {
            $('#giftInfoPanel').hide(200);
            $('#buyInfoPanel').show(200);
        }else{
            $('#buyInfoPanel').hide(200);
            $('#giftInfoPanel').show(200);
        }
    }
});