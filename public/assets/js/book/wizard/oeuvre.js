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
    return validate(validateOeuvreList);
}

$(".oeuvre-author-cross").on("click", function () {
    var trElement = $(this).parent().parent();
    var oeuvreId = $(this).parent().attr('oeuvre-id');

    ConfirmationDialog.show({
        message: 'Bent u zeker dat u oeuvre item wilt verwijderen?',
        onConfirmAction: function (){
            BookFromAuthorService.deleteBookFromAuthor({
                bookFromAuthorId: oeuvreId,
                showNotifications: true,
                onSuccess: function (){ trElement.remove(); }
            });
        }
    });
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