$(function () {
    $('#author-oeuvre-table').DataTable({
        paging: false,
        order: [[1, "asc"]]
    });

    $(".author-oeuvre-title").editable({
        validate: function (value) {
            if ($.trim(value) == '') {
                return 'This field is required';
            }
        }
    });

    //fillInOeuvreTextArea();

});

function validateForm() {
    formSubmitting = true;
    var errorMessage = validateOeuvreList();
    if (errorMessage) {
        showError("error-div", errorMessage);
        return false;
    }
    hideError("error-div");
    return true;
}

$(".oeuvre-author-cross").on("click", function () {
    var trElement = $(this).parent().parent();
    var oeuvreId = $(this).parent().attr('oeuvre-id');
    showConfirmDialog('Bent u zeker dat u dit wilt verwijderen?', "",
        function () {
            $.post(baseUrl + "/deleteBookFromAuthor",
                {
                    bookFromAuthorId: oeuvreId
                },
                function (data, status) {
                    if (status === "success") {
                        showNotification('Succes!', 'Het oeuvre item is succesvol verwijdert.', 'success');
                        trElement.remove();
                    }
                }).fail(function () {
                    showNotification('Opgelet!', 'Er ging iets mis probeer het later opnieuw.', 'danger');
                });
        },
        function () {
        }
    );
});

$(".linkLabel").on("click", function () {
    var oeuvreId = $(this).parent().attr('oeuvre-id');
    var bookId = $(this).parent().attr('book-id');

    ConfirmationDialog.show({
        message: 'Bent u zeker dat u dit wilt de link leggen?',
        onConfirmAction: function(){
            BookFromAuthorService.linkBook({
                bookId: bookId,
                bookFromAuthorId: oeuvreId,
                showNotifications: true,
                onSuccess: function(){
                    location.reload();
                }
            });
        }
    });
});