"use strict";
function Coinbin(){

}

Coinbin.prototype.init = function () {
    var oTable = $('#coinbin').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coinbin_route').val(),
        "columns": [
            {data: 'ticker', name: 'ticker'},
            {data: 'rank', name: 'rank'},
            {data: 'btc', name: 'btc'},
            {data: 'name', name: 'name'},
            {data: 'usd', name: 'usd'}
        ],
        "iDisplayLength": 5,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coinbin tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

Coinbin.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new Coinbin();
    coins.init();
    coins.bindEvents();
});
