$(function() {

    $("#oeuvre-author-edit-all-icon").on("click", function() {

        $( ".author-oeuvre-link" ).each(function( index ) {
            if($(this).find('span.oeuvre-author-pencil').length != 0){
                $('.oeuvre-author-pencil',this).remove();
                $('.oeuvre-author-cross',this).remove();
            }else{ 
                $(this).append('<span aria-hidden="true" style="margin-left:10px" class="fa fa-pencil-square oeuvre-author-pencil oeuvre-author-edit-icon" width="10px">');
                $(this).append('<span aria-hidden="true" style="margin-left:10px" class="fa fa-times-circle oeuvre-author-cross" width="10px">');
            }
        });

        $(".oeuvre-author-cross").on("click", function() {
            var tdElement = $(this).parent().parent();
            var oeuvreId = tdElement.attr('oeuvre-id');
            var author_oeuvre = $.grep(author_json.oeuvre, function(e){ return e.id == oeuvreId; })[0];
            BootstrapDialog.show({
                title: 'Bent u zeker dat u dit wilt verwijderen?', 
                message: author_oeuvre.title + " - " + author_oeuvre.publication_year,
                buttons: [
                {
                    icon: "fa fa-check-circle",
                    label: 'Ja',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        $.post(baseUrl + "/deleteBookFromAuthor",
                        {
                          bookFromAuthorId:oeuvreId
                        },
                        function(data,status){
                            dialogItself.close();
                            if(status === "success"){
                                tdElement.remove();
                                BootstrapDialog.show({
                                    message: 'Succesvol verwijdert!'
                                });
                            }
                        }).fail(function(){
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
                    action: function(dialogItself){
                        dialogItself.close();
                    }
                }]
            });
        });

        $(".oeuvre-author-edit-icon").on("click", function() {
            var tdElement = $(this).parent().parent();
            var oeuvreId = tdElement.attr('oeuvre-id');
            var author_oeuvre = $.grep(author_json.oeuvre, function(e){ return e.id == oeuvreId; })[0];
            tdElement.append("<table class='bookFromAuthorEditTable'>"+
                "<tr>" +
                    "<td>" +
                        "<input class='titleInput' type='text' placeholder='titel' value='"+ author_oeuvre.title +"'>"+
                    "</td>" +
                    "<td>" +
                        "<input class='yearInput' type='text' placeholder='jaar van publicatie' value='"+ author_oeuvre.publication_year +"'>"+
                    "</td>" +
                    "<td>" +
                        "<button bookFromAuthorId='" + author_oeuvre.id + "' class='saveBookFromAuthorButton' style='color: black;'>Save</button>"+
                    "</td>" +
                "</tr>" +
            "</table>");
            tdElement.find('.author-oeuvre-link').hide();
            $('.bookFromAuthorEditTable').show();
            
            tdElement.find('.saveBookFromAuthorButton').on('click', function(){
                var oeuvreId = $(this).attr('bookFromAuthorId');
                $.post(baseUrl + "/editBookFromAuthor",
                        {
                          authorId:author_json.id,
                          bookFromAuthorId:oeuvreId,
                          title:tdElement.find('.titleInput').val(),
                          publication_year:tdElement.find('.yearInput').val()
                        },
                        function(data,status){
                            if(status === "success"){
                                window.author_json = data;
                                tdElement.find('.author-oeuvre-title').text(tdElement.find('.titleInput').val());
                                tdElement.find('.bookFromAuthorEditTable').remove();
                                tdElement.find('.author-oeuvre-link').show();
                                BootstrapDialog.show({
                                    message: 'Succesvol aangepast!'
                                });
                            }
                        }
                ).fail(function(){
                    dialogItself.close();
                    BootstrapDialog.show({
                        message: 'Er ging iets mis. Refresh de pagina even en probeer opnieuw!'
                    });
                });
                      
            });
        });

    });



});