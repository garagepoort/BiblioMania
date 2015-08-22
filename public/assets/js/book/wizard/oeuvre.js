$(function(){
    $('#author-oeuvre-table').DataTable({
        paging: false,
        order: [[ 1, "asc" ]]
    });

    $(".author-oeuvre-title").editable({
        validate: function (value) {
            if ($.trim(value) == '') {
                return 'This field is required';
            }
        }
    });

});

function validateForm() {
    formSubmitting = true;
    var errorMessage = validateOeuvreList();
    if (errorMessage) {
        showError(errorMessage);
        return false;
    }else {
        saveOeuvre();
    }
    hideError();
    return true;
}
function saveOeuvre(){
    $.post(baseUrl + "/saveBookFromAuthors",
        {
            author_id:author_id,
            oeuvre:$('#oeuvre-textarea').val()
        },
        function(data, status){
            if(status === "success"){
                //BootstrapDialog.show({
                //    message: 'Succesvol opgeslagen!'
                //});
                location.reload();
            }
        }).fail(function(data){
            BootstrapDialog.show({
                message: data.responseJSON.message
            });
        });
}
function validateOeuvreList() {
    var res = $('#oeuvre-textarea').val().split("\n");
    var errorMessage = null;
    if (res != null && res != "") {
        $.each(res, function (index, obj) {
            var splitString = obj.split(" - ");
            if (splitString.length < 2) {
                errorMessage = "Formaat is jaar - titel";
            } else {
                var year = splitString[0];
                var title = splitString[1];
                if (!title) {
                    errorMessage = "Titel moet ingevuld zijn";
                }
            }
        });
    }

    return errorMessage;
}

function addOeuvreItems(){
    validateForm();
}

$(".oeuvre-author-cross").on("click", function () {
    var trElement = $(this).parent().parent();
    var oeuvreId = $(this).parent().attr('oeuvre-id');
    //var author_oeuvre = $.grep(author_json.oeuvre, function (e) {
    //    return e.id == oeuvreId;
    //})[0];
    showConfirmDialog('Bent u zeker dat u dit wilt verwijderen?',"",
        function () {
            $.post(baseUrl + "/deleteBookFromAuthor",
                {
                    bookFromAuthorId: oeuvreId
                },
                function (data, status) {
                    if (status === "success") {
                        trElement.remove();
                        BootstrapDialog.show({
                            message: 'Succesvol verwijdert!'
                        });
                    }
                }).fail(function () {
                    BootstrapDialog.show({
                        message: 'Er ging iets mis. Refresh de pagina even en probeer opnieuw!'
                    });
                });
        },
        function(){}
    );
});