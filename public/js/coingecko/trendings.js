"use strict";
function CoingeckoTrendings(){}

CoingeckoTrendings.prototype.init = function () {
    var oTable = $('#coingecko_trendings').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_trendings_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'small', name: 'small'},
            {data: 'market_cap_rank', name: 'market_cap_rank'},
            {data: 'slug', name: 'slug'},
            {data: 'price_btc', name: 'price_btc'},
            {data: 'score', name: 'score'},
            {data: 'data', name: 'data'},
        ],
        "iDisplayLength": 10,
        pageLength: 10,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                text: '<span class="datatable-btn-icon">📋</span> Copy',
                className: 'modern-tab beautiful-tab export-btn export-btn-copy',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'csvHtml5',
                text: '<span class="datatable-btn-icon">🗃️</span> CSV',
                className: 'modern-tab beautiful-tab export-btn export-btn-csv',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'excelHtml5',
                text: '<span class="datatable-btn-icon">📊</span> Excel',
                className: 'modern-tab beautiful-tab export-btn export-btn-excel',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'pdfHtml5',
                text: '<span class="datatable-btn-icon">📄</span> PDF',
                className: 'modern-tab beautiful-tab export-btn export-btn-pdf',
                exportOptions: { columns: ':visible' },
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                text: '<span class="datatable-btn-icon">🖨️</span> Print',
                className: 'modern-tab beautiful-tab export-btn export-btn-print',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'colvis',
                text: '<span class="datatable-btn-icon">🧩</span> Columns',
                className: 'modern-tab beautiful-tab export-btn export-btn-colvis',
                columns: ':not(:first-child)',
            }
        ],
        "aaSorting": [[1, "asc"]],
        "infoCallback": function(settings, start, end, max, total, pre) {
            return `\n                <div class=\"datatable-info-beautiful pinky-gradient\">\n                    <span class=\"datatable-info-icon\">💖</span>\n                    <span class=\"datatable-info-text\">\n                        Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries\n                    </span>\n                </div>\n            `;
        },
        "fnDrawCallback": function() {
            $('#coingecko_trendings tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
            highlightSearchResults();
        },
        "initComplete": function() {
            // Remove the default label element and text from DataTables search
            var $filter = $('#coingecko_trendings_filter');
            $filter.find('label').contents().filter(function() {
                return this.nodeType === 3 && this.nodeValue.trim().length > 0;
            }).remove();
            $filter.find('label').contents().unwrap(); // Remove the label but keep the input
            $filter.contents().filter(function() {
                return this.nodeType === 3 && this.nodeValue.trim().length > 0;
            }).remove();
            var $input = $filter.find('input[type="search"]');
            $input.attr('placeholder', 'Search...');
            $input.wrap('<div class="search-wrapper"></div>');
            $input.after('<button id="clear-search" type="button" tabindex="0">Clear</button>');
            $filter.css({width: '100%', 'max-width': '400px', 'margin-bottom': '0', float: 'none', display: 'flex', 'align-items': 'center', 'justify-content': 'flex-end', background: 'none', padding: 0});
            $filter.find('.search-wrapper').css({display: 'flex', 'align-items': 'center', width: '100%', position: 'relative'});

            // Conditionally add/remove search icon based on viewport (hide on mobile)
            var iconMarkup = '<span class="search-icon">\
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">\
                    <circle cx="11" cy="11" r="8" stroke="#ff6a88" stroke-width="2"/>\
                    <line x1="18" y1="18" x2="22" y2="22" stroke="#ff99ac" stroke-width="2" stroke-linecap="round"/>\
                </svg>\
            </span>';
            var mql = window.matchMedia('(max-width: 700px)');
            function applySearchIconState() {
                if (mql.matches) {
                    // Mobile: remove icon and use compact padding
                    $filter.find('.search-icon').remove();
                    $input.css({'padding-left': '16px', 'padding-right': '16px'});
                } else {
                    // Desktop: ensure icon exists and adjust padding
                    if (!$filter.find('.search-icon').length) {
                        $input.before(iconMarkup);
                    }
                    $filter.find('.search-icon').css({position: 'absolute', left: '16px', width: '22px', height: '22px', 'pointer-events': 'none', top: '50%', transform: 'translateY(-50%)'});
                    $input.css({'padding-left': '44px', 'padding-right': '44px'});
                }
            }
            applySearchIconState();
            if (mql.addEventListener) {
                mql.addEventListener('change', applySearchIconState);
            } else if (mql.addListener) {
                mql.addListener(applySearchIconState);
            }
            $filter.find('#clear-search').on('click', function() {
                $input.val('');
                $input.trigger('input');
                oTable.search('').draw();
            });

            // Move export buttons to custom container
            oTable.buttons().container().appendTo('#trendings-export-buttons');
            // Move search box to the right of export buttons
            $('#trendings-search-container').append($filter);
            // Style export buttons
            $('#trendings-export-buttons .export-btn').css({
                'margin-right': '0.5em',
                'margin-bottom': '0.5em',
                'border-radius': '2em',
                'font-weight': 600,
                'font-size': '1em',
                'box-shadow': '0 2px 8px 0 rgba(255,106,136,0.10)',
                'background': 'linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%)',
                'color': '#fff',
                'border': 'none',
                'padding': '0.5em 1.5em',
                'display': 'inline-flex',
                'align-items': 'center',
                'gap': '0.7em',
                'cursor': 'pointer',
                'transition': 'background 0.3s, color 0.3s, box-shadow 0.2s'
            });
            $('#trendings-export-buttons .export-btn:last-child').css({'margin-right': 0});
        }
    });
};

CoingeckoTrendings.prototype.bindEvents = function () {};

CoingeckoTrendings.prototype.reloadTable = function () {
    var oTable = $('#coingecko_trendings').DataTable();
    oTable.ajax.reload(null, false);
};

// === Image preview logic (copied and adapted from markets.js) ===
var $imgPreview = $('<div id="img-hover-preview"></div>').css({
    'position': 'fixed',
    'z-index': 9999,
    'display': 'none',
    'pointer-events': 'none',
    'box-shadow': '0 8px 32px rgba(0,0,0,0.18)',
    'border-radius': '16px',
    'background': '#fff',
    'padding': '12px',
    'border': '2px solid #e2e8f0',
    'transition': 'transform 0.15s cubic-bezier(.4,2,.6,1), opacity 0.15s',
    'opacity': 0
});
$('body').append($imgPreview);

$(document).on('mouseenter', '.previewable-img', function(e) {
    var src = $(this).attr('src');
    var alt = $(this).attr('alt') || '';
    $imgPreview.html('<img src="'+src+'" alt="'+alt+'" style="width:96px;height:96px;object-fit:contain;display:block;margin:auto;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.10);">');
    $imgPreview.css({
        'display': 'block',
        'opacity': 1,
        'transform': 'scale(1.08)'
    });
});
$(document).on('mousemove', '.previewable-img', function(e) {
    var previewWidth = $imgPreview.outerWidth();
    var previewHeight = $imgPreview.outerHeight();
    var left = e.clientX + 24;
    var top = e.clientY - previewHeight/2;
    // Prevent overflow
    var maxLeft = $(window).width() - previewWidth - 16;
    var maxTop = $(window).height() - previewHeight - 16;
    if(left > maxLeft) left = maxLeft;
    if(top < 8) top = 8;
    if(top > maxTop) top = maxTop;
    $imgPreview.css({ left: left, top: top });
});
$(document).on('mouseleave', '.previewable-img', function() {
    $imgPreview.css({
        'display': 'none',
        'opacity': 0,
        'transform': 'scale(0.98)'
    });
});

$(document).ready(function() {
    var coins = new CoingeckoTrendings();
    coins.init();
    coins.bindEvents();
    // Add refresh button handler
    $('#refreshTable').on('click', function() {
        var $btn = $(this);
        $btn.attr('aria-busy', 'true');
        $btn.find('.refresh-spinner').show();
        coins.reloadTable();
        setTimeout(function() {
            $btn.attr('aria-busy', 'false');
            $btn.find('.refresh-spinner').hide();
        }, 1000); // Hide spinner after 1s or after reload
    });
    // Hide spinner initially
    $('#refreshTable .refresh-spinner').hide();
});

// ======================== Highlight Search Results ========================
function highlightSearchResults() {
    var table = $('#coingecko_trendings').DataTable();
    var searchTerm = table.search();
    if (!searchTerm) {
        $('#coingecko_trendings tbody td').each(function() {
            $(this).html($(this).text());
        });
        return;
    }
    var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')+')', 'gi');
    $('#coingecko_trendings tbody tr').each(function() {
        var row = $(this);
        var found = false;
        row.find('td').each(function(idx) {
            var cell = $(this);
            var original = cell.text();
            // Skip highlighting for image column (index 1)
            if (idx === 1) {
                cell.html(original);
                return;
            }
            if (searchTerm && original.match(regex)) {
                var newHtml = original.replace(regex, '<span class="highlight">$1</span>');
                cell.html(newHtml);
                found = true;
            } else {
                cell.html(original);
            }
        });
        if (found) {
            row.addClass('highlight-row');
        } else {
            row.removeClass('highlight-row');
        }
    });
}
