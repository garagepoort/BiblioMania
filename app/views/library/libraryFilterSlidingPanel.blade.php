<div id="libraryFilterSlidingPanel" class="sliding-panel libraryFilterSlidingPanel">
    <div id="libraryFilterBookMark" class="bookMark libraryFilterBookmark">
        {{ HTML::image('images/filter_icon.png', 'filter',array('class'=>'info-icon')) }}
    </div>
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
        <div id="book-form-container" class="filter-form-container"></div>
        <div id="personal-form-container" class="filter-form-container"></div>
    </div>
</div>

<script type="text/javascript">
    var message;
    var filterPanelOpen = false;
    $(function () {

        message = constructFilterMessage();
        var slidingPanel = new BorderSlidingPanel($('#libraryFilterSlidingPanel'), "left", 10);

        $('#libraryFilterBookMark').on('click', function () {
            if(filterPanelOpen){
                slidingPanel.close(function () {
                    filterPanelOpen = false;
                });
            }else{
                slidingPanel.open(function () {
                    filterPanelOpen = true;
                });
            }
        });

        $('#selectFiltersButton').on('click', function(){
            showSelectFiltersDialog();;
        });
        $('#deselect').on('click', function(){
            doFilterBooks("");
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
            $("div[forFilter='" + checkbox.attr("id") + "']").remove();
        }
    }

    function createFilterField(checkbox) {
        var filterType = checkbox.attr("filterType");
        var placeholder = checkbox.attr("filterText");
        var filterId = checkbox.attr("id");
        var formgroup = $("<div class=\"form-group\"></div>");
        formgroup.attr("forFilter", filterId);
        var inputgroup = $("<div class=\"col-md-10 filter-input\"></div>");

        formgroup.append("<label class='control-label col-md-10'>"+placeholder+"</label>");
        formgroup.append(inputgroup);

        if (filterType == "text") {
            var input = $("<input class=\"form-control filterInput\" type=\"text\" placeholder=\"" + placeholder + "\"/>")
            input.attr("filterInputId", filterId);
            inputgroup.append(input);
        }
        if (filterType == "boolean") {
            var input = $("<input class=\"filterInput\" type=\"checkbox\"/>")
            input.attr("filterInputId", filterId);
            inputgroup.append(input);
        }
        if (filterType == "options") {
            var filterOptions = JSON.parse(checkbox.attr('filterOptions'));
            var select = $("<select class=\"filterInput input-sm form-control\"></select>");
            select.attr("filterInputId", filterId);
            for(var option in filterOptions){
                var optionEl = $('<option>' + option + '</option>');
                optionEl.attr('value', filterOptions[option]);
                select.append(optionEl);
            }
            inputgroup.append(select);
        }
        if(filterId.startsWith("book.")){
            $('#book-form-container').append(formgroup);
        }
        if(filterId.startsWith("personal.")){
            $('#personal-form-container').append(formgroup);
        }
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
            message: message,
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
        bookList.append($('<dt><h4>Boek</h4></dt>'))
        var personalList = $('<dl class="filters-list"></dl>');
        personalList.append($('<dt><h4>Persoonlijk</h4></dt>'))

        @foreach($filters as $filter)
            var filterId = "{{$filter->getFilterId() }}";
            var listItem = $('<dd></dd>');
            var label = $("<label>{{ $filter->getField() }}</label>");
            var input = $('<input type="checkbox" onchange="filterChange(this)"/>');
            input.attr('id', filterId);
            input.attr('filterType', "{{$filter->getType() }}");
            input.attr('filterText', "{{$filter->getField() }}");
            @if($filter->getType() == 'options')
            input.attr('filterOptions', '{{ json_encode($filter->getOptions()) }}');
            @endif
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