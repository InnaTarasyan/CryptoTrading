"use strict";
function CoingeckoTrendings(){

}

CoingeckoTrendings.prototype.init = function () {
    var oTable = $('#coingecko_trendings').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_trendings_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'small', name: 'small'},
            {data: 'market_cap_rank', name: 'market_cap_rank'},
            {data: 'slug', name: 'slug'},
            {data: 'price_btc', name: 'price_btc'},
            {data: 'score', name: 'score'},
            {data: 'data', name: 'data'},
        ],
        "iDisplayLength": 2,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_trendings tbody tr').click(function () {
                var coin = $(this).find('.id').val();
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
