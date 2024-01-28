"use strict";
function TradingPairs(){
    var oTable;
}

TradingPairs.prototype.init = function () {
     this.oTable = $('#tradingPair').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#tradingPair_route').val(),
        "columns": [
            {data: 'coin', name: 'coin', "defaultContent" : 'Not Set'},
            {data: 'trading_pair', name: 'trading_pair', "defaultContent" : 'Not Set'},
            {data: 'action', name: 'action'}

        ],
        "iDisplayLength": 10,
        "aaSorting": [[ 1, "asc" ]]
    });
};

TradingPairs.prototype.bindEvents = function () {
    $(document).on('click', '.add', this.addTradingPair.bind(this));
    $(document).on('click', '.save', this.saveTradingPair.bind(this));
    $(document).on('click', '.edit', this.editTradingPair.bind(this));
    $(document).on('click', '.update', this.updateTradingPair.bind(this));
    $(document).on('click', '.delete', this.deleteTradingPair.bind(this));
};

TradingPairs.prototype.updateTradingPair = function () {
    var self = this;
    var id  = $('#coin_id').val();

    var coin =  $('#coin').val();
    var trading_pair = $('#trading_pair').val();

    if(!coin){
        swal({
            title: 'Error!',
            text: "Coin is mandatory!",
            type: 'warning'
        });
        return;
    }

    if(!trading_pair){
        swal({
            title: 'Error!',
            text: "Trading Pair is mandatory!",
            type: 'warning'
        });
        return;
    }


    var fd = new FormData();
    fd.append('id', id);
    fd.append('coin', coin);
    fd.append('trading_pair', trading_pair);
    fd.append('_token', $('meta[name="_token"]').attr('content'));
    fd.append('_method', 'PATCH');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: fd,
        url: "tradingPairs/" + id,
        success: function (data) {
            if(data.status == 'ok'){
                self.oTable.ajax.reload();
                $('#m_modal_1').modal('toggle');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
};

TradingPairs.prototype.editTradingPair = function () {

    var id = $(event.target).attr('data-url');

    var fd = new FormData();
    fd.append('id', id);
    fd.append('_token', $('meta[name="_token"]').attr('content'));

    $.ajax({
        type: 'Get',
        dataType: 'json',
        data: fd,
        url: "tradingPairs/" + id + '/edit',
        processData: false,
        contentType: false,
        success: function (res) {
            if(res.data){

                $('.account_action').addClass('update');
                $('.account_action').removeClass('save');

                $('#coin_id').val(res.data.id);
                $('#coin').val(res.data.coin);
                $('#trading_pair').val(res.data.trading_pair);
            }
        },
        error: function (res) {

        }
    });

};

TradingPairs.prototype.addTradingPair = function () {

    $('.account_action').removeClass('update');
    $('.account_action').addClass('save');

    $('#coin').val('');
    $('#trading_pair').val('');
};


TradingPairs.prototype.saveTradingPair = function () {

    var self = this;

    var coin =  $('#coin').val();
    var trading_pair = $('#trading_pair').val();

    if(!coin){
        swal({
            title: 'Error!',
            text: "Coin is mandatory!",
            type: 'warning'
        });
        return;
    }

    if(!trading_pair){
        swal({
            title: 'Error!',
            text: "Trading Pair is mandatory!",
            type: 'warning'
        });
        return;
    }

    var fd = new FormData();
    fd.append('coin', coin);
    fd.append('trading_pair', trading_pair);
    fd.append('_token', $('meta[name="_token"]').attr('content'));

    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: fd,
        url: "tradingPairs",
        processData: false,
        contentType: false,
        success: function (data) {
            if(data.status == 'ok'){
                self.oTable.ajax.reload();
            } else {
                swal({
                    title: 'Error',
                    text: "Trading Pair already Exists!",
                    type: 'warning'
                })
            }
            $('#m_modal_1').modal('toggle');
        },
        error: function (data) {
            console.log(data);
        }
    });


};

TradingPairs.prototype.deleteTradingPair = function () {
    var self = this;
    var id = $(event.target).attr('data-url');

    var fd = new FormData();
    fd.append('id', id);
    fd.append('_token', $('meta[name="_token"]').attr('content'));
    fd.append('_method', 'DELETE');

    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: fd,
                url: "tradingPairs/" + id,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.status === 'ok'){
                        self.oTable.ajax.reload();
                        swal("Deleted!", "Success", "success");
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });
};

$(document).ready(function() {
    var coins = new TradingPairs();
    coins.init();
    coins.bindEvents();
});
