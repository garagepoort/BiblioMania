function BookCard(id, bookImageObject, warnings, read){
    this.id=id;
    this.bookImageObject=bookImageObject;
    this.warnings=warnings;
    this.read=read;
}

BookCard.prototype.create = function(){
    var styleString = getImageStyle(this.bookImageObject.height, this.bookImageObject.width, this.bookImageObject.imageString, this.bookImageObject.spritePointer);

    var materialCard = $("<div></div>");
    materialCard.attr("class", "material-card imageLinkWrapper ic_container");
    materialCard.attr("style", "width: " + this.bookImageObject.width+ "px;");

    var materialContent = $("<div></div>");
    materialContent.attr("class", "material-card-content");
    materialContent.attr("style", styleString);

    addReadIcon.call(this, materialContent);

    var top = 30;
    for(var w in this.warnings){
        var warning = this.warnings[w];
        var exclamationIcon = getIcon(warning.icon, warning.message, "warning-icon");
        exclamationIcon.attr("style", "top: " + top +"px");
        materialContent.append(exclamationIcon);
        top = top + 25;

        if(warning.goToLink && warning.goToLink !== ""){
            exclamationIcon.addClass("clickableImage");
            exclamationIcon.attr("href", baseUrl + warning.goToLink + this.id);
        }
    }
    materialCard.append(materialContent);

    $(".clickableImage").click(function () {
        window.document.location = $(this).attr("href");
    });

    materialCard.attr("bookid", this.id);
    return materialCard;
}

function addReadIcon(materialContent) {
    var readIcon = getIcon("/images/check-circle-fail.png", "Dit boek is niet gelezen", "warning-icon");
    if (this.read) {
        readIcon = getIcon("/images/check-circle-success.png", "Dit boek is gelezen", "warning-icon");
    }
    readIcon.addClass("clickableImage");
    readIcon.attr("href", baseUrl + "/createOrEditBook/step/6/" + this.id);
    materialContent.append(readIcon);
}
