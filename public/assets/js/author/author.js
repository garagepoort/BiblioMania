$(function () {

    $.fn.editable.defaults.mode = 'inline';

    var authorImageObject = getAuthorImageObject(author_json);
    $('#author-image-div').attr('style',
        getImageStyle(authorImageObject.height, authorImageObject.imageString, authorImageObject.spritePointer));

    $(".author-oeuvre-title").editable({
        validate: function (value) {
            if ($.trim(value) == '') {
                return 'This field is required';
            }
        }
    });

    $('#author-oeuvre-table').DataTable({
       paging: false
    });

    $(".oeuvre-author-cross").on("click", function () {
        var trElement = $(this).parent().parent();
        var oeuvreId = $(this).parent().attr('oeuvre-id');
        var author_oeuvre = $.grep(author_json.oeuvre, function (e) {
            return e.id == oeuvreId;
        })[0];
        BootstrapDialog.show({
            title: 'Bent u zeker dat u dit wilt verwijderen?',
            message: author_oeuvre.title + " - " + author_oeuvre.publication_year,
            buttons: [
                {
                    icon: "fa fa-check-circle",
                    label: 'Ja',
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        $.post(baseUrl + "/deleteBookFromAuthor",
                            {
                                bookFromAuthorId: oeuvreId
                            },
                            function (data, status) {
                                dialogItself.close();
                                if (status === "success") {
                                    trElement.remove();
                                    BootstrapDialog.show({
                                        message: 'Succesvol verwijdert!'
                                    });
                                }
                            }).fail(function () {
                                dialogItself.close();
                                BootstrapDialog.show({
                                    message: 'Er ging iets mis. Refresh de pagina even en probeer opnieuw!'
                                });
                            });
                    }
                },
                {
                    icon: "fa fa-times-circle",
                    label: 'Annuleer',
                    cssClass: 'btn-warning',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    });


});