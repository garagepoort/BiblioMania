<div id="libraryFilterSlidingPanel" class="sliding-panel libraryFilterSlidingPanel">
    <div id="libraryFilterSlidingPanelTitle" class="slidingPanelTitle material-card-title">Filter</div>
    <div class="material-card-content">
        <table id="book-filters-table" class="book-filters-table">
            <tr>
                <td>
                    <button class="btn btn-success" id="filterButton">Filter</button>
                    <button class="btn btn-warning" id="deselect">Reset</button>
                    <button class="btn btn-default" id="selectFiltersButton">Selecteer filters</button>
                </td>
            </tr>
        </table>
    </div>
    <div id="libraryFilterBookMark" class="bookMark libraryFilterBookmark">
        {{ HTML::image('images/filter_icon.png', 'filter',array('class'=>'info-icon')) }}
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var slidingPanel = new BorderSlidingPanel($('#libraryFilterSlidingPanel'), "left", 10);
        $('#libraryFilterSlidingPanel').on('mouseover', function () {
            slidingPanel.open(function () {
            });
        });
        $('#libraryFilterSlidingPanel').on('mouseout', function () {
            slidingPanel.close(function () {
            });
        });

        $('#selectFiltersButton').on('click', function(){
            showSelectFiltersDialog();;
        });

        $('#filterButton').on('click', function () {
            var filters = [];
            $('.filterInput').each(function () {

                var filterId = $(this).attr('filterInputId');
                var value = $(this).val();
                if ($(this).attr('type') == "checkbox") {
                    if ($(this).is(":checked")) {
                        value = true;
                    } else {
                        value = false;
                    }
                }
                filters.push({
                    id: filterId,
                    value: value
                });
                doFilterBooks(filters);
            });
        });
    });

    function filterChange(checkbox) {
        var checkbox = $(checkbox);

        if (checkbox.is(":checked")) {
            createFilterField(checkbox);
        } else {
            $("tr[forFilter='" + checkbox.attr("id") + "']").remove();
        }
    }

    function createFilterField(checkbox) {
        var filterType = checkbox.attr("filterType");
        var placeholder = checkbox.attr("filterText");
        var table = $('#book-filters-table');
        var tr = $('<tr></tr>');
        var td = $('<td></td>');
        tr.append(td);
        tr.attr("forFilter", checkbox.attr("id"));
        td.append("<label>"+placeholder+"</label>");
        if (filterType == "text") {
            var input = $("<input class=\"form-control filterInput\" type=\"text\" placeholder=\"" + placeholder + "\"/>")
            input.attr("filterInputId", checkbox.attr("id"));
            td.append(input);
        }
        if (filterType == "boolean") {
            var input = $("<input class=\"filterInput\" type=\"checkbox\"/>")
            input.attr("filterInputId", checkbox.attr("id"));
            td.append(input);
        }
        table.append(tr);
    }

    function doFilterBooks(filters) {
        var url = window.baseUrl + "/filterBooks?";
        var params = {
            filter: filters
        };
        url = url + jQuery.param(params);

        $('#books-container-table > tbody').empty();
        abortLoadingPaged();
        startLoadingPaged(url, 1, fillInBookContainer);
    }

    function showSelectFiltersDialog(){
        BootstrapDialog.show({
            title: "Selecteer filters",
            closable: true,
            message: constructFilterMessage(),
            buttons: [
                {
                    icon: "fa fa-times-circle",
                    label: 'Sluiten',
                    cssClass: 'btn-default',
                    action: function(dialogItself){
                        dialogItself.close();
                    }
                }]
        });
    }

    function constructFilterMessage(){
        var div = $('<div></div>');

        var bookList = $('<dl class="filters-list"></dl>');
        bookList.append($('<dt>Boek</dt>'))
        var personalList = $('<dl class="filters-list"></dl>');
        personalList.append($('<dt>Persoonlijk</dt>'))

        @foreach($filters as $filter)
            var filterId = "{{$filter->getFilterId() }}";
            var listItem = $('<dd></dd>');
            var label = $("<label>{{ $filter->getField() }}</label>");
            var input = $('<input type="checkbox" onchange="filterChange(this)"/>');
            input.attr('id', filterId);
            input.attr('filterType', "{{$filter->getType() }}");
            input.attr('filterText', "{{$filter->getField() }}");
            listItem.append(input);
            listItem.append(label);

            if(filterId.startsWith("book.")){
                bookList.append(listItem);
            }
            if(filterId.startsWith("personal.")){
                personalList.append(listItem);
            }
        @endforeach

        div.append(bookList);
        div.append(personalList);
        return div;
    }
</script>