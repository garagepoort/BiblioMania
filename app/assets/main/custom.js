var request;

$(function(){
    if (typeof String.prototype.startsWith != 'function') {
        // see below for better implementation!
        String.prototype.startsWith = function (str){
            return this.indexOf(str) === 0;
        };
    }
});

function getImageStyle(height, width, image, spritePointer) {
    var styleString = "width: " + width+ "px;height:" + height + "px; background: url(" + image + ");";

    styleString = styleString + "background-position:  0px -" + spritePointer + "px;margin-bottom: 0px;";
    return styleString;
}

function showError(id, errorMessage) {
    $('#' + id).show();
    $('#' + id).children()[0].innerHTML =  errorMessage;
    $('html, body').animate({
        scrollTop: $('#' + id).offset().top -100
    }, 2000);
}

function hideError(id) {
    $(id).hide();
}

function createMaterialCardImage(bookId, image, height, width, spritePointer, showExclamation, read){
    var readIcon = getIcon("/images/check-circle-fail.png", "Dit boek is niet gelezen", "reading-icon");
    var styleString = getImageStyle(height, width, image, spritePointer);
    var materialCard = $("<div></div>");
    materialCard.attr("class", "material-card imageLinkWrapper ic_container");
    materialCard.attr("style", "width: " + width+ "px;");

    var materialContent = $("<div></div>");
    materialContent.attr("class", "material-card-content");
    materialContent.attr("style", styleString);

    if(showExclamation){
        var exclamationIcon = getIcon("/images/exclamation_mark.png", "Dit boek heeft oude tags", "exclamation");
        materialContent.append(exclamationIcon);
    }
    if(read) {
        readIcon = getIcon("/images/check-circle-success.png", "Dit boek is gelezen", "reading-icon");
    }
    readIcon.addClass("clickableImage");
    readIcon.attr("href", baseUrl + "/createOrEditBook/step/6/" + bookId);
    materialContent.append(readIcon);

    materialCard.append(materialContent);

    $(".clickableImage").click(function () {
        window.document.location = $(this).attr("href");
    });

    return materialCard;
}

function getIcon(image, title, clas) {
    var icon = $("<img/>");
    icon.attr("src", baseUrl + image);
    icon.attr("class", clas);
    icon.attr("data-toggle", "tooltip");
    icon.attr("data-placement", "top");
    icon.attr("title", title);
    return icon;
}

function getBookImageObject(book) {
    var height = book.imageHeight;
    var width = book.imageWidth;
    var imageString = baseUrl + "/bookImages/" + username + "/sprite.png";
    var spritePointer = book.spritePointer;

    if(book.useSpriteImage == false){
        height = book.imageHeight;
        imageString = baseUrl + "/bookImages/" + username + "/" + book.coverImage;
        spritePointer = 0;
    }
    if (book.coverImage == '' || book.coverImage == null) {
        imageString = baseUrl + "/images/questionCover.png";
        height = 214;
        width= 142;
        spritePointer = 0;
    }

    return {imageString: imageString, spritePointer: spritePointer, height: height, width: width};
}

function getAuthorImageObject(author) {
    var height = author.imageHeight;
    var width = author.imageWidth;
    var imageString = baseUrl + "/authorImages/" + "sprite.png";
    var spritePointer = author.spritePointer;

    if(author.useSpriteImage == false){
        height = author.imageHeight;
        imageString = baseUrl + "/authorImages/" + author.image;
        spritePointer = 0;
    }
    if (author.image == '' || author.image == null) {
        imageString = baseUrl + "/images/questionCover.png";
        height = 214;
        width = 142;
        spritePointer = 0;
    }
    return {imageString: imageString, spritePointer: spritePointer, height: height, width: width};
}

function startLoadingPaged(url, page, action){
    $('#loader-icon').show();
    $('#no-results-message').hide();
    request = $.get(url + "&page=" + page,
        function(data, status){
            if(status === "success"){
                if(data.total !== 0) {
                    action(data);
                    if (data.current_page !== data.last_page) {
                        var nextPage = data.current_page + 1;
                        startLoadingPaged(url, nextPage, action);
                    } else {
                        $('#loader-icon').hide();
                    }
                }else{
                    $('#no-results-message').show();
                    $('#loader-icon').hide();
                }
            }
        }
    );
}

function scrollToElement(element) {
    $('html,body').animate({ scrollTop: $(element).offset().top -200}, 200);
}

function abortLoadingPaged(){
    request.abort();
}

function showLoadingDialog(){
    $.isLoading({
        text: "Loading",
        'class': "icon-refresh",
        'tpl': '<span class="isloading-wrapper %wrapper%">%text%<i class="%class% fa fa-refresh fa-spin"></i></span>'
    });
}

function showNotification(title, message, type){
    $.notify({
        title: '<strong>' + title + '</strong>',
        message: message
    },{
        type: type,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        }
    });
}

function hideLoadingDialog(){
    $.isLoading("hide");
}