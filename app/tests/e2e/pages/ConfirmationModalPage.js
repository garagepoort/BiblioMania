var ConfirmationModalPage = {
    modalId: 'confirmation-modal'
};

ConfirmationModalPage.assertOnModal = function () {
    expect(element(by.id(ConfirmationModalPage.modalId)).isDisplayed()).toBe(true);
    return this;
};

ConfirmationModalPage.assertNotOnModal = function () {
    expect(element(by.id(ConfirmationModalPage.modalId)).isPresent()).toBe(false);
    return this;
};

ConfirmationModalPage.clickYes = function () {
    element(by.id('confirmation-modal-yes-button')).click();
    return this;
};

ConfirmationModalPage.clickNo = function () {
    element(by.id('confirmation-modal-no-button')).click();
    return this;
};


module.exports = ConfirmationModalPage;