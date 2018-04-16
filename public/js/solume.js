function Solume(){

}

Solume.prototype.init = function () {
   var oTable = $('#solume').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#solume_route').val(),
        "columns": [
            {data: 'symbol', name: 'symbol'},
            {data: 'rank', name: 'rank'},
            {data: 'change_24h', name: 'change_24h'},
            {data: 'reddit_change_24h', name: 'reddit_change_24h'},
            {data: 'reddit_volume_24h', name: 'reddit_volume_24h'},
            {data: 'sentiment_24h', name: 'sentiment_24h'},
            {data: 'sentiment_change_24h', name: 'sentiment_change_24h'},
            {data: 'twitter_change_24h', name: 'twitter_change_24h'},
            {data: 'twitter_volume_24h', name: 'twitter_volume_24h'},
            {data: 'volume_24h', name: 'volume_24h'}
        ],
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
    });
};

Solume.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new Solume();
    coins.init();
    coins.bindEvents();
});
