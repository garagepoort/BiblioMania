
var lastKnownAuthor;
var lastSetAuthorName;
var lastSetAuthorFirstname;
var lastSetAuthorInfix;
var lastLoadedOeuvre;

$(function () {

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
        fillAuthorInput();
        if (lastSetAuthorName !== getAuthorName) {
            lastSetAuthorName = getAuthorName();
            doAuthorGoogleImageSearch();
            fillInOeuvre();
        }
    });

    $('#author_firstname').focusout(function () {
        fillAuthorInput();
        if (lastSetAuthorFirstname !== getAuthorFirstName) {
            lastSetAuthorFirstname = getAuthorFirstName();
            doAuthorGoogleImageSearch();
            fillInOeuvre();
        }
    });

    $('#author_infix').focusout(function () {
        fillAuthorInput();
        if (lastSetAuthorInfix !== getAuthorInfix) {
            lastSetAuthorInfix = getAuthorInfix();
            doAuthorGoogleImageSearch();
            fillInOeuvre();
        }
    });


    $('.oeuvre-edit-icon').on('click', function () {
        if ($('#oeuvre-textarea-panel').is(":visible")) {
            createOeuvreList();
            $('#oeuvre-textarea-panel').hide();
        } else {
            $('#oeuvre-textarea-panel').show();
        }
    });

    $('#oeuvreButton').on('click', function () {
        if ($('#oeuvre-textarea-panel').is(":visible")) {
            createOeuvreList();
            $('#oeuvre-textarea-panel').hide();
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
        setAuthorFirstName(result[1].trim());
        setAuthorInfix(result[2].trim());
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

function reinitializeLastSetValues(){
    lastSetAuthorFirstname = getAuthorFirstName();
    lastSetAuthorName = getAuthorName();
    lastSetAuthorInfix = getAuthorInfix();
}

function fillAuthorInput() {
    if (getAuthorInfix()) {
        setAuthorNameOnBookInfo(getAuthorName() + ", " + getAuthorInfix() + ", " + getAuthorFirstName());
    } else {
        setAuthorNameOnBookInfo(getAuthorName() + ", " + getAuthorFirstName());
    }
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

function createOeuvreList() {
    var res = $('#oeuvre-textarea').val().split("\n");
    var list = ""

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

function setAuthorName(authorName){
    $("#author_name").val(authorName);
}

function setAuthorFirstName(authorFirstName){
    $("#author_firstname").val(authorFirstName);
}

function setAuthorInfix(authorInfix){
    $("#author_infix").val(authorInfix);
}

function getAuthorName(){
    $("#author_name").val();
}

function getAuthorFirstName(){
    $("#author_firstname").val();
}

function getAuthorInfix(){
    $("#author_infix").val();
}
