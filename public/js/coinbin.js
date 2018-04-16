function Coinbin(){

}

Coinbin.prototype.init = function () {
    var oTable = $('#coinbin').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coinbin_route').val(),
        "columns": [
            {data: 'ticker', name: 'ticker'},
            {data: 'rank', name: 'rank'},
            {data: 'btc', name: 'btc'},
            {data: 'name', name: 'name'},
            {data: 'usd', name: 'usd'}
        ],
        "aaSorting": [[1, "asc"]]
    });
};

Coinbin.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new Coinbin();
    coins.init();
    coins.bindEvents();
});
