function OptionsFilter(filterId, field, operators, options){
    this.filterId = filterId;
    this.field = field;
    this.options = options;
    this.operators = operators;
    this.inputElement;
    this.formgroupElement;

    this.createFilterElement();
}

OptionsFilter.prototype.createFilterElement = function(){
    var formgroup = $("<div class=\"form-group\"></div>");
    formgroup.attr("forFilter", this.filterId);
    var inputgroup = $("<div class=\"col-md-10 filter-input\"></div>");

    var input = $("<select class=\"filterInput input-sm form-control\"></select>");
    for (var option in this.options) {
        var optionEl = $('<option>' + option + '</option>');
        optionEl.attr('value', this.options[option]);
        input.append(optionEl);
    }

    var operatorSelect = new OperatorSelector(this.filterId, this.operators, input);
    input.addClass("operator-input")
    this.operatorSelector = operatorSelect;
    if (Object.keys(this.operators).length > 1) {
        inputgroup.append(operatorSelect.createElement());
    }

    inputgroup.append(input);
    formgroup.append("<label class='control-label col-md-10'>" + this.field + "</label>");
    formgroup.append(inputgroup);
    this.inputElement = input;
    this.formgroupElement = formgroup;
}

OptionsFilter.prototype.getValue = function(){
    return this.inputElement.val();
}

OptionsFilter.prototype.setValue = function(value) {
    this.inputElement.val(value);
}

OptionsFilter.prototype.getSelectedOperator = function(){
    if(this.operatorSelector == undefined){
        return this.operators[Object.keys(this.operators)[0]];
    }
    return this.operatorSelector.getSelectedOperator();
}

OptionsFilter.prototype.setSelectedOperator = function(value){
    this.operatorSelector.setSelectedOperator(value);
}