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
        showError(errorMessage);
        return false;
    }
    hideError();
    return true;
}

$(".oeuvre-author-cross").on("click", function () {
    var trElement = $(this).parent().parent();
    var oeuvreId = $(this).parent().attr('oeuvre-id');
    //var author_oeuvre = $.grep(author_json.oeuvre, function (e) {
    //    return e.id == oeuvreId;
    //})[0];
    showConfirmDialog('Bent u zeker dat u dit wilt verwijderen?', "",
        function () {
            $.post(baseUrl + "/deleteBookFromAuthor",
                {
                    bookFromAuthorId: oeuvreId
                },
                function (data, status) {
                    if (status === "success") {
                        trElement.remove();
                    }
                }).fail(function () {
                    BootstrapDialog.show({
                        message: 'Er ging iets mis. Refresh de pagina even en probeer opnieuw!'
                    });
                });
        },
        function () {
        }
    );
});

$(".linkLabel").on("click", function () {
    var oeuvreId = $(this).parent().attr('oeuvre-id');
    var bookId = $(this).parent().attr('book-id');
    showConfirmDialog('Bent u zeker dat u dit wilt de link leggen?', "",
        function () {
            $.post(baseUrl + "/linkBookToBookFromAuthor",
                {
                    book_id: bookId,
                    book_from_author_id: oeuvreId
                },
                function (data, status) {
                    if (status === "success") {
                        location.reload();
                    }
                }).fail(function () {
                    BootstrapDialog.show({
                        message: 'Er ging iets mis. Refresh de pagina even en probeer opnieuw!'
                    });
                });
        },
        function () {
        }
    );
});