"use strict";
function Fiats(){

}

Fiats.prototype.init = function () {
    var oTable = $('#fiats').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#fiats_route').val(),
        "columns": [
            {data: 'code', name: 'code'},
            {data: 'countries', name: 'countries'},
            {data: 'flag', name: 'flag'},
            {data: 'name', name: 'name'},
            {data: 'symbol', name: 'symbol'},
        ],
        "iDisplayLength": 5,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#fiats tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

Fiats.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new Fiats();
    coins.init();
    coins.bindEvents();
});
