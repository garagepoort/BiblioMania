var Navigator = require('../Navigator');

var LoginPage = {
        url: '/#/login'
};

LoginPage.login = function () {
    Navigator.navigateTo(LoginPage.url);

    var userNameElm = $('input[type=text]');
    var passwordElm = $('input[type=password]');
    var submitButton = $('input[type=submit]');

    userNameElm.sendKeys('elisa');
    passwordElm.sendKeys('xxx');
    submitButton.click();
};

module.exports = LoginPage;