"use strict";
function Base() {
}

Base.prototype.bindEvents = function () {
    $(document).on('click', '#updateAllData', this.updateAll.bind(this));
};

Base.prototype.updateAll = function (event) {
    $('#updateAllData').text('Updating Data ...');

    $.ajax({
        type: 'Get',
        url: 'reloadData',
        success: function (res) {
            $('#updateAllData').text('Update All Data');
        },
        error: function (res) {

        }
    });
};

$(document).ready(function() {
    var base = new Base();
    base.bindEvents();
});