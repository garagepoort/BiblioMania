function NumberFilter(filterId, placeholder, operators){
    this.filterId = filterId;
    this.placeholder = placeholder;
    this.operators = operators;
    this.inputElement;
    this.operatorSelector;
}

NumberFilter.prototype.createFilterElement = function(){
    var formgroup = $("<div class=\"form-group\"></div>");
    formgroup.attr("forFilter", this.filterId);
    var inputgroup = $("<div class=\"col-md-10 filter-input\"></div>");

    formgroup.append("<label class='control-label col-md-10'>" + this.placeholder + "</label>");
    formgroup.append(inputgroup);

    var input = $("<input class=\"form-control filterInput\" type=\"text\" placeholder=\"" + this.placeholder + "\"/>");
    input.attr("filterOperator", this.operators[Object.keys(this.operators)[0]]);
    input.attr("filterInputId", this.filterId);

    if (Object.keys(this.operators).length > 1) {
        var operatorSelect = new OperatorSelector(this.filterId, this.operators, input);
        input.addClass("operator-input");
        inputgroup.append(operatorSelect.createElement());
        this.operatorSelector = operatorSelect;
    }
    inputgroup.append(input);
    this.inputElement = input;
    return formgroup;
}

NumberFilter.prototype.getValue = function(){
    return this.inputElement.val();
}

NumberFilter.prototype.getSelectedOperator = function(){
    if(this.operatorSelector == undefined){
        return this.operators[Object.keys(this.operators)[0]];
    }
    return this.operatorSelector.getSelectedOperator();
}
