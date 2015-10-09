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
        getFilters();

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

    function fillFilterRepository(filters) {
        for (var f in filters) {
            var filter = filters[f];
            var filterId = filter.id;
            var filterType = filter.type;
            var filterField = filter.field;
            var filterOperators = filter.supportedOperators;
            var filterOptions = [];

            if (filter.options != undefined) {
                filterOptions = filter.options;
            }

            var filter = new Filter(filterId, filterType, filterField, filterOperators, filterOptions, function (filter, selected) {
                if (selected) {
                    if (filter.id.startsWith("book-")) {
                        $('#book-form-container').append(filter.getFilterValueInputElement());
                    }
                    if (filter.id.startsWith("personal-")) {
                        $('#personal-form-container').append(filter.getFilterValueInputElement());
                    }
                } else {
                    filter.removeFilterInputFromDom();
                }
            });

            FilterRepository.addFilter(filterId, filter);
        }
    }

    function constructFilterMessage() {
        var div = $('<div></div>');

        var bookList = $('<dl class="filters-list"></dl>');
        bookList.append($('<dt><h4>Boek</h4></dt>'))
        var personalList = $('<dl class="filters-list"></dl>');
        personalList.append($('<dt><h4>Persoonlijk</h4></dt>'))
        for (var f in FilterRepository.filters) {
            var filter = FilterRepository.getFilters()[f];
            var listItem = $('<dd></dd>');
            listItem.append(filter.getHtmlElement());

            if (filter.id.startsWith("book-")) {
                bookList.append(listItem);
            }
            if (filter.id.startsWith("personal-")) {
                personalList.append(listItem);
            }
        }
        div.append(bookList);
        div.append(personalList);
        return div;
    }
    function fillFiltersFromJson() {
        var json_filters = {{  json_encode(Session::get('book.filters')) }};
        if (json_filters !== null) {
            for (var i = 0; i < json_filters.length; i++) {
                var filter = json_filters[i];
                var filterObject = FilterRepository.getFilter(filter.id);
                filterObject.doSelect(true);
                filterObject.setValue(filter.value);
            }
        }
    }

    function getFilters() {
        request = $.get(baseUrl + "/bookFilters",
                function (data, status) {
                    if (status === "success") {
                        fillFilterRepository(data);
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

                        fillFiltersFromJson();
                    }
                }
        );
    }

</script>