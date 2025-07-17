"use strict";
function Nfts(){}

Nfts.prototype.init = function () {
    var columnLabels = [
        'Name',
        'Asset Platform ID'
    ];
    var oTable = $('#coingecko_nfts').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_nfts_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'asset_platform_id', name: 'asset_platform_id'},
        ],
        "iDisplayLength": 20,
        pageLength: 10,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_nfts tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
        },
        "infoCallback": function(settings, start, end, max, total, pre) {
            return `\n                <div class=\"datatable-info-beautiful pinky-gradient\">\n                    <span class=\"datatable-info-icon\">💖</span>\n                    <span class=\"datatable-info-text\">\n                        Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries\n                    </span>\n                </div>\n            `;
        },
        "createdRow": function(row, data, dataIndex) {
            $(row).find('td').each(function(idx) {
                $(this).attr('data-label', columnLabels[idx]);
            });
        },
        // Add export buttons
        dom: '<"dt-buttons"B>frtip',
        buttons: [
            {
                extend: 'copyHtml5',
                text: 'Copy',
                className: 'btn-copy'
            },
            {
                extend: 'excelHtml5',
                text: 'Excel',
                className: 'btn-excel'
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                className: 'btn-csv'
            },
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                className: 'btn-pdf'
            },
            {
                extend: 'print',
                text: 'Print',
                className: 'btn-print'
            }
        ],
        responsive: true
    });

    // Replace default DataTables filter with custom search bar (icon inside input, improved CSS)
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="nfts-search-wrapper">
            <input type="search" class="nfts-search-input" placeholder="Search NFTs..." aria-controls="coingecko_nfts" />
            <svg class="nfts-search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#ff6a88" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#ff6a88" stroke-width="2" stroke-linecap="round"/></svg>
            <button id="clear-search" class="nfts-clear-search" type="button">Clear</button>
        </div>
    `;
    filter.html(customSearch);

    // Bind search input
    const searchBox = filter.find('input[type="search"]');
    searchBox.on('input', function() {
        oTable.search(searchBox.val()).draw();
    });

    // Bind clear button
    filter.on('click', '#clear-search', function() {
        searchBox.val('');
        oTable.search('').draw();
    });

    // ======================== Highlight Search Results ========================
    function highlightSearchResults() {
        var table = $('#coingecko_nfts').DataTable();
        var searchTerm = table.search();
        if (!searchTerm) {
            $('#coingecko_nfts tbody td').each(function() {
                $(this).html($(this).text());
            });
            return;
        }
        var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\\]/g, '\\$&')+')', 'gi');
        $('#coingecko_nfts tbody tr').each(function() {
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
    oTable.on('draw', highlightSearchResults);
    searchBox.on('input', highlightSearchResults);
};

Nfts.prototype.bindEvents = function () {};

$(document).ready(function() {
    var coins = new Nfts();
    coins.init();
    coins.bindEvents();
});
