$(function () {

    $.fn.editable.defaults.mode = 'inline';

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
        showConfirmDialog('Bent u zeker dat u dit wilt verwijderen?', author_oeuvre.title + " - " + author_oeuvre.publication_year,
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

    doAuthorGoogleImageSearch();
});

function doAuthorGoogleImageSearch() {
    var searchString = author_json.name + ' ' + author_json.infix + ' ' + author_json.firstname;
    executeGoogleSearch(searchString, 'authorImageContent', 'authorImageUrl');
}