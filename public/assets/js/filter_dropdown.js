$(document).ready(function(e){
    $('.search-panel-operator .dropdown-menu').find('a').click(function(e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#","");
        var concept = $(this).text();
        $('.search-panel-operator span#search_concept').text(concept);
        $('#search_param_operator').val(param);
    });
});

$(document).ready(function(e){
    $('.search-panel-type .dropdown-menu').find('a').click(function(e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#","");
        var concept = $(this).text();
        $('.search-panel-type span#search_concept').text(concept);
        $('#search_param_type').val(param);
    });
});