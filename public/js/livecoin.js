"use strict";
function LiveCoin(){

}

LiveCoin.prototype.init = function () {
    var oTable = $('#livecoin').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#livecoin_route').val(),
        "columns": [
            {data: 'code', name: 'code'},
            // {data: 'symbol', name: 'symbol'},
            {data: 'rate', name: 'rate'},
            {data: 'volume', name: 'volume'},
            {data: 'cap', name: 'cap'},
            {data: 'rank', name: 'rank'},
            {data: 'markets', name: 'markets'},
            {data: 'totalSupply', name: 'totalSupply'},
            {data: 'maxSupply', name: 'maxSupply'},
            {data: 'categories', name: 'categories'},
            // {data: 'delta', name: 'delta'}
        ],
        "iDisplayLength": 5,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#livecoin tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

LiveCoin.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new LiveCoin();
    coins.init();
    coins.bindEvents();
});
