"use strict";
function CoingeckoExchangeRates(){

}

CoingeckoExchangeRates.prototype.init = function () {
    var oTable = $('#coingecko_exchange_rates').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_exchange_rates_route').val(),
        "columns": [
            {data: 'symbol', name: 'symbol'},
            {data: 'name', name: 'name'},
            {data: 'unit', name: 'unit'},
            {data: 'value', name: 'value'},
            {data: 'type', name: 'type'},
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_exchange_rates tbody tr').click(function () {
                var coin = $(this).find('.id').val();
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
