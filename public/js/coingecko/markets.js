"use strict";
function Coingecko(){

}

Coingecko.prototype.init = function () {
    var oTable = $('#coingecko_markets').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_markets_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'image', name: 'image'},
            {data: 'current_price', name: 'current_price'},
            {data: 'market_cap', name: 'market_cap'},
            {data: 'market_cap_rank', name: 'market_cap_rank'},
            {data: 'fully_diluted_valuation', name: 'fully_diluted_valuation'},
            {data: 'total_volume', name: 'total_volume'},
            {data: 'high_24h', name: 'high_24h'},
            {data: 'low_24h', name: 'low_24h'},
            {data: 'price_change_24h', name: 'price_change_24h'},
            {data: 'price_change_percentage_24h', name: 'price_change_percentage_24h'},
            {data: 'market_cap_change_24h', name: 'market_cap_change_24h'},
            {data: 'market_cap_change_percentage_24h', name: 'market_cap_change_percentage_24h'},
            {data: 'circulating_supply', name: 'circulating_supply'},
            {data: 'total_supply', name: 'total_supply'},
            {data: 'max_supply', name: 'max_supply'},
            {data: 'ath', name: 'ath'},
            {data: 'ath_change_percentage', name: 'ath_change_percentage'},
            {data: 'atl', name: 'atl'},
            {data: 'atl_change_percentage', name: 'atl_change_percentage'},
            {data: 'roi', name: 'roi'},
            {data: 'ath_date', name: 'ath_date'},
            {data: 'atl_date', name: 'atl_date'},
            {data: 'last_updated', name: 'last_updated'},
        ],
        "iDisplayLength": 5,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_markets tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

Coingecko.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new Coingecko();
    coins.init();
    coins.bindEvents();
});
