function OperatorSelector(filterId, operators, inputElement) {
    this.filterId = filterId;
    this.operators = operators;
    this.inputElement = inputElement;
    this.operatorSelect;
}

OperatorSelector.prototype.createElement = function(){
    var operatorSelect = $('<select class="input-sm form-control operator-select"></select>');
    operatorSelect.attr('onchange', "changeOperator()");
    for (var option in this.operators) {
        var optionEl = $('<option>' + option + '</option>');
        optionEl.attr('value', this.operators[option]);
        operatorSelect.append(optionEl);
    }
    this.operatorSelect = operatorSelect;
    return operatorSelect;
}

OperatorSelector.prototype.changeOperator = function() {
    this.inputElement.attr("filterOperator", this.operatorSelect.val());
}


OperatorSelector.prototype.getSelectedOperator = function() {
    return this.operatorSelect.val();
}