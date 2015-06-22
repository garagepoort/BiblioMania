function MergePanel(panelId, mergeAction, cancelAction) {
    this.panelId = panelId;
    this.firstItem = null;
    this.secondItem = null;
    this.mergeAction = mergeAction;
    this.cancelAction = cancelAction;
    this.mergeButton = $('#' + this.panelId + ' .mergeButton');
    this.mergeSelect = $('#' + this.panelId + ' .selectMerge');
    this.mergeList = $('#' + this.panelId + ' .merge-list');
    this.mergeContainer = $('#' + this.panelId + '.list-merge-container');
}

MergePanel.prototype.showMergeDialog = function () {
    var that = this;
    var message = '1: ' + this.firstItem.name + '\n';
    message = message + '2: ' + this.secondItem.name;

    showConfirmDialog('Ben je zeker dat je dit wilt samenvoegen?', message,
        function () {
            that.mergeAction();
        },
        function () {
            that.emptyItems();
            that.cancelAction();
            that.refreshMergePanel();
        });
}

MergePanel.prototype.checkMergeItem = function (itemId, itemName) {
    if (this.firstItem == null) {
        this.firstItem = {name: itemName, id: itemId};
    } else {
        this.secondItem = {name: itemName, id: itemId};
    }
    this.refreshMergePanel();
}

MergePanel.prototype.uncheckItem = function (id) {
    if (this.firstItem != null && this.firstItem.id === id) {
        this.firstItem = null;
    }
    if (this.secondItem != null && this.secondItem.id === id) {
        this.secondItem = null;
    }
    this.refreshMergePanel();
}

MergePanel.prototype.refreshMergePanel = function () {
    if (this.firstItem != null || this.secondItem != null) {

        this.mergeList.empty();
        this.mergeSelect.empty();

        if (this.firstItem != null) {
            this.mergeList.append('<li>' + this.firstItem.name + '</li>');
        }

        if (this.secondItem != null) {
            this.mergeList.append('<li>' + this.secondItem.name + '</li>');
        }

        if (this.firstItem != null && this.secondItem != null) {
            this.mergeSelect.append($("<option>")
                    .val(this.secondItem.id)
                    .html(this.secondItem.name)
            );
            this.mergeSelect.append($("<option>")
                    .val(this.firstItem.id)
                    .html(this.firstItem.name)
            );
            var that = this;
            this.mergeButton.unbind().on('click', function () {
                that.showMergeDialog();
            });

            this.mergeButton.prop("disabled", false);
            this.mergeSelect.show();
        } else {
            this.mergeButton.prop("disabled", true);
            this.mergeSelect.hide();
        }

        this.mergeContainer.show();
    } else {
        this.mergeContainer.hide();
    }
}

MergePanel.prototype.getSelectedMergeId = function () {
    return this.mergeSelect.val();
}

MergePanel.prototype.getSecondMergeId = function () {
    return this.mergeSelect.val() === this.firstItem.id ? this.secondItem.id : this.firstItem.id;
}

MergePanel.prototype.emptyItems = function () {
    this.firstItem = null;
    this.secondItem = null;
}