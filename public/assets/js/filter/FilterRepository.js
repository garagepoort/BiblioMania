function FilterRepository() {
}
FilterRepository.filters = [];

FilterRepository.getFilter = function (id) {
    return FilterRepository.filters[id];
};

FilterRepository.addFilter = function (id, filter) {
    FilterRepository.filters[id] = filter;
};

FilterRepository.getFilters = function () {
    return FilterRepository.filters;
};

FilterRepository.createJson = function () {
    var filters = [];
    for (var filter in  FilterRepository.filters) {
        var filterObject = FilterRepository.filters[filter];

        if(filterObject.isFilterSelected()){
            filters.push({
                id: filterObject.id,
                value: filterObject.filterInputObject.getValue(),
                operator: filterObject.filterInputObject.getSelectedOperator()
            });
        }
    }
    return filters;
}