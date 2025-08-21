"use strict";
function TradingPairs(){
    var oTable;
}

TradingPairs.prototype.init = function () {
     this.oTable = $('#tradingPair').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#tradingPair_route').val(),
        "responsive": {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return '<h4 class="modal-title">Trading Pair Details</h4>';
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table table-striped table-bordered'
                })
            }
        },
        "columns": [
            {
                data: 'coin', 
                name: 'coin', 
                "defaultContent": 'Not Set',
                "responsivePriority": 1,
                "className": "dtr-control"
            },
            {
                data: 'trading_pair', 
                name: 'trading_pair', 
                "defaultContent": 'Not Set',
                "responsivePriority": 2
            },
            {
                data: 'action', 
                name: 'action',
                "responsivePriority": 3,
                "orderable": false,
                "searchable": false
            }
        ],
        "pageLength": 10,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "language": {
            "lengthMenu": "Show _MENU_ entries per page",
            "zeroRecords": "No matching records found",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "search": "Search:",
            "processing": "Processing...",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "autoWidth": false,
        "scrollX": true,
        "scrollCollapse": true
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

                $('#coin_id').val(res.data.trading_pair_id);

               // $('#coin').val(res.data.coin);
                $('#trading_pair').val(res.data.trading_pair);

                $('#coin').select2('data', { id: res.data.id, code:  res.data.coin});

            }
        },
        error: function (res) {

        }
    });

};

TradingPairs.prototype.addTradingPair = function () {

    $('.account_action').removeClass('update');
    $('.account_action').addClass('save');

    $('#trading_pair').val('');
    $('#coin').select2('data', null);
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

    // Mobile-specific enhancements
    function enhanceMobileExperience() {
        var isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            // Optimize for mobile devices
            $('.dataTables_wrapper').addClass('mobile-optimized');
            
            // Add touch-friendly scrolling
            $('.table-responsive').css({
                '-webkit-overflow-scrolling': 'touch',
                'overflow-x': 'auto'
            });
            
            // Ensure proper button sizing for touch
            $('.btn-edit, .btn-delete').css({
                'min-height': '44px',
                'min-width': '44px'
            });
        }
    }

    // Call on load and resize
    enhanceMobileExperience();
    $(window).on('resize', enhanceMobileExperience);

    // Touch event handling for mobile
    if ('ontouchstart' in window) {
        $('.btn-edit, .btn-delete').on('touchstart', function() {
            $(this).addClass('touch-active');
        }).on('touchend', function() {
            $(this).removeClass('touch-active');
        });
    }

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
        formatResult: function (item) { return item.code; },
        formatSelection: function (item) { return item.code; },
    });

});
