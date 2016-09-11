var FirstPrintInfoSelectionModalPage = {
    modalId: 'first-print-info-selection-modal'
};

FirstPrintInfoSelectionModalPage.assertOnModal = function () {
    expect(element(by.id(FirstPrintInfoSelectionModalPage.modalId)).isDisplayed()).toBe(true);
    return this;
};

FirstPrintInfoSelectionModalPage.assertNotOnModal = function () {
    expect(element(by.id(FirstPrintInfoSelectionModalPage.modalId)).isPresent()).toBe(false);
    return this;
};

FirstPrintInfoSelectionModalPage.selectFirstPrintInfo = function (firstPrintInfoId) {
    element(by.id('first-print-info-select-' + firstPrintInfoId)).click();
    return this;
};

module.exports = FirstPrintInfoSelectionModalPage;