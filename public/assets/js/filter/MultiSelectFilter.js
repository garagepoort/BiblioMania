function MultiSelectFilter(filterId, field, operators, options){
    this.filterId = filterId;
    this.field = field;
    this.options = options;
    this.operators = operators;
    this.inputElement;
    this.formgroupElement;

    this.createFilterElement();
}

MultiSelectFilter.prototype.createFilterElement = function(){
    var formgroup = $("<div class=\"form-group\"></div>");
    formgroup.attr("forFilter", this.filterId);

    var inputgroup = $("<div class=\"col-md-10 filter-input\"></div>");

    var input = $("<select class=\"filterInput input-sm form-control\" multiple=\"multiple\"></select>");

    for (var option in this.options) {
        var optionEl = $('<option>' + option + '</option>');
        optionEl.attr('value', this.options[option]);
        input.append(optionEl);
    }


    var operatorSelect = new OperatorSelector(this.filterId, this.operators, input);
    this.operatorSelector = operatorSelect;

    if (Object.keys(this.operators).length > 1) {
        input.addClass("operator-input")
        inputgroup.append(operatorSelect.createElement());
    }
    inputgroup.append(input);


    formgroup.append("<label class='control-label col-md-10'>" + this.field + "</label>");
    formgroup.append(inputgroup);
    input.multiselect();
    this.inputElement = input;
    this.formgroupElement = formgroup;
}

MultiSelectFilter.prototype.getValue = function(){
    return this.inputElement.val();
}

MultiSelectFilter.prototype.setValue = function(value) {
    this.inputElement.multiselect("select", value);
}

MultiSelectFilter.prototype.getSelectedOperator = function(){
    return this.operatorSelector.getSelectedOperator();
}

MultiSelectFilter.prototype.setSelectedOperator = function(value){
    this.operatorSelector.setSelectedOperator(value);
}