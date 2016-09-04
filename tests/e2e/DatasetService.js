var restUtil = require('./RestUtil');

exports.reset = function() {
    return restUtil.doRequest(browser.baseUrl + "/dataset/reset", "GET");
};

exports.initialise = function(dataSetId) {
    return restUtil.doRequest(browser.baseUrl + "/dataset/" + dataSetId, "GET");
};