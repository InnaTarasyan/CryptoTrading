"use strict";
function CoinmarketCap(){

}

CoinmarketCap.prototype.init = function () {
   var oTable = $('#coinmarketcap').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coindar_route').val(),
        "columns": [
            {data: 'symbol', name: 'symbol', "defaultContent" : 'Not Set'},
            {data: 'rank', name: 'rank', "defaultContent" : 'Not Set'},
            {data: 'price_usd', name: 'price_usd', "defaultContent" : 'Not Set'},
            {data: '24h_volume_usd', name: '24h_volume_usd', "defaultContent" : 'Not Set'},
            {data: 'market_cap_usd', name: 'market_cap_usd', "defaultContent" : 'Not Set'},
            {data: 'available_supply', name: 'available_supply', "defaultContent" : 'Not Set'},
            {data: 'total_supply', name: 'total_supply', "defaultContent" : 'Not Set'},
            {data: 'percent_change_1h', name: 'percent_change_1h', "defaultContent" : 'Not Set'},
            {data: 'percent_change_24h', name: 'percent_change_24h', "defaultContent" : 'Not Set'},
            {data: 'percent_change_7d', name: 'percent_change_7d',  "defaultContent" : 'Not Set'}
        ],
        "iDisplayLength": 5,
        "columnDefs" : [{
            "targets" : 3 ,
            "render" : function ( url, type, full) {
                return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
            }},{
            "targets" : 4 ,
            "render" : function ( url, type, full) {
                return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
            }},{
            "targets" : 5 ,
            "render" : function ( url, type, full) {
                return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
            }},{
            "targets" : 6 ,
            "render" : function ( url, type, full) {
                return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
            }}],
        "aaSorting": [[ 1, "asc" ]],
        "fnDrawCallback": function() {
            $('#coinmarketcap tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

CoinmarketCap.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new CoinmarketCap();
    coins.init();
    coins.bindEvents();
});