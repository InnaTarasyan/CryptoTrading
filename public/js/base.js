"use strict";
function Base() {
}

Base.prototype.bindEvents = function () {
    $(document).on('click', '#updateAllData', this.updateAll.bind(this));
};

Base.prototype.updateAll = function (event) {
    var btn = $('#updateAllData');
    var spinner = $('#updateAllDataSpinner');
    var btnText = $('#updateAllDataText');
    btn.attr('aria-busy', 'true').prop('disabled', true);
    spinner.show();
    btnText.text('Updating Data ...');

    $.ajax({
        type: 'Get',
        url: 'reloadData',
        success: function (res) {
            btn.attr('aria-busy', 'false').prop('disabled', false);
            spinner.hide();
            btnText.text('Update All Data');
        },
        error: function (res) {
            btn.attr('aria-busy', 'false').prop('disabled', false);
            spinner.hide();
            btnText.text('Update All Data');
        }
    });
};

$(document).ready(function() {
    var base = new Base();
    base.bindEvents();
});