function OperatorSelector(filterId, operators, inputElement) {
    this.filterId = filterId;
    this.operators = operators;
    this.inputElement = inputElement;
}

OperatorSelector.prototype.createElement = function(){
    var operatorSelect = $('<select class="input-sm form-control operator-select"></select>');
    for (var option in this.operators) {
        var optionEl = $('<option>' + option + '</option>');
        optionEl.attr('value', this.operators[option]);
        operatorSelect.append(optionEl);
    }
    this.inputElement = operatorSelect;
    return operatorSelect;
}

OperatorSelector.prototype.getSelectedOperator = function() {
    return this.inputElement.val();
}