"use strict";
function CoindarSocials(){

}

CoindarSocials.prototype.init = function () {
    var oTable = $('#coindar_socials').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coindar_socials_route').val(),
        "columns": [
            {data: 'coin_id', name: 'coin_id'},
            {data: 'website', name: 'website'},
            {data: 'bitcointalk', name: 'bitcointalk'},
            {data: 'twitter', name: 'twitter'},
            {data: 'reddit', name: 'reddit'},
            {data: 'telegram', name: 'telegram'},
            {data: 'facebook', name: 'facebook'},
            {data: 'github', name: 'github'},
            {data: 'explorer', name: 'explorer'},
            {data: 'youtube', name: 'youtube'},
            {data: 'twitter_count', name: 'twitter_count'},
            {data: 'reddit_count', name: 'reddit_count'},
            {data: 'telegram_count', name: 'telegram_count'},
            {data: 'facebook_count', name: 'facebook_count'}
        ],
        "iDisplayLength": 10,
        "fnDrawCallback": function() {
            $('#coindar_socials tbody tr').click(function () {
                var coin = $(this).find('td:first').text();
                window.location.href = "/details/" + coin;
            });
        }
    });
};

CoindarSocials.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new CoindarSocials();
    coins.init();
    coins.bindEvents();
});
