var Navigator = require('../Navigator');
var RestUtil = require('../RestUtil');

var LoginPage = {
    url: '/#/login'
};

LoginPage.login = function () {
    Navigator.navigateTo(LoginPage.url);

    browser.driver.manage().window().maximize();

    var userNameElm = $('input[type=text]');
    var passwordElm = $('input[type=password]');
    var submitButton = $('input[type=submit]');

    userNameElm.sendKeys('elisa');
    passwordElm.sendKeys('xxx');
    submitButton.click();
};

LoginPage.logout = function () {
    element(by.id('logout-button')).click();
    Navigator.assertOnPage(LoginPage.url);
};

module.exports = LoginPage;