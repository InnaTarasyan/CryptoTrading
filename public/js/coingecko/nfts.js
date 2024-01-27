"use strict";
function Nfts(){

}

Nfts.prototype.init = function () {
    var oTable = $('#coingecko_nfts').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_nfts_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'asset_platform_id', name: 'asset_platform_id'},
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_nfts tbody tr').click(function () {
                var coin = $(this).find('td:first').find('.pointer').data('id');
                window.location.href = "/details/" + coin;
            });
        }
    });
};

Nfts.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new Nfts();
    coins.init();
    coins.bindEvents();
});
