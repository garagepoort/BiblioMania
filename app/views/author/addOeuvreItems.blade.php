<div id='add-oeuvre-textarea-panel' hidden="true" style="margin-bottom: 20px;">
    <textarea placeholder="<jaar> - <titel>" id='oeuvre-textarea' name="oeuvre" cols="80"rows="5" style="width: 100%"></textarea>
    <button class='btn btn-default' id='oeuvreButton' onclick="addOeuvreItems(); return false;">Voeg items toe</button>
</div>

<script type="text/javascript">
    $(function () {
        hideAddOevreItems();
    });

    function showAddOevreItems(){
        $('#add-oeuvre-textarea-panel').show();
    }
    function hideAddOevreItems(){
        $('#add-oeuvre-textarea-panel').hide();
    }

    function toggleAddOevreItems(){
        $('#add-oeuvre-textarea-panel').toggle();
    }

    function addOeuvreItems() {
        var errorMessage = validateOeuvreList();
        if (errorMessage) {
            showError(errorMessage);
        } else {
            hideError();
            saveOeuvre();
        }
    }

    function saveOeuvre() {
        $.post(baseUrl + "/saveBookFromAuthors",
                {
                    author_id: '{{ $author_id }}',
                    oeuvre: $('#add-oeuvre-textarea').val()
                },
                function (data, status) {
                    if (status === "success") {
                        location.reload();
                    }
                }).fail(function (data) {
                    BootstrapDialog.show({
                        message: data.responseJSON.message
                    });
                });
    }


    function validateOeuvreList() {
        var res = $('#add-oeuvre-textarea').val().split("\n");
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
</script>