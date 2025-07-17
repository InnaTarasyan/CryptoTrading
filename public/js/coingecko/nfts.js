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
        }
    });

    // Replace default DataTables filter with custom search bar (icon inside input, improved CSS)
    const filter = $('.dataTables_filter');
    const customSearch = `
        <style>
            .nfts-search-wrapper {
                position: relative;
                display: flex;
                align-items: center;
                max-width: 340px;
                margin: 0 auto 1em auto;
                background: #fff;
                border-radius: 2em;
                box-shadow: 0 2px 12px rgba(255,106,136,0.07), 0 1.5px 6px rgba(255,153,172,0.08);
                padding: 0.2em 0.5em 0.2em 0.2em;
                transition: box-shadow 0.2s;
            }
            .nfts-search-wrapper:focus-within {
                box-shadow: 0 0 0 2px #ff6a88, 0 2px 12px rgba(255,106,136,0.10);
            }
            .nfts-search-input {
                border: none;
                outline: none;
                background: transparent;
                padding-left: 2.2em;
                padding-right: 0.5em;
                font-size: 1.08em;
                height: 2.2em;
                border-radius: 2em;
                width: 100%;
                min-width: 120px;
                color: #333;
                transition: background 0.2s;
            }
            .nfts-search-input::placeholder {
                color: #b0b0b0;
                opacity: 1;
            }
            .nfts-search-icon {
                position: absolute;
                left: 0.9em;
                top: 50%;
                transform: translateY(-50%);
                width: 1.1em;
                height: 1.1em;
                pointer-events: none;
                color: #ff6a88;
                opacity: 0.85;
            }
            .nfts-clear-search {
                background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);
                color: #fff;
                border: none;
                border-radius: 1.5em;
                padding: 0.3em 1.1em;
                margin-left: 0.5em;
                font-size: 1em;
                font-weight: 500;
                cursor: pointer;
                transition: background 0.2s, color 0.2s, box-shadow 0.2s;
                box-shadow: 0 1px 4px rgba(255,106,136,0.08);
            }
            .nfts-clear-search:hover, .nfts-clear-search:focus {
                background: linear-gradient(90deg, #ff99ac 0%, #ff6a88 100%);
                color: #fff;
                outline: none;
            }
            @media (max-width: 600px) {
                .nfts-search-wrapper { max-width: 100%; }
                .nfts-search-input { font-size: 1em; }
            }
        </style>
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
