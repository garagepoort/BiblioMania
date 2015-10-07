function Filter(id, type, field, supportedOperators, options){
    this.id = id;
    this.type = type;
    this.field = field;
    this.supportedOperators = supportedOperators;
    this.options = options;
    this.filterInputObject;
    this.filterHtmlElement;

    FilterRepository.addFilter(id, this);
}

Filter.prototype.createSelectFilterElement = function(){
    var container = $("<div></div>")
    var label = $("<label>" + this.field + "</label>");
    var input = $('<input type="checkbox" onchange="triggerSelectFilter(\'' + this.id + '\')"/>');
    input.attr('id', this.id);
    input.attr('filterType', this.type);
    input.attr('filterText', this.field);
    this.checkbox = input;
    container.append(label);
    container.append(input);
    return container;
};

function triggerSelectFilter(id) {
    var filter = FilterRepository.getFilter(id);
    if (filter.checkbox.is(":checked")) {
        filter.createFilterField();
    } else {
        filter.filterHtmlElement.remove();
    }
}

Filter.prototype.isFilterSelected = function(){
    return this.checkbox.is(":checked");
}

Filter.prototype.createFilterField = function() {
    var filterInput;
    if (this.type == "text") {
        filterInput = new TextFilter(this.id, this.field, this.supportedOperators);
    }
    if (this.type == "number") {
        filterInput = new NumberFilter(this.id, this.field, this.supportedOperators);
    }
    if (this.type == "boolean") {
        filterInput = new BooleanFilter(this.id, this.field);
    }

    if (this.type == "options") {
        filterInput = new OptionsFilter(this.id, this.field, this.supportedOperators, this.options);
    }

    if (this.type == "multiselect") {
        filterInput = new MultiSelectFilter(this.id, this.field, this.supportedOperators, this.options);
    }

    this.filterInputObject = filterInput;
    this.filterHtmlElement = filterInput.createFilterElement();
    if (this.id.startsWith("book-")) {
        $('#book-form-container').append(this.filterHtmlElement);
    }
    if (this.id.startsWith("personal-")) {
        $('#personal-form-container').append(this.filterHtmlElement);
    }

    return this.filterHtmlElement;
}