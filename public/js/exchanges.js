"use strict";
function Exchanges(){

}

Exchanges.prototype.init = function () {
    var oTable = $('#exchanges').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#exchanges_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'markets', name: 'markets'},
            {data: 'volume', name: 'volume'},
            {data: 'bidTotal', name: 'bidTotal'},
            {data: 'askTotal', name: 'askTotal'},
            {data: 'depth', name: 'depth'},
            {data: 'visitors', name: 'visitors'},
            {data: 'volumePerVisitor', name: 'volumePerVisitor'}
        ],
        "iDisplayLength": 5,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#exchanges tbody tr').click(function () {
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
