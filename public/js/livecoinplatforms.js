"use strict";
function LiveCoinPlatforms(){

}

LiveCoinPlatforms.prototype.init = function () {
    var oTable = $('#livecoinplatforms').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#livecoinplatforms_route').val(),
        "columns": [
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'}
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#livecoinplatforms tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

LiveCoinPlatforms.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new LiveCoinPlatforms();
    coins.init();
    coins.bindEvents();
});
