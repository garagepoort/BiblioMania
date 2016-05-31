exports.navigateTo = function(url) {
    console.log("Navigating to " + url);
    waitForAngularWhenComingFromAnotherPage();
    browser.get(browser.baseUrl + url);
    browser.waitForAngular();
};

exports.assertOnPage = function(url) {
    console.log("Assert on url '" + url + "'");
    browser.waitForAngular();
    expect(browser.getCurrentUrl()).toEqual(browser.baseUrl + url);

    browser.manage().logs().get('browser').then(function(browserLogs) {
        // browserLogs is an array of objects with level and message fields
        browserLogs.forEach(function(log){
            if (log.level.value > 900) { // it's an error log
                console.log('Browser console error!');
                console.log(log.message);
            }
        });
    });
};

function waitForAngularWhenComingFromAnotherPage(){
    browser.driver.getCurrentUrl().then(function(url){

        console.log('current url: ' + url);
        if(isComingFromAnotherPage(url)){
            browser.waitForAngular();
        }
    });
}

function isComingFromAnotherPage(url){
    var emptyUrl = "data:,";
    return url !== emptyUrl;
}
