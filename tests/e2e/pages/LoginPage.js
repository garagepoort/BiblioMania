var Navigator = require('../Navigator');
var RestUtil = require('../RestUtil');

var LoginPage = {
    url: '/#/login'
};

LoginPage.login = function () {
    LoginPage.loginWithUser('testUser', 'test');
};

LoginPage.loginWithUser = function(username, password){
    Navigator.navigateTo(LoginPage.url);

    browser.driver.manage().window().maximize();

    var userNameElm = $('input[type=text]');
    var passwordElm = $('input[type=password]');
    var submitButton = $('input[type=submit]');

    userNameElm.sendKeys(username);
    passwordElm.sendKeys(password);
    submitButton.click();
};

LoginPage.logout = function () {
    element(by.id('logout-button')).click();
    Navigator.assertOnPage(LoginPage.url);
};

module.exports = LoginPage;