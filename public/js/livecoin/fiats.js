"use strict";
function Fiats(){

}

Fiats.prototype.init = function () {
    var oTable = $('#livecoin_fiats').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#livecoin_fiats_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'countries', name: 'countries'},
            {data: 'flag', name: 'flag'},
        ],
        "iDisplayLength": 20,
        pageLength: 10,
        "aaSorting": [[1, "asc"]],
        "createdRow": function(row, data, dataIndex) {
            var labels = ['Fiat', 'Flag', 'Countries'];
            $('td', row).each(function(index) {
                $(this).attr('data-label', labels[index]);
            });
        },
        "fnDrawCallback": function() {
            $('#livecoin_fiats tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
        },
        infoCallback: function(settings, start, end, max, total, pre) {
            return `\n            <div class=\"datatable-info-beautiful\">\n                <span class=\"datatable-info-icon\">💱</span>\n                <span class=\"datatable-info-text\">\n                    Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries\n                </span>\n            </div>\n        `;
        }
    });
    // Add custom search bar after DataTable initialization
    replaceCustomSearchBar(oTable);
};

Fiats.prototype.bindEvents = function () {

};

// Replace default DataTables filter with custom search bar (copied/adapted from history.js)
function replaceCustomSearchBar(table) {
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="search-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#f7971e" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#f7971e" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" class="form-control" placeholder="Search fiats..." aria-controls="livecoin_fiats" style="padding-left:44px;" />
            <button id="clear-search" class="ml-2" type="button">Clear</button>
        </div>
    `;
    filter.html(customSearch);

    // Bind search input
    const searchBox = filter.find('input[type="search"]');
    searchBox.on('input', function() {
        table.search(searchBox.val()).draw();
    });

    // Bind clear button
    filter.on('click', '#clear-search', function() {
        searchBox.val('');
        table.search('').draw();
    });
}

$(document).ready(function() {
    var coins = new Fiats();
    coins.init();
    coins.bindEvents();
});
