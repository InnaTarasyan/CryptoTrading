"use strict";
function CoingeckoExchangeRates(){}

CoingeckoExchangeRates.prototype.init = function () {
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
        "fnDrawCallback": function() {
            $('#coingecko_exchange_rates tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
        },
        "infoCallback": function(settings, start, end, max, total, pre) {
            return `\n                <div class=\"datatable-info-beautiful pinky-gradient\">\n                    <span class=\"datatable-info-icon\">💖</span>\n                    <span class=\"datatable-info-text\">\n                        Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries\n                    </span>\n                </div>\n            `;
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
        var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\]/g, '\\$&')+')', 'gi');
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
    });
};

CoingeckoExchangeRates.prototype.bindEvents = function () {};

$(document).ready(function() {
    var coins = new CoingeckoExchangeRates();
    coins.init();
    coins.bindEvents();
});
