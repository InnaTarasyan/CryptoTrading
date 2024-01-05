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
            {data: 'name', name: 'name'},
            {data: 'countries', name: 'countries'},
            {data: 'flag', name: 'flag'},
        ],
        "iDisplayLength": 20,
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
