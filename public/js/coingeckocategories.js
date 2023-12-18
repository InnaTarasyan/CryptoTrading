"use strict";
function CoingeckoGeckoCategories(){

}

CoingeckoGeckoCategories.prototype.init = function () {
    var oTable = $('#coingecko_categories').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_categories_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'category_id', name: 'category_id'},
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_categories tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

CoingeckoGeckoCategories.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new CoingeckoGeckoCategories();
    coins.init();
    coins.bindEvents();
});
