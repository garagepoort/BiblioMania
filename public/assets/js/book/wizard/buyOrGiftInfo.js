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
    $('#buy_info_shop').autocomplete({
        lookup: window.shop_names
    });
    $('#gift_info_from').autocomplete({
        lookup: window.gifter_names
    });

    $("#buyRadioButton, #giftRadioButton").change(function () {
        togglePanels();
    });

    function togglePanels(){
        var buyInfoBuyDate = $('#buy_info_buy_date');
        var giftInfoReceiptDate = $('#gift_info_receipt_date');
        if ($("#buyRadioButton").is(':checked')) {
            $('#giftInfoPanel').hide(200);
            $('#buyInfoPanel').show(200);

            if(buyInfoBuyDate.val() == ''){
                buyInfoBuyDate.val(giftInfoReceiptDate.val());
            }
        }else{
            $('#buyInfoPanel').hide(200);
            $('#giftInfoPanel').show(200);
            if(giftInfoReceiptDate.val() == ''){
                giftInfoReceiptDate.val(buyInfoBuyDate.val())
            }
        }
    }
});