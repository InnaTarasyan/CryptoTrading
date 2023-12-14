"use strict";
function CoingeckoTrendings(){

}

CoingeckoTrendings.prototype.init = function () {
    var oTable = $('#coingecko_trendings').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_trendings_route').val(),
        "columns": [
            {data: 'api_id', name: 'api_id'},
            {data: 'coin_id', name: 'coin_id'},
            {data: 'name', name: 'name'},
            {data: 'symbol', name: 'symbol'},
            {data: 'market_cap_rank', name: 'market_cap_rank'},
            {data: 'thumb', name: 'thumb'},
            {data: 'small', name: 'small'},
            // {date: 'large', name: 'large'},
            {data: 'slug', name: 'slug'},
            {data: 'price_btc', name: 'price_btc'},
            {data: 'score', name: 'score'},
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_trendings tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

CoingeckoTrendings.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new CoingeckoTrendings();
    coins.init();
    coins.bindEvents();
});
