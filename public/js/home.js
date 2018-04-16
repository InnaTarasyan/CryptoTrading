function CoinmarketCap(){

}

CoinmarketCap.prototype.init = function () {
   var oTable = $('#coinmarketcap').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coindar_route').val(),
        "columns": [
            {data: 'symbol', name: 'symbol'},
            {data: 'rank', name: 'rank'},
            {data: 'price_usd', name: 'price_usd'},
            {data: '24h_volume_usd', name: '24h_volume_usd'},
            {data: 'market_cap_usd', name: 'market_cap_usd'},
            {data: 'available_supply', name: 'available_supply'},
            {data: 'total_supply', name: 'total_supply'},
            {data: 'percent_change_1h', name: 'percent_change_1h'},
            {data: 'percent_change_24h', name: 'percent_change_24h'},
            {data: 'percent_change_7d', name: 'percent_change_7d'},
            {data: 'last_updated', name: 'last_updated'}
        ],
        "columnDefs" : [{
            "targets" : 2,
            "render" : function ( url, type, full) {
                return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
            }}, {
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
        "aaSorting": [[ 1, "asc" ]]
    });
};

CoinmarketCap.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new CoinmarketCap();
    coins.init();
    coins.bindEvents();
});