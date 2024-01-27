"use strict";
function Derivatives(){

}

Derivatives.prototype.init = function () {
    var oTable = $('#coingecko_derivatives').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_derivatives_route').val(),
        "columns": [
            {data: 'symbol', name: 'symbol'},
            {data: 'market', name: 'market'},
            {data: 'index_id', name: 'index_id'},
            {data: 'price', name: 'price'},
            {data: 'price_percentage_change_24h', name: 'price_percentage_change_24h'},
            {data: 'contract_type', name: 'contract_type'},
            {data: 'index', name: 'index'},
            {data: 'basis', name: 'basis'},
            {data: 'spread', name: 'spread'},
            {data: 'funding_rate', name: 'funding_rate'},
            {data: 'open_interest', name: 'open_interest'},
            {data: 'volume_24h', name: 'volume_24h'},
            {data: 'last_traded_at', name: 'last_traded_at'},
            {data: 'expired_at', name: 'expired_at'},
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_derivatives tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

Derivatives.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new Derivatives();
    coins.init();
    coins.bindEvents();
});
