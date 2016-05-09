var screenshot = require('../../utils/Screenshot.js');

//@Deprecated
exports.selectOptionByValue = function (elementId, desiredValue) {
    findCombobox(by.id(elementId)).selectOptionByValue(desiredValue);
};

//@Deprecated
//Be sure to use the correct index.
//When no value was selected, the empty value is at index 0.
//When a value was selected before, the empty value is only present when explicitly added.
exports.selectOptionByIndex = function (elementId, desiredIndex) {
    findCombobox(by.id(elementId)).selectOptionByIndex(desiredIndex);
};

//@Deprecated
exports.selectOptionByValueAttribute = function (elementId, optionValue) {
    findCombobox(by.id(elementId)).selectOptionByValueAttribute(optionValue);
};

//@Deprecated
exports.getSelectedOptionValue = function (elementId) {
    return findCombobox(by.id(elementId)).getSelectedOptionValue();
};

function takeScreenshotWhenOptionIsUndefined(option) {
    if (option === undefined) {
        screenshot.writeScreenshot('option--in-combobox-is-undefined.png');
    }
}

function findCombobox(locator, parentElement) {
    var combobox = {};
    var el = getElement();

    combobox.selectOptionByValue = function (desiredValue) {
        el.element(by.xpath(".//option[child::text() = '"+desiredValue+"']")).click();
    };

//Be sure to use the correct index.
//When no value was selected, the empty value is at index 0.
//When a value was selected before, the empty value is only present when explicitly added.
    combobox.selectOptionByIndex = function (desiredIndex) {
        el.all(by.tagName('option')).then(function (options) {
            takeScreenshotWhenOptionIsUndefined(options[desiredIndex]);
            options[desiredIndex].click();
        });
    };

    combobox.selectOptionByValueAttribute = function (optionValue) {
        if (optionValue !== undefined) {
            el.all(by.css('option[value="' + optionValue + '"]')).then(function (options) {
                if (options[0]) {
                    options[0].click();
                }
            });
        }
    };

    combobox.getSelectedOptionValue = function () {
        return el.$('option:checked').getText();
    };

    function getElement() {
        if (parentElement === undefined) {
            return element(locator);
        }

        return parentElement.element(locator);
    }

    return combobox;
}

exports.find = findCombobox;
