$(document).ready(function() {
    $.fn.editable.defaults.mode = 'inline';

    $(".namePublisher").editable({
        validate: function(value) {
            if($.trim(value) == '') {
                return 'This field is required';
            }
        }
    });

    $('.publisherlist-cross').on('click', function(){
        var tdElement = $(this).parent().parent();
        var publisherId = $(this).attr('publisher-id');
        showConfirmDialog('Bent u zeker dat u de uitgever wilt verwijderen?', '', function(){
            $.post(baseUrl + "/deletePublisher",
                {
                    publisherId:publisherId
                },
                function(data, status){
                    if(status === "success"){
                        tdElement.remove();
                        BootstrapDialog.show({
                            message: 'Succesvol verwijdert!'
                        });
                    }
                }).fail(function(data){
                    BootstrapDialog.show({
                        message: data.responseJSON.message
                    });
                });
        });
    });
});
