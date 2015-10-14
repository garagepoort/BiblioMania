$(document).ready(function() {
    $.fn.editable.defaults.mode = 'inline';
    var checkedCountry1;
    var checkedCountry2;


    var mergeCountriesFunction = function(){
        var MERGE_COUNTRIES_URL = baseUrl + "/mergeCountries";

        $.post(MERGE_COUNTRIES_URL,
            {
                country1_id:newMergePanel.getSelectedMergeId(),
                country2_id:newMergePanel.getSecondMergeId()
            },
            function(data, status){
                if(status === "success"){
                    showNotification('', 'Succesvol samengevoegd.', 'success');
                }
            }).fail(function(data){
                showNotification('Opgelet!', data.responseJSON.message, 'danger');
            });
    }

    var cancelMergeCountriesFunction = function(){
        checkedCountry1.prop('checked', false);
        checkedCountry2.prop('checked', false);
        checkedCountry1 = null;
        checkedCountry2 = null;
    }

    var newMergePanel = new MergePanel("countryMergePanel", mergeCountriesFunction, cancelMergeCountriesFunction);

    $('#countryEditList').DataTable({
        paging: false
    });

    $(".nameCountry").editable({
        validate: function(value) {
            if($.trim(value) == '') {
                return 'This field is required';
            }
        }
    });

    $('.merge-country-checkbox').on('click', function(){
        var countryId = $(this).parent().parent().attr('country-id');
        var countryName = $(this).parent().parent().attr('country-name');
        if($(this).is(':checked')) {
            if(checkedCountry1 == null){
                checkedCountry1 = $(this);
            }
            else if(checkedCountry2 == null){
                checkedCountry2 = $(this);
            }else{
                checkedCountry2.prop('checked', false);
                checkedCountry2 = $(this);
            }
            newMergePanel.checkMergeItem(countryId, countryName);
        }else{
            if($(this).is(checkedCountry1)){
                checkedCountry1 = null;
            }
            if($(this).is(checkedCountry2)){
                checkedCountry2 = null;
            }
            newMergePanel.uncheckItem(countryId);
        }
    });

    $('.countrylist-cross').on('click', function(){
        var trElement = $(this).parent().parent();
        var countryId = trElement.attr('country-id');

        ConfirmationDialog.show({
            message: 'Bent u zeker dat u het land wilt verwijderen?',
            onConfirmAction: function() {
                CountryService.deleteCountry({
                    countryId: countryId,
                    showNotifications: true,
                    onSuccess: function (){ trElement.remove(); }
                });
            }
        });
    });
});
