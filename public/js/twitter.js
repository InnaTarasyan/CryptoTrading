function Twitter(){
  var oTable;
}

Twitter.prototype.modalContent = function (id, coin, account) {

    return '<form>' +
              '<input type="hidden" id="coin_id" value="' + id + '">' +
              '<div class="form-group">' +
                 '<label for="recipient-name" class="form-control-label">' +
                      'Coin:' +
                 '</label>' +
                 '<input type="text" class="form-control" id="coin" value="' + coin + '">' +
              '</div>' +
              '<div class="form-group">' +
                  '<label for="message-text" class="form-control-label">' +
                      'Twitter Account:' +
                  '</label>' +
                  '<textarea class="form-control" id="twitter_account">' + account + '</textarea>' +
              '</div>' +
           '</form>'
};

Twitter.prototype.init = function () {
    this.oTable = $('#twitter').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#twitter_route').val(),
        "columns": [
            {data: 'coin', name: 'coin', "defaultContent" : 'Not Set'},
            {data: 'account', name: 'account', "defaultContent" : 'Not Set'},
            {data: 'action', name: 'action'},
        ],
        "aaSorting": [[ 1, "asc" ]]
    });
};

Twitter.prototype.bindEvents = function () {
   $(document).on('click', '.edit', this.editAccount.bind(this));
   $(document).on('click', '.delete', this.deleteAccount.bind(this));
   $(document).on('click', '.add', this.addAccount.bind(this));
   $(document).on('click', '.save', this.saveAccount.bind(this));
   $(document).on('click', '.update', this.updateAccount.bind(this));
};

Twitter.prototype.updateAccount = function () {

    var self = this;
    var id  = $('#coin_id').val();

    var fd = new FormData();
    fd.append('id', id);
    fd.append('coin', $('#coin').val());
    fd.append('account', $('#twitter_account').val());
    fd.append('_token', $('meta[name="_token"]').attr('content'));
    fd.append('_method', 'PATCH');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: fd,
        url: "twitter/" + id,
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

Twitter.prototype.editAccount = function (event) {

    var self = this;
    var id = $(event.target).attr('data-url');

    var fd = new FormData();
    fd.append('id', id);
    fd.append('_token', $('meta[name="_token"]').attr('content'));

    $.ajax({
        type: 'Get',
        dataType: 'json',
        data: fd,
        url: "twitter/" + id + '/edit',
        processData: false,
        contentType: false,
        success: function (res) {
            if(res.data){
                $(document).find('.modal-body').html(self.modalContent(res.data.id, res.data.coin, res.data.account));
                $('.account_action').addClass('update');
                $('.account_action').removeClass('save');
            }
        },
        error: function (res) {

        }
    });

};

Twitter.prototype.deleteAccount = function (event) {

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
                url: "twitter/" + id,
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

Twitter.prototype.saveAccount = function () {
    var self = this;

    var fd = new FormData();
    fd.append('coin', $('#coin').val());
    fd.append('account', $('#twitter_account').val());
    fd.append('_token', $('meta[name="_token"]').attr('content'));

    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: fd,
        url: "twitter",
        processData: false,
        contentType: false,
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

Twitter.prototype.addAccount = function () {
  $(document).find('.modal-body').html(this.modalContent('', '', ''));
  $('.account_action').removeClass('update');
  $('.account_action').addClass('save');
};

$(document).ready(function() {
    var coins = new Twitter();
    coins.init();
    coins.bindEvents();
});