var lastKnownAuthor;
var lastSetAuthorName;
var lastSetAuthorFirstname;
var lastSetAuthorInfix;
var lastLoadedOeuvre;
var oeuvreMessage = 'Dit boek is gelinked aan het oeuvre van deze auteur. Als je deze auteur verandert gaat deze link verloren ben je zeker dat je dit wilt doen?';

$(function () {

    $('#secondary_authors_input').tokenfield({
        autocomplete: window.author_names,
        delimiter: ';',
        createTokensOnBlur: true
    });
    //$('#secondary_authors_input').tokenfield('disable');

    $('#author-image-self-upload-checkbox').change(function () {
        if ($(this).is(':checked')) {
            $('#author-image-self-upload-panel').show(250);
            $('#author-image-google-search-panel').hide(250);
        } else {
            $('#author-image-self-upload-panel').hide(250);
            $('#author-image-google-search-panel').show(250);
        }
    });

    $('#author-info-tab-link').click(function () {
        fillInAuthorNamesFromBookInfo();
        doAuthorGoogleImageSearch();
    });

    $('#author_name').focusout(function () {
        if (lastSetAuthorName !== getAuthorName()) {
            if (isBookLinked()) {
                showConfirmDialog('Bent u zeker?', oeuvreMessage, function () {
                    lastSetAuthorName = getAuthorName();
                    doAuthorGoogleImageSearch();
                    unlink();
                    fillInOeuvre();
                }, function () {
                    setAuthorName(lastSetAuthorName);
                });
            } else {
                lastSetAuthorName = getAuthorName();
                fillAuthorInput();
                doAuthorGoogleImageSearch();
                fillInOeuvre();
            }
        }
    });

    $('#author_firstname').focusout(function () {
        if (lastSetAuthorFirstname !== getAuthorFirstName()) {
            if (isBookLinked()) {
                showConfirmDialog('Bent u zeker?', oeuvreMessage, function () {
                    lastSetAuthorFirstname = getAuthorFirstName();
                    doAuthorGoogleImageSearch();
                    unlink();
                    fillInOeuvre();
                }, function () {
                    setAuthorFirstName(lastSetAuthorFirstname);
                });
            } else {
                lastSetAuthorFirstname = getAuthorFirstName();
                fillAuthorInput();
                doAuthorGoogleImageSearch();
                fillInOeuvre();
            }
        }
    });

    $('#author_infix').focusout(function () {
        if (lastSetAuthorInfix !== getAuthorInfix()) {
            if (isBookLinked()) {
                showConfirmDialog('Bent u zeker?', oeuvreMessage, function () {
                    lastSetAuthorInfix = getAuthorInfix();
                    doAuthorGoogleImageSearch();
                    unlink();
                    fillInOeuvre();
                }, function () {
                    setAuthorInfix(lastSetAuthorInfix);
                });
            } else {
                lastSetAuthorInfix = getAuthorInfix();
                fillAuthorInput();
                doAuthorGoogleImageSearch();
                fillInOeuvre();
            }
        }
    });

    $('.oeuvre-edit-icon').on('click', function () {
        if ($('#oeuvre-textarea-panel').is(":visible")) {
            createOeuvreList();
        } else {
            $('#oeuvre-textarea-panel').show();
        }
    });

    $('#oeuvreButton').on('click', function () {
        if ($('#oeuvre-textarea-panel').is(":visible")) {
            createOeuvreList();
        }
    });
});

function doAuthorGoogleImageSearch() {
    var searchString = getAuthorName() + ' ' + getAuthorInfix() + ' ' + getAuthorFirstName();
    executeGoogleSearch(searchString, 'authorImageContent', 'authorImageUrl');
}

function fillInAuthorNamesFromBookInfo() {
    var trimmedValue = $('#book_author_input').val();
    var result = trimmedValue.split(",", 3);
    if (result.length === 3) {
        setAuthorName(result[0].trim());
        setAuthorInfix(result[1].trim());
        setAuthorFirstName(result[2].trim());
        reinitializeLastSetValues();
        fillInOeuvre();
    }
    else if (result.length === 2) {
        setAuthorName(result[0].trim());
        setAuthorFirstName(result[1].trim());
        setAuthorInfix('');
        reinitializeLastSetValues();
        fillInOeuvre();
    }
    else if (result.length === 1) {
        setAuthorName(result[0].trim());
        setAuthorFirstName('');
        setAuthorInfix('');
        reinitializeLastSetValues();
        fillInOeuvre();
    }
}

function reinitializeLastSetValues() {
    lastSetAuthorFirstname = getAuthorFirstName();
    lastSetAuthorName = getAuthorName();
    lastSetAuthorInfix = getAuthorInfix();
}

function fillAuthorInput() {
    setAuthorNameOnBookInfo(getAuthorFullString());
}

function getAuthorFullString() {
    if (getAuthorInfix()) {
        return getAuthorName() + ", " + getAuthorInfix() + ", " + getAuthorFirstName();
    } else {
        return getAuthorName() + ", " + getAuthorFirstName();
    }
}

function isBookLinked() {
    return $('#book-from-author-id-input').val() != '';
}

function fillInOeuvre() {
    var author = $.grep(authors_json, function (e) {
        return e.name === $("#author_name").val() && e.firstname === $("#author_firstname").val();
    })[0];
    if (author != null) {
        var oeuvre;
        $.get(baseUrl + "/getOeuvreForAuthor/" + author.id,
            function (data, status) {
                if (status === "success") {
                    oeuvre = data;
                    lastKnownAuthor = author;
                    lastLoadedOeuvre = oeuvre;
                    createOeuvreList();
                }
            }).fail(function () {
            });
    } else {
        $('#oeuvre-textarea').val('');
        lastKnownAuthor = null;
        $('#author-oeuvre-list').empty();
        unlink();
    }
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

function createOeuvreList() {
    var res = $('#oeuvre-textarea').val().split("\n");
    var errorMessage = validateOeuvreList();
    if (errorMessage) {
        showError(errorMessage);
    } else {
        hideError();
        var list = "";

        if (lastKnownAuthor !== null) {
            $.each(lastLoadedOeuvre, function (index, obj) {
                list = list + "<li bookFromAuthorTitle='" + obj.title + "'>";
                if (obj.books.length == 0) {
                    list = list + obj.title;
                } else {
                    list = list + "<span class='author-oeuvre-linked-book-title'>" + obj.title + "</span>";
                }
                if ($('#book-from-author-id-input').val() && obj.title === $('#book-from-author-id-input').val()) {
                    list = list + "<span class='author-oeuvre-link-icon fa fa-chain linked'></span><span id='active-linked' class='green-linked-div'>linked</b></span>";
                } else {
                    list = list + "<span class='author-oeuvre-link-icon fa fa-chain-broken'></span>";
                }
                list = list + '</li>'
            });
        }

        $.each(res, function (index, obj) {
            var splitString = obj.split(" - ");
            var year = splitString[0];
            var title = splitString[1];
            if (title) {
                list = list + "<li bookFromAuthorTitle='" + title + "'>";
                list = list + title;
                list = list + "<span class='author-oeuvre-link-icon fa fa-chain-broken'></span>";
                list = list + '</li>'
            }
        });

        $('#author-oeuvre-list').html(list);

        $('.author-oeuvre-link-icon').on('click', function (event) {
            if (!$(this).hasClass('linked')) {
                unlink();
                link($(this));
            } else {
                unlink();
            }
        });

        $('#oeuvre-textarea-panel').hide();
    }

}

function unlink() {
    $('#active-linked').remove();
    var linkedIcon = $('.linked');
    linkedIcon.removeClass('fa-chain');
    linkedIcon.addClass('fa-chain-broken');
    linkedIcon.removeClass('linked');
    $('#book-from-author-id-input').val('');
}

function link(linkedIcon) {
    linkedIcon.parent().append("<span id='active-linked' class='green-linked-div'>linked</b></span>");
    linkedIcon.removeClass('fa-chain-broken');
    linkedIcon.addClass('fa-chain');
    linkedIcon.addClass('linked');
    $('#book-from-author-id-input').val(linkedIcon.parent().attr('bookFromAuthorTitle'));
}

function setAuthorName(authorName) {
    $("#author_name").val(authorName);
}

function setAuthorFirstName(authorFirstName) {
    $("#author_firstname").val(authorFirstName);
}

function setAuthorInfix(authorInfix) {
    $("#author_infix").val(authorInfix);
}

function getAuthorName() {
    return $("#author_name").val();
}

function getAuthorFirstName() {
    return $("#author_firstname").val();
}

function getAuthorInfix() {
    return $("#author_infix").val();
}
