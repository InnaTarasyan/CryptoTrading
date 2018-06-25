"use strict";
function Solume(){

}

Solume.prototype.init = function () {
   var oTable = $('#solume').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#solume_route').val(),
        "columns": [
            {data: 'symbol', name: 'symbol', "defaultContent" : 'Not Set'},
            {data: 'rank', name: 'rank', "defaultContent" : 'Not Set'},
            {data: 'change_24h', name: 'change_24h', "defaultContent" : 'Not Set'},
            {data: 'volume_24h', name: 'volume_24h', "defaultContent" : 'Not Set'},
            {data: 'reddit_change_24h', name: 'reddit_change_24h', "defaultContent" : 'Not Set'},
            {data: 'reddit_volume_24h', name: 'reddit_volume_24h', "defaultContent" : 'Not Set'},
            {data: 'sentiment_24h', name: 'sentiment_24h', "defaultContent" : 'Not Set'},
            {data: 'sentiment_change_24h', name: 'sentiment_change_24h', "defaultContent" : 'Not Set'},
            {data: 'twitter_change_24h', name: 'twitter_change_24h', "defaultContent" : 'Not Set'},
            {data: 'twitter_volume_24h', name: 'twitter_volume_24h', "defaultContent" : 'Not Set'},

        ],
       "iDisplayLength": 10,
        "aaSorting": [[ 1, "asc" ]],
        "columnDefs" : [{
           "targets" : 2,
           "render" : function ( url, type, full) {
               return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
           }}, {
           "targets" : 3 ,
           "render" : function ( url, type, full) {
               return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
           }},{
           "targets" : 4 ,
           "render" : function ( url, type, full) {
               return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
           }},{
           "targets" : 6 ,
           "render" : function ( url, type, full) {
               return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
           }},{
           "targets" : 7,
           "render" : function ( url, type, full) {
               return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
           }},{
            "targets" : 8,
            "render" : function ( url, type, full) {
                return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
           }},{
            "targets" : 9,
            "render" : function ( url, type, full) {
                    return  (url != null) ? url.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : url;
            }}
        ],
       "fnDrawCallback": function() {
           $('#solume tbody tr').click(function () {
               var coin = $(this).find('td:first').text();
               window.location.href = "/details/" + coin;
           });
       }
    });
};

Solume.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new Solume();
    coins.init();
    coins.bindEvents();
});
