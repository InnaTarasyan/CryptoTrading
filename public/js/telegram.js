"use strict";
function Telegram(){
  var oTable;
}

/*
   Initializes the datatable
 */
Telegram.prototype.init = function () {
    this.oTable = $('#telegram').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#telegram_route').val(),
        "columns": [
            {data: 'coin', name: 'coin', "defaultContent" : 'Not Set'},
            {data: 'account', name: 'account', "defaultContent" : 'Not Set'},
            {data: 'rel_coins', name: 'rel_coins', "defaultContent" : 'Not Set'},
            {data: 'action', name: 'action'}
        ],
        "aaSorting": [[ 1, "asc" ]]
    });
};

Telegram.prototype.bindEvents = function () {
   $(document).on('click', '.edit', this.editAccount.bind(this));
   $(document).on('click', '.delete', this.deleteAccount.bind(this));
   $(document).on('click', '.add', this.addAccount.bind(this));
   $(document).on('click', '.save', this.saveAccount.bind(this));
   $(document).on('click', '.update', this.updateAccount.bind(this));
};

/*
   Stores the updated data in the database
 */
Telegram.prototype.updateAccount = function () {

    var self = this;
    var id  = $('#coin_id').val();

    var coin = $('#coin').val();
    var account = $('#telegram_account').val();

    if(!coin){
        swal({
            title: 'Error!',
            text: "Coin is mandatory!",
            type: 'warning'
        });
        return;
    }

    if(!account){
        swal({
            title: 'Error!',
            text: "Account is mandatory!",
            type: 'warning'
        });
        return;
    }

    var fd = new FormData();
    fd.append('id', id);
    fd.append('coin', coin);
    fd.append('rel_coins', $('#rel_coins').val());
    fd.append('account', account);
    fd.append('_token', $('meta[name="_token"]').attr('content'));
    fd.append('_method', 'PATCH');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: fd,
        url: "telegram/" + id,
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

/*
   Brings the corresponding coin related data from database
 */
Telegram.prototype.editAccount = function (event) {

    var id = $(event.target).attr('data-url');

    var fd = new FormData();
    fd.append('id', id);
    fd.append('_token', $('meta[name="_token"]').attr('content'));

    $.ajax({
        type: 'Get',
        dataType: 'json',
        data: fd,
        url: "telegram/" + id + '/edit',
        processData: false,
        contentType: false,
        success: function (res) {
            if(res.data){

                $('.account_action').addClass('update');
                $('.account_action').removeClass('save');

                $('#coin_id').val(res.data.account_id);
                $('#telegram_account').val(res.data.account);

                $('#coin').select2('data', { id: res.data.id, name:  res.data.coin});
                $('#rel_coins').select2('data', res.data.rel_coins);
            }
        },
        error: function (res) {

        }
    });

};

Telegram.prototype.deleteAccount = function (event) {

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
                url: "telegram/" + id,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.status == 'ok'){
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

/*
   Stores data in database
 */
Telegram.prototype.saveAccount = function () {
    var self = this;

    var coin =  $('#coin').val();
    var account = $('#telegram_account').val();

    if(!coin){
        swal({
            title: 'Error!',
            text: "Coin is mandatory!",
            type: 'warning'
        });
        return;
    }

    if(!account){
        swal({
            title: 'Error!',
            text: "Account is mandatory!",
            type: 'warning'
        });
        return;
    }

    var fd = new FormData();
    fd.append('coin', coin);
    fd.append('rel_coins', $('#rel_coins').val());
    fd.append('account', account);
    fd.append('_token', $('meta[name="_token"]').attr('content'));

    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: fd,
        url: "telegram",
        processData: false,
        contentType: false,
        success: function (data) {
            if(data.status == 'ok'){
                self.oTable.ajax.reload();
            } else {
                swal({
                    title: 'Error',
                    text: "Account already Exists!",
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

Telegram.prototype.addAccount = function () {

  $('.account_action').removeClass('update');
  $('.account_action').addClass('save');

  //$('#rel_coins').select2().select2('val', '');

  $('#coin_id').val('');
  $('#telegram_account').val('');
};

$(document).ready(function() {
    var coins = new Telegram();
    coins.init();
    coins.bindEvents();

    $('#coin').select2({
        placeholder: "Select an Option",
        allowClear: true,
        language: 'ru',
        ajax: {
            url: 'ajaxGetCoins',
            data: function (term, page) {
                return {
                    q: term,
                };
            },
            results: function (data, page) {
                return {
                    results: data
                };
            },
            cache: true
        },
        formatResult: function (item) { return item.name; },
        formatSelection: function (item) { return item.name; },
    });


    $('#rel_coins').select2({
        placeholder: "Select an Option",
        multiple: true,
        allowClear: true,
        language: 'ru',
        ajax: {
            url: 'ajaxGetCoins',
            data: function (term, page) {
                return {
                    q: term,
                };
            },
            results: function (data, page) {
                return {
                    results: data
                };
            },
            cache: true
        },
        formatResult: function (item) { return item.name; },
        formatSelection: function (item) { return item.name; },
    });
});