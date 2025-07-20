"use strict";
function Derivatives(){

}

Derivatives.prototype.init = function () {
    var oTable = $('#coingecko_derivatives').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_derivatives_route').val(),
        "columns": [
            {data: 'market', name: 'market'},
            {data: 'index_id', name: 'index_id'},
            {data: 'price', name: 'price'},
            {data: 'price_percentage_change_24h', name: 'price_percentage_change_24h'},
            {data: 'contract_type', name: 'contract_type'},
            {data: 'index', name: 'index'},
            {data: 'basis', name: 'basis'},
            {data: 'spread', name: 'spread'},
            {data: 'funding_rate', name: 'funding_rate'},
            {data: 'open_interest', name: 'open_interest'},
            {data: 'volume_24h', name: 'volume_24h'},
            {data: 'last_traded_at', name: 'last_traded_at'},
            {data: 'expired_at', name: 'expired_at'},
        ],
        "iDisplayLength": 20,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_derivatives tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
        }
    });

    // Replace default DataTables filter with custom search bar (pink gradient)
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="search-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#ff6a88" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#ff6a88" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" class="form-control" placeholder="Search derivatives..." aria-controls="coingecko_derivatives" style="padding-left:44px;" />
            <button id="clear-search" class="ml-2" type="button">Clear</button>
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
        var table = $('#coingecko_derivatives').DataTable();
        var searchTerm = table.search();
        if (!searchTerm) {
            $('#coingecko_derivatives tbody td').each(function() {
                $(this).html($(this).text());
            });
            return;
        }
        var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\]/g, '\\$&')+')', 'gi');
        $('#coingecko_derivatives tbody tr').each(function() {
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
    filter.on('click', '#clear-search', highlightSearchResults);
};

Derivatives.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new Derivatives();
    coins.init();
    coins.bindEvents();
});
