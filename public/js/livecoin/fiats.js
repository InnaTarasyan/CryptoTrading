"use strict";
function Fiats(){

}

Fiats.prototype.init = function () {
    var oTable = $('#livecoin_fiats').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#livecoin_fiats_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'countries', name: 'countries'},
            {data: 'flag', name: 'flag'},
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#livecoin_fiats tbody tr').click(function () {
                var coin = $(this).find('.id').val();
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
