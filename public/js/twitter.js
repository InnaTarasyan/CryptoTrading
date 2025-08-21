"use strict";
function Twitter(){
    var oTable;
}

/*
 Initializes the datatable
 */
Twitter.prototype.init = function () {
    this.oTable = $('#twitter').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#twitter_route').val(),
        "responsive": {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return '<h4 class="modal-title">Twitter Account Details</h4>';
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
                data: 'account', 
                name: 'account', 
                "defaultContent": 'Not Set',
                "responsivePriority": 2
            },
            {
                data: 'rel_coins', 
                name: 'rel_coins', 
                "defaultContent": 'Not Set',
                "responsivePriority": 3
            },
            {
                data: 'action', 
                name: 'action',
                "responsivePriority": 4,
                "orderable": false,
                "searchable": false
            }
        ],
        "aaSorting": [[ 1, "asc" ]],
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

Twitter.prototype.bindEvents = function () {
    $(document).on('click', '.edit', this.editAccount.bind(this));
    $(document).on('click', '.delete', this.deleteAccount.bind(this));
    $(document).on('click', '.add', this.addAccount.bind(this));
    $(document).on('click', '.save', this.saveAccount.bind(this));
    $(document).on('click', '.update', this.updateAccount.bind(this));
};

/*
 Stores the updated data in the database
 */
Twitter.prototype.updateAccount = function () {

    var self = this;
    var id  = $('#coin_id').val();

    var coin = $('#coin').val();
    var account = $('#twitter_account').val();

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

/*
 Brings the corresponding coin related data from database
 */
Twitter.prototype.editAccount = function (event) {

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

                $('.account_action').addClass('update');
                $('.account_action').removeClass('save');

                $('#coin_id').val(res.data.account_id);
                $('#twitter_account').val(res.data.account);


                $('#coin').select2('data', { id: res.data.id, code:  res.data.coin});
                $('#rel_coins').select2('data', res.data.rel_coins);
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

/*
 Stores data in database
 */
Twitter.prototype.saveAccount = function () {
    var self = this;

    var coin =  $('#coin').val();
    var account = $('#twitter_account').val();

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
        url: "twitter",
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

Twitter.prototype.addAccount = function () {

    $('.account_action').removeClass('update');
    $('.account_action').addClass('save');

    //$('#rel_coins').select2().select2('val', '');

    $('#coin_id').val('');
    $('#twitter_account').val('');
};

$(document).ready(function() {
    var coins = new Twitter();
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
        formatResult: function (item) { return item.code; },
        formatSelection: function (item) { return item.code; },
    });
});