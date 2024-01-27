"use strict";
function Exchanges(){

}

Exchanges.prototype.init = function () {
    var oTable = $('#livecoin_exchanges').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#livecoin_exchanges_route').val(),
        "columns": [
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'png128', name: 'png128'},
            {data: 'markets', name: 'markets'},
            {data: 'volume', name: 'volume'},
            {data: 'bidTotal', name: 'bidTotal'},
            {data: 'askTotal', name: 'askTotal'},
            {data: 'depth', name: 'depth'},
            {data: 'centralized', name: 'centralized'},
            {data: 'usCompliant', name: 'usCompliant'},
            {data: 'visitors', name: 'visitors'},
            {data: 'volumePerVisitor', name: 'volumePerVisitor'}
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#livecoin_exchanges tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

Exchanges.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new Exchanges();
    coins.init();
    coins.bindEvents();
});
