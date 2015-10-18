$(document).ready(function() {
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

function validateForm(){
    return validate();
}