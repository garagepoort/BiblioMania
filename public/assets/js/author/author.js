$(function () {

    $.fn.editable.defaults.mode = 'inline';
    var imagesLookedUp = false;

    var authorImageObject = getAuthorImageObject(author_json);
    $('#author-image-div').attr('style',
        getImageStyle(authorImageObject.height, authorImageObject.width, authorImageObject.imageString, authorImageObject.spritePointer));

    $(".author-oeuvre-title").editable({
        validate: function (value) {
            if ($.trim(value) == '') {
                return 'This field is required';
            }
        }
    });

    $('#author-image-edit-wrapper').on("click", function(){
        $('#author-image-upload-div').toggle();
        if(!imagesLookedUp){
            doAuthorGoogleImageSearch();
            imagesLookedUp = true;
        }
    });


    $('#author-oeuvre-table').DataTable({
       paging: false,
        order: [[ 1, "asc" ]]
    });

    $(".oeuvre-author-cross").on("click", function () {
        var trElement = $(this).parent().parent();
        var oeuvreId = $(this).parent().attr('oeuvre-id');
        var author_oeuvre = $.grep(author_json.oeuvre, function (e) {
            return e.id == oeuvreId;
        })[0];

        ConfirmationDialog.show({
            message: 'Bent u zeker dat u item ' + author_oeuvre.title +' wilt verwijderen?',
            onConfirmAction: function (){
                BookFromAuthorService.deleteBookFromAuthor({
                    bookFromAuthorId: oeuvreId,
                    showNotifications: true,
                    onSuccess: function (){ trElement.remove(); }
                });
            }
        });
    });
});

function doAuthorGoogleImageSearch() {
    var searchString = author_json.name + ' ' + author_json.infix + ' ' + author_json.firstname;
    executeGoogleSearch(searchString);
}