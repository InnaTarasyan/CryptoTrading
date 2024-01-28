"use strict";
function LiveCoin(){

}

LiveCoin.prototype.init = function () {
    var oTable = $('#livecoin_history').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#livecoin_history_route').val(),
        "columns": [
            {data: 'code', name: 'code'},
            {data: 'png64', name: 'png64'},
            {data: 'rate', name: 'rate'},
            {data: 'age', name: 'age'},
            {data: 'pairs', name: 'pairs'},
            {data: 'volume', name: 'volume'},
            {data: 'cap', name: 'cap'},
            {data: 'rank', name: 'rank'},
            {data: 'markets', name: 'markets'},
            {data: 'totalSupply', name: 'totalSupply'},
            {data: 'maxSupply', name: 'maxSupply'},
            {data: 'circulatingSupply', name: 'circulatingSupply'},
            {data: 'allTimeHighUSD', name: 'allTimeHighUSD'},
            {data: 'categories', name: 'categories'},
        ],
        "iDisplayLength": 20,
        "aaSorting": [[3, "desc"]],
        "fnDrawCallback": function() {
            $('#livecoin_history tbody tr').click(function () {
                var coin = $(this).find('.id').val();
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
