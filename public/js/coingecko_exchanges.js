"use strict";
function CoingeckoExchanges(){

}

CoingeckoExchanges.prototype.init = function () {
    var oTable = $('#coingecko_exchanges').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_exchanges_route').val(),
        "columns": [
            {data: 'api_id', name: 'api_id'},
            {data: 'name', name: 'name'},
            {data: 'year_established', name: 'year_established'},
            {data: 'country', name: 'country'},
            {data: 'description', name: 'description'},
            {data: 'url', name: 'url'},
            {data: 'image', name: 'image'},
            {data: 'has_trading_incentive', name: 'has_trading_incentive'},
            {data: 'trust_score', name: 'trust_score'},
            {data: 'trust_score_rank', name: 'trust_score_rank'},
            {data: 'trade_volume_24h_btc_normalized', name: 'trade_volume_24h_btc_normalized'},
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_exchanges tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

CoingeckoExchanges.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new CoingeckoExchanges();
    coins.init();
    coins.bindEvents();
});
