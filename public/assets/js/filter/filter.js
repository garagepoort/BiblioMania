function Filter(id, type, field, supportedOperators, options, onChange){
    this.id = id;
    this.type = type;
    this.field = field;
    this.supportedOperators = supportedOperators;
    this.options = options;
    this.onChange = onChange;
    this.filterValueInput;
    this.filterValueInputElement;
    this.filterSelectorElement;

    this.createSelectFilterElement();
    this.createFilterField();
}

Filter.prototype.createSelectFilterElement = function(){
    var container = $("<div></div>")
    var label = $("<label>" + this.field + "</label>");
    var input = $('<input type="checkbox" onchange="triggerSelectFilter(\'' + this.id + '\')"/>');
    input.attr('id', this.id);
    container.append(label);
    container.append(input);

    this.label = label;
    this.checkbox = input;
    this.filterSelectorElement = container;
};

function triggerSelectFilter(id) {
    var filter = FilterRepository.getFilter(id);
    filter.doSelect(filter.checkbox.is(":checked"));
}

Filter.prototype.doSelect = function(selected){
    this.onChange(this, selected);
}

Filter.prototype.setValue = function(value){
    this.filterValueInput.setValue(value);
}

Filter.prototype.isFilterSelected = function(){
    return this.checkbox.is(":checked");
}

Filter.prototype.getHtmlElement = function(){
    return this.filterSelectorElement;
}

Filter.prototype.removeFilterInputFromDom = function(){
    this.filterValueInputElement.remove();
}

Filter.prototype.getFilterValueInputElement = function(){
    return this.filterValueInputElement;
}

Filter.prototype.getFilterValue = function(){
    return this.filterValueInput.getValue();
}

Filter.prototype.getSelectedOperator = function(){
    return this.filterValueInput.getSelectedOperator();
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

    this.filterValueInput = filterInput;
    this.filterValueInputElement = filterInput.formgroupElement;
}