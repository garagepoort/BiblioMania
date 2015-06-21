var request;

function getImageStyle(height, image, spritePointer) {
    var styleString = "width: 142px;height:" + height + "px; background: url(" + image + ");";

    styleString = styleString + "background-position:  0px -" + spritePointer + "px;margin-bottom: 0px;";
    return styleString;
}
function createMaterialCardImage(image, height, spritePointer){
    var styleString = getImageStyle(height, image, spritePointer);
    var materialCard = $("<div></div>");
    materialCard.attr("class", "material-card imageLinkWrapper ic_container");
    materialCard.attr("style", "width: 142px;");

    var materialContent = $("<div></div>");
    materialContent.attr("class", "material-card-content");
    materialContent.attr("style", styleString);

    materialCard.append(materialContent);
    return materialCard;
}

function getBookImageObject(book) {
    var height = book.imageHeight;
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
        spritePointer = 0;
    }

    return {imageString: imageString, spritePointer: spritePointer, height: height};
}

function getAuthorImageObject(author) {
    var height = author.imageHeight;
    var imageString = baseUrl + "/bookImages/" + username + "/sprite.png";
    var spritePointer = author.spritePointer;

    if(author.useSpriteImage == false){
        height = author.imageHeight;
        imageString = baseUrl + "/bookImages/" + username + "/" + author.image;
        spritePointer = 0;
    }
    if (author.image == '' || author.image == null) {
        imageString = baseUrl + "/images/questionCover.png";
        height = 214;
        spritePointer = 0;
    }
    return {imageString: imageString, spritePointer: spritePointer, height: height};
}

function showConfirmDialog(title, message, action){
    BootstrapDialog.show({
        title: title,
        message: message,
        buttons: [
            {
                icon: "fa fa-check-circle",
                label: 'Ja',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    action();
                    dialogItself.close();
                }
            },
            {
                icon: "fa fa-times-circle",
                label: 'Annuleer',
                cssClass: 'btn-warning',
                action: function(dialogItself){
                    dialogItself.close();
                }
            }]
    });
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

function hideLoadingDialog(){
    $.isLoading("hide");
}