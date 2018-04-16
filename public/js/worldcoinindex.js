function WorldCoinIndex(){

}

WorldCoinIndex.prototype.init = function () {
    var oTable = $('#worldcoinindex').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#worldcoinindex_route').val(),
        "columns": [
            {data: 'Label', name: 'Label'},
            {data: 'Name', name: 'Name'},
            {data: 'Price_btc', name: 'Price_btc'},
            {data: 'Price_usd', name: 'Price_usd'},
            {data: 'Price_cny', name: 'Price_cny'},
            {data: 'Price_eur', name: 'Price_eur'},
            {data: 'Price_gbp', name: 'Price_gbp'},
            {data: 'Price_rur', name: 'Price_rur'},
            {data: 'Volume_24h', name: 'Volume_24h'},

        ],
        "aaSorting": [[0, "asc"]]
    });
};

WorldCoinIndex.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new WorldCoinIndex();
    coins.init();
    coins.bindEvents();
});

