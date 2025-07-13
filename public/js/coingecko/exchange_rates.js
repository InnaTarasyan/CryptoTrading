"use strict";
function CoingeckoExchangeRates(){}

CoingeckoExchangeRates.prototype.init = function () {
    // Column labels for data-label attributes (must match table header order)
    var columnLabels = [
        'Symbol',
        'Name',
        'Unit',
        'Value',
        'Type'
    ];
    var oTable = $('#coingecko_exchange_rates').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_exchange_rates_route').val(),
        "columns": [
            {data: 'symbol', name: 'symbol'},
            {data: 'name', name: 'name'},
            {data: 'unit', name: 'unit'},
            {data: 'value', name: 'value'},
            {data: 'type', name: 'type'},
        ],
        "iDisplayLength": 20,
        pageLength: 10,
        "aaSorting": [[1, "asc"]],
        "dom": "<'datatable-toolbar'B>lfrtip",
        "buttons": [
            {
                extend: 'copy',
                className: 'datatable-btn',
                text: '<span class="datatable-btn-icon"><svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="7" y="7" width="10" height="14" rx="2" fill="#ffd200"/><rect x="3" y="3" width="10" height="14" rx="2" fill="#43cea2"/></svg></span> <span>Copy</span>'
            },
            {
                extend: 'csv',
                className: 'datatable-btn',
                text: '<span class="datatable-btn-icon"><svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4" fill="#43cea2"/><text x="12" y="17" text-anchor="middle" font-size="10" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">CSV</text></svg></span> <span>CSV</span>'
            },
            {
                extend: 'excel',
                className: 'datatable-btn',
                text: '<span class="datatable-btn-icon"><svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4" fill="#11998e"/><text x="12" y="17" text-anchor="middle" font-size="10" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">XLS</text></svg></span> <span>Excel</span>'
            },
            {
                extend: 'pdf',
                className: 'datatable-btn',
                text: '<span class="datatable-btn-icon"><svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4" fill="#ff512f"/><text x="12" y="17" text-anchor="middle" font-size="10" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">PDF</text></svg></span> <span>PDF</span>'
            },
            {
                extend: 'print',
                className: 'datatable-btn',
                text: '<span class="datatable-btn-icon"><svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="10" rx="2" fill="#ffd200"/><rect x="7" y="3" width="10" height="4" rx="1" fill="#43cea2"/></svg></span> <span>Print</span>'
            },
            {
                extend: 'colvis',
                className: 'datatable-btn',
                text: '<span class="datatable-btn-icon"><svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4" fill="#6a11cb"/><rect x="7" y="7" width="10" height="2" fill="#fff"/><rect x="7" y="11" width="10" height="2" fill="#fff"/><rect x="7" y="15" width="10" height="2" fill="#fff"/></svg></span> <span>Columns</span>'
            }
        ],
        "responsive": true,
        "fnDrawCallback": function() {
            $('#coingecko_exchange_rates tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
        },
        "infoCallback": function(settings, start, end, max, total, pre) {
            return `\n                <div class=\"datatable-info-beautiful pinky-gradient\">\n                    <span class=\"datatable-info-icon\">💖</span>\n                    <span class=\"datatable-info-text\">\n                        Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries\n                    </span>\n                </div>\n            `;
        },
        "createdRow": function(row, data, dataIndex) {
            // Set data-label for each cell
            $(row).find('td').each(function(idx) {
                $(this).attr('data-label', columnLabels[idx]);
                if(idx === 0) {
                    $(this).addClass('datatable-highlight-first');
                }
            });
        }
    });

    // Replace default DataTables filter with custom search bar (pink gradient)
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="search-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#ff6a88" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#ff6a88" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" class="form-control" placeholder="Search exchange rates..." aria-controls="coingecko_exchange_rates" style="padding-left:44px;" />
            <button id="clear-search" class="ml-2" type="button">Clear</button>
        </div>
    `;
    filter.html(customSearch);

    // Bind search input
    const searchBox = filter.find('input[type="search"]');
    searchBox.on('input', function() {
        oTable.search(searchBox.val()).draw();
        highlightSearchResults();
    });

    // Bind clear button
    filter.on('click', '#clear-search', function() {
        searchBox.val('');
        oTable.search('').draw();
        highlightSearchResults();
    });

    // ======================== Highlight Search Results ========================
    function highlightSearchResults() {
        var table = $('#coingecko_exchange_rates').DataTable();
        var searchTerm = table.search();
        if (!searchTerm) {
            $('#coingecko_exchange_rates tbody td').each(function() {
                $(this).html($(this).text());
            });
            return;
        }
        var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\\]/g, '\\$&')+')', 'gi');
        $('#coingecko_exchange_rates tbody tr').each(function() {
            var row = $(this);
            var found = false;
            row.find('td').each(function(idx) {
                var cell = $(this);
                var original = cell.text();
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

    // Add highlight on table draw
    oTable.on('draw', function() {
        highlightSearchResults();
        hideTheadOnMobile();
    });

    // Hide thead on mobile after DataTables draw (in case DataTables overrides CSS)
    function hideTheadOnMobile() {
        if (window.innerWidth <= 767) {
            $('.enhanced-thead').css('display', 'none');
        } else {
            $('.enhanced-thead').css('display', '');
        }
    }
    hideTheadOnMobile();
    $(window).on('resize', hideTheadOnMobile);
};

CoingeckoExchangeRates.prototype.bindEvents = function () {};

$(document).ready(function() {
    var coins = new CoingeckoExchangeRates();
    coins.init();
    coins.bindEvents();
});
