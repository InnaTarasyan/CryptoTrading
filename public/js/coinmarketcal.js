// Enhanced CoinMarketCal DataTable Script
// Author: Inna Tarasyan
// Description: Handles initialization and UI enhancements for the CoinMarketCal events table.

'use strict';

class CoinMarketCalTable {
    constructor() {
        this.tableSelector = '#coinmarketcal';
        this.routeSelector = '#coinmarketcal_route';
        this.table = null;
    }

    /**
     * Initialize the DataTable and custom UI components
     */
    init() {
        this.initDataTable();
        this.replaceDefaultFilter();
        this.bindCustomSearchEvents();
        this.bindRowClick();
        this.bindHighlightOnDraw();
    }

    /**
     * Initialize DataTable with server-side processing and custom callbacks
     */
    initDataTable() {
        this.table = $(this.tableSelector).DataTable({
            processing: true,
            bSort: false,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            ajax: $(this.routeSelector).val(),
            columns: [
                { data: 'symbol', name: 'symbol' },
                { data: 'name', name: 'name' },
                { data: 'rank', name: 'rank' },
                { data: 'fullname', name: 'fullname' },
            ],
            iDisplayLength: 20,
            infoCallback: this.infoCallback,
            fnDrawCallback: () => this.bindRowClick(), // Rebind row click after redraw
        });
    }

    /**
     * Custom info callback for DataTable footer
     */
    infoCallback(settings, start, end, max, total, pre) {
        return `
            <div class="datatable-info-beautiful">
                <span class="datatable-info-icon">📊</span>
                <span class="datatable-info-text">
                    Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries
                </span>
            </div>
        `;
    }

    /**
     * Replace the default DataTables filter with a custom search block
     */
    replaceDefaultFilter() {
        const filter = $('.dataTables_filter');
        const customSearch = `
            <div class="search-wrapper">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#f7971e" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#f7971e" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="search" class="form-control" placeholder="Search coins..." aria-controls="coinmarketcal" style="padding-left:44px;" />
                <button id="clear-search" class="ml-2" type="button">Clear</button>
            </div>
        `;
        filter.html(customSearch);
    }

    /**
     * Bind custom search input and clear button events
     */
    bindCustomSearchEvents() {
        const filter = $('.dataTables_filter');
        const searchBox = filter.find('input[type="search"]');
        // Sync DataTables search with custom input
        searchBox.on('input', () => {
            this.table.search(searchBox.val()).draw();
        });
        // Clear button
        filter.on('click', '#clear-search', () => {
            searchBox.val('');
            this.table.search('').draw();
        });
    }

    /**
     * Bind click event to table rows for navigation
     */
    bindRowClick() {
        $(this.tableSelector + ' tbody tr').off('click').on('click', function () {
            var coin = $(this).find('.id').val();
            if (coin) {
                window.location.href = `/details/${coin}`;
            }
        });
    }

    /**
     * Highlight search terms in the table after each draw
     */
    bindHighlightOnDraw() {
        this.table.on('draw', () => {
            const body = $(this.table.table().body());
            body.unhighlight();
            const searchTerm = this.table.search();
            if (searchTerm) {
                body.highlight(searchTerm);
            }
        });
    }
}

// Initialize on document ready
$(document).ready(() => {
    const coinMarketCalTable = new CoinMarketCalTable();
    coinMarketCalTable.init();
});
