function BooleanFilter(filterId, field){
    this.filterId = filterId;
    this.field = field;
    this.inputElement;
}

BooleanFilter.prototype.createFilterElement = function(){
    var formgroup = $("<div class=\"form-group\"></div>");
    formgroup.attr("forFilter", this.filterId);
    var inputgroup = $("<div class=\"col-md-10 filter-input\"></div>");

    formgroup.append("<label class='control-label col-md-10'>" + this.field + "</label>");
    formgroup.append(inputgroup);

    var input = $("<input class=\"filterInput\" type=\"checkbox\"/>");
    input.attr("filterInputId", this.filterId);
    input.attr("filterOperator", 'equals');
    inputgroup.append(input);
    this.inputElement = input;
    return formgroup;
}


BooleanFilter.prototype.getValue = function(){
    if (this.inputElement.is(":checked")) {
        return true;
    } else {
        return false;
    }
}

BooleanFilter.prototype.getSelectedOperator = function(){
    return 'equals';
}