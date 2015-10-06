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

{{ HTML::style('assets/css/libraryfilter/libraryfilter.css') }}
{{ HTML::style('assets/lib/multi-select/css/bootstrap-multiselect.css') }}
{{ HTML::script('assets/lib/multi-select/js/bootstrap-multiselect.js') }}
{{ HTML::script('assets/lib/multi-select/js/bootstrap-multiselect-collapsible-groups.js') }}

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
                var filterOperator = $(this).attr('filterOperator');
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
                    value: value,
                    operator: filterOperator
                });
                doFilterBooks(filters);
            });
        });

        fillFiltersFromJson();
    });

    function createFilterField(checkbox) {
        var filterSupportedOperators = JSON.parse(checkbox.attr('filterSupportedOperators'));
        var filterType = checkbox.attr("filterType");
        var placeholder = checkbox.attr("filterText");
        var filterId = checkbox.attr("id");
        var formgroup = $("<div class=\"form-group\"></div>");
        formgroup.attr("forFilter", filterId);
        var inputgroup = $("<div class=\"col-md-10 filter-input\"></div>");

        formgroup.append("<label class='control-label col-md-10'>"+placeholder+"</label>");
        formgroup.append(inputgroup);

        var input;

        if (filterType == "text") {
            input = $("<input class=\"form-control filterInput\" type=\"text\" placeholder=\"" + placeholder + "\"/>")
        }
        if (filterType == "number") {
            input = $("<input class=\"form-control filterInput\" type=\"number\" placeholder=\"" + placeholder + "\"/>")
        }
        if (filterType == "boolean") {
            input = $("<input class=\"filterInput\" type=\"checkbox\"/>")
        }

        if (filterType == "options") {
            var filterOptions = JSON.parse(checkbox.attr('filterOptions'));

            input = $("<select class=\"filterInput input-sm form-control\"></select>");

            for(var option in filterOptions){
                var optionEl = $('<option>' + option + '</option>');
                optionEl.attr('value', filterOptions[option]);
                input.append(optionEl);
            }
        }

        if(filterType == "multiselect"){
            var filterOptions = JSON.parse(checkbox.attr('filterOptions'));

            input = $("<select class=\"filterInput input-sm form-control\" multiple=\"multiple\"></select>");

            for(var option in filterOptions){
                var optionEl = $('<option>' + option + '</option>');
                optionEl.attr('value', filterOptions[option]);
                input.append(optionEl);
            }
        }

        input.attr("filterOperator", filterSupportedOperators[Object.keys(filterSupportedOperators)[0]]);
        input.attr("filterInputId", filterId);

        if(Object.keys(filterSupportedOperators).length > 1){
            var operatorSelect = $('<select class="input-sm form-control operator-select"></select>');
            operatorSelect.attr('onchange', "changeOperator(this,'" + filterId +"')");
            for(var option in filterSupportedOperators) {
                var optionEl = $('<option>' + option + '</option>');
                optionEl.attr('value', filterSupportedOperators[option]);
                operatorSelect.append(optionEl);
            }
            input.addClass("operator-input")
            inputgroup.append(operatorSelect);
        }

        inputgroup.append(input);

        if(filterId.startsWith("book-")){
            $('#book-form-container').append(formgroup);
        }
        if(filterId.startsWith("personal-")){
            $('#personal-form-container').append(formgroup);
        }

        $('select[multiple="multiple"]').multiselect();
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
            input.attr('filterSupportedOperators', '{{ json_encode($filter->getSupportedOperators()) }}');
            @if($filter->getType() == 'options' || $filter->getType() == 'multiselect')
                input.attr('filterOptions', '{{ json_encode($filter->getOptions()) }}');
            @endif
            listItem.append(input);
            listItem.append(label);

            if(filterId.startsWith("book-")){
                bookList.append(listItem);
            }
            if(filterId.startsWith("personal-")){
                personalList.append(listItem);
            }
        @endforeach

        div.append(bookList);
        div.append(personalList);
        return div;
    }

    function filterChange(checkbox) {
        var checkbox = $(checkbox);

        if (checkbox.is(":checked")) {
            createFilterField(checkbox);
        } else {
            $("div[forFilter='" + checkbox.attr("id") + "']").remove();
        }
    }

    function changeOperator(selectField, filterId){
        $("[filterInputId='" + filterId+"']").attr("filterOperator", $(selectField).val());
    }

    function fillFiltersFromJson(){
        var json_filters = {{  json_encode(Session::get('book.filters')) }};
        for(var i = 0; i < json_filters.length; i++){
            var filter = json_filters[i];
            var filterCheckbox = message.find("#" + filter.id);
            var filterType = filterCheckbox.attr("filterType");
            filterCheckbox.prop('checked', true);
            filterCheckbox.change();
            if(filterType == "multiselect") {
                $('[filterInputId="' + filter.id + '"]').multiselect("select", filter.value);
            }else if(filterType == "boolean"){
                $('[filterInputId="' + filter.id + '"]').prop("checked", filter.value);
            }else{
                $('[filterInputId="' + filter.id + '"]').val(filter.value);
            }
        }
    }

</script>