"use strict";
function CoingeckoDerivativesExchanges(){

}

CoingeckoDerivativesExchanges.prototype.init = function () {
    var oTable = $('#derivatives_exchanges').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#derivatives_exchanges_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'image', name: 'image'},
            {data: 'description', name: 'description'},
            {data: 'open_interest_btc', name: 'open_interest_btc'},
            {data: 'trade_volume_24h_btc', name: 'trade_volume_24h_btc'},
            {data: 'number_of_perpetual_pairs', name: 'number_of_perpetual_pairs'},
            {data: 'number_of_futures_pairs', name: 'number_of_futures_pairs'},
            {data: 'year_established', name: 'year_established'},
            {data: 'country', name: 'country'},
            {data: 'url', name: 'url'}
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#derivatives_exchanges tbody tr').click(function () {
                var coin = $(this).find('td:first').find('.pointer').data('id');
                window.location.href = "/details/" + coin;
            });
        }
    });
};

CoingeckoDerivativesExchanges.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new CoingeckoDerivativesExchanges();
    coins.init();
    coins.bindEvents();
});
