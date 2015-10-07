<div id="libraryFilterSlidingPanel" class="sliding-panel libraryFilterSlidingPanel">
    <div id="libraryFilterBookMark" class="bookMark libraryFilterBookmark">
{{--        {{ HTML::image('images/filter_icon.png', 'filter',array('class'=>'info-icon')) }}--}}
        <div class="info-icon"></div>
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

{{ HTML::script('assets/js/filter/Filter.js') }}
{{ HTML::script('assets/js/filter/FilterRepository.js') }}
{{ HTML::script('assets/js/filter/MultiSelectFilter.js') }}
{{ HTML::script('assets/js/filter/OptionsFilters.js') }}
{{ HTML::script('assets/js/filter/BooleanFilter.js') }}
{{ HTML::script('assets/js/filter/TextFilter.js') }}
{{ HTML::script('assets/js/filter/NumberFilter.js') }}
{{ HTML::script('assets/js/filter/OperatorSelector.js') }}

<script type="text/javascript">
    var message;
    var filterPanelOpen = false;
    var filters = [];

    $(function () {

        message = constructFilterMessage();
        var slidingPanel = new BorderSlidingPanel($('#libraryFilterSlidingPanel'), "left", 10);

        $('#libraryFilterBookMark').on('click', function () {
            if (filterPanelOpen) {
                slidingPanel.close(function () {
                    filterPanelOpen = false;
                });
            } else {
                slidingPanel.open(function () {
                    filterPanelOpen = true;
                });
            }
        });

        $('#selectFiltersButton').on('click', function () {
            showSelectFiltersDialog();
        });
        $('#deselect').on('click', function () {
            doFilterBooks("");
        });

        $('#filterButton').on('click', function () {
            var filters = FilterRepository.createJson();
            doFilterBooks(filters);
        });

//        fillFiltersFromJson();
    });

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

    function showSelectFiltersDialog() {
        BootstrapDialog.show({
            title: "Selecteer filters",
            closable: true,
            message: message,
            buttons: [
                {
                    icon: "fa fa-times-circle",
                    label: 'Sluiten',
                    cssClass: 'btn-default',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    }

    function constructFilterMessage() {
        var div = $('<div></div>');

        var bookList = $('<dl class="filters-list"></dl>');
        bookList.append($('<dt><h4>Boek</h4></dt>'))
        var personalList = $('<dl class="filters-list"></dl>');
        personalList.append($('<dt><h4>Persoonlijk</h4></dt>'))

        @foreach($filters as $filter)
                    var filterId = "{{$filter->getFilterId() }}";
                    var filterType = "{{$filter->getType() }}";
                    var filterField = "{{$filter->getField() }}";
                    var filterOperators = {{ json_encode($filter->getSupportedOperators()) }};
                    var filterOptions = [];
                    var listItem = $('<dd></dd>');

                    @if($filter->getType() == 'options' || $filter->getType() == 'multiselect')
                        filterOptions = {{ json_encode($filter->getOptions()) }};
                    @endif
                    var filter = new Filter(filterId, filterType, filterField, filterOperators, filterOptions);
                    filters[filterId] = filter;
                    listItem.append(filter.createSelectFilterElement());

                    if (filterId.startsWith("book-")) {
                        bookList.append(listItem);
                    }
                    if (filterId.startsWith("personal-")) {
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
            filterField(checkbox);
        } else {
            $("div[forFilter='" + checkbox.attr("id") + "']").remove();
        }
    }

    function changeOperator(selectField, filterId) {
        $("[filterInputId='" + filterId + "']").attr("filterOperator", $(selectField).val());
    }

    function fillFiltersFromJson() {
        var json_filters = {{  json_encode(Session::get('book.filters')) }};
        for (var i = 0; i < json_filters.length; i++) {
            var filter = json_filters[i];
            var filterCheckbox = message.find("#" + filter.id);
            var filterType = filterCheckbox.attr("filterType");
            filterCheckbox.prop('checked', true);
            filterCheckbox.change();
            if (filterType == "multiselect") {
                $('[filterInputId="' + filter.id + '"]').multiselect("select", filter.value);
            } else if (filterType == "boolean") {
                $('[filterInputId="' + filter.id + '"]').prop("checked", filter.value);
            } else {
                $('[filterInputId="' + filter.id + '"]').val(filter.value);
            }
        }
    }

    function constructFilters() {
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
        });
        return filters;
    }

</script>