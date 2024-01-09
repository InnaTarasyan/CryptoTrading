"use strict";
function CoingeckoExchangeRates(){

}

CoingeckoExchangeRates.prototype.init = function () {
    var oTable = $('#coinmarketcal').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coinmarketcal_route').val(),
        "columns": [
            {data: 'symbol', name: 'symbol'},
            {data: 'name', name: 'name'},
            {data: 'rank', name: 'rank'},
            {data: 'fullname', name: 'fullname'},
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coinmarketcal tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

CoingeckoExchangeRates.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new CoingeckoExchangeRates();
    coins.init();
    coins.bindEvents();
});
