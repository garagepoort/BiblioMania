var AuthorCreationModalPage = {
    modalId: 'author-creation-modal'
};

AuthorCreationModalPage.assertOnModal = function () {
    expect(element(by.id(AuthorCreationModalPage.modalId)).isDisplayed()).toBe(true);
    return this;
};

AuthorCreationModalPage.assertNotOnModal = function () {
    expect(element(by.id(AuthorCreationModalPage.modalId)).isPresent()).toBe(false);
    return this;
};

AuthorCreationModalPage.clickCreateAuthorButton = function () {
    element(by.id('create-author-directive')).element(by.id('create-author-save-button')).click();
    return this;
};

AuthorCreationModalPage.setFirstname = function (firstname) {
    getNameDir().element(by.model('nameModel.firstname')).clear().sendKeys(firstname);
    return this;
};

AuthorCreationModalPage.setInfix = function (infix) {
    getNameDir().element(by.model('nameModel.infix')).clear().sendKeys(infix);
    return this;
};

AuthorCreationModalPage.setLastname = function (lastname) {
    getNameDir().element(by.model('nameModel.lastname')).clear().sendKeys(lastname);
    return this;
};

function getNameDir(){
    var authorDir = element(by.id('create-author-directive'));
    return authorDir.element(by.model('vm.model.name'));
}


module.exports = AuthorCreationModalPage;