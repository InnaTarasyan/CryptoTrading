// Enhanced CoinMarketCal DataTable Script
// Author: Inna Tarasyan
// Description: Handles initialization and UI enhancements for the CoinMarketCal events table.

'use strict';

class CoinMarketCalTable {
    constructor() {
        this.tableSelector = '#coinmarketcal';
        this.routeSelector = '#coinmarketcal_route';
        this.table = null;
        this.isMobile = window.innerWidth <= 768;
        this.isTablet = window.innerWidth > 768 && window.innerWidth <= 1024;
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
        this.bindMobileOptimizations();
        this.bindWindowResize();
    }

    /**
     * Set data-label attributes for mobile responsiveness
     */
    setDataLabels() {
        $(this.tableSelector + ' tbody tr').each(function() {
            $(this).find('td:eq(0)').attr('data-label', 'Symbol');
            $(this).find('td:eq(1)').attr('data-label', 'Name');
            $(this).find('td:eq(2)').attr('data-label', 'Rank');
            $(this).find('td:eq(3)').attr('data-label', 'Fullname');
        });
    }

    /**
     * Initialize DataTable with server-side processing and custom callbacks
     */
    initDataTable() {
        const mobileConfig = {
            pageLength: this.isMobile ? 8 : 10,
            lengthMenu: this.isMobile ? [[5, 8, 10, -1], [5, 8, 10, "All"]] : [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: this.isMobile ? '<"top"lf>rt<"bottom"ip>' : '<"top"lf>rt<"bottom"ip>'
        };

        this.table = $(this.tableSelector).DataTable({
            processing: true,
            bSort: false,
            serverSide: true,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return '<h3>Details for ' + data.symbol + '</h3>';
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table table-bordered table-striped'
                    })
                }
            },
            ...mobileConfig,
            ajax: $(this.routeSelector).val(),
            columns: [
                { data: 'symbol', name: 'symbol' },
                { data: 'name', name: 'name' },
                { data: 'rank', name: 'rank' },
                { data: 'fullname', name: 'fullname' },
            ],
            fnCreatedRow: function(row, data, dataIndex) {
                // Set data-label attributes for mobile responsiveness
                $(row).find('td:eq(0)').attr('data-label', 'Symbol');
                $(row).find('td:eq(1)').attr('data-label', 'Name');
                $(row).find('td:eq(2)').attr('data-label', 'Rank');
                $(row).find('td:eq(3)').attr('data-label', 'Fullname');
            },
            iDisplayLength: this.isMobile ? 15 : 20,
            infoCallback: this.infoCallback,
            fnDrawCallback: () => {
                this.bindRowClick(); // Rebind row click after redraw
                this.setDataLabels(); // Set data labels after redraw
            },
            initComplete: () => this.onTableInitComplete()
        });
    }

    /**
     * Handle table initialization completion
     */
    onTableInitComplete() {
        this.adjustColumnsForDevice();
        this.setDataLabels(); // Set data labels after initialization
        
        if (this.isMobile) {
            // Mobile-specific optimizations
            this.optimizeForMobile();
        }
    }

    /**
     * Adjust columns based on device type
     */
    adjustColumnsForDevice() {
        if (this.isMobile) {
            // Hide length selector on mobile for simplicity
            $('.dataTables_length').hide();
        } else {
            $('.dataTables_length').show();
        }
    }

    /**
     * Optimize table for mobile devices
     */
    optimizeForMobile() {
        // Mobile-specific table optimizations
        $(this.tableSelector).css({
            'touch-action': 'pan-x',
            'user-select': 'none',
            '-webkit-user-select': 'none'
        });

        // Add touch-friendly interactions
        $(this.tableSelector + ' tbody tr').css({
            'cursor': 'pointer',
            'min-height': '44px' // Touch-friendly row height
        });

        // Ensure proper mobile layout
        setTimeout(() => {
            if (this.table) {
                this.table.columns.adjust().draw();
            }
        }, 100);
    }

    /**
     * Bind mobile-specific optimizations
     */
    bindMobileOptimizations() {
        if (this.isMobile) {
            // Mobile-specific event handling
            $(this.tableSelector + ' tbody tr').on('touchstart', function(e) {
                // Prevent multiple touch events
                if (e.touches.length > 1) {
                    e.preventDefault();
                }
            });

            // Mobile-friendly row highlighting
            $(this.tableSelector + ' tbody tr').on('touchstart', function() {
                $(this).addClass('mobile-touch-active');
            }).on('touchend', function() {
                setTimeout(() => {
                    $(this).removeClass('mobile-touch-active');
                }, 150);
            });
        }
    }

    /**
     * Bind window resize events
     */
    bindWindowResize() {
        let resizeTimer;
        $(window).on('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                const newIsMobile = window.innerWidth <= 768;
                const newIsTablet = window.innerWidth > 768 && window.innerWidth <= 1024;
                
                if (newIsMobile !== this.isMobile || newIsTablet !== this.isTablet) {
                    this.isMobile = newIsMobile;
                    this.isTablet = newIsTablet;
                    this.adjustColumnsForDevice();
                    
                    if (this.table) {
                        this.table.columns.adjust().draw();
                    }
                }
            }, 250);
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
                <input type="search" class="form-control" placeholder="Search coins..." aria-controls="coinmarketcal" style="padding-left:50px;" />
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

        // Mobile-specific search optimizations
        if (this.isMobile) {
            searchBox.attr('autocomplete', 'off');
            searchBox.attr('type', 'search');
            
            // Prevent zoom on iOS
            searchBox.css('font-size', '16px');
            
            // Ensure proper mobile styling
            $('.search-wrapper').css({
                'width': '100%',
                'max-width': '100%'
            });
            
            $('.search-wrapper input').css({
                'width': '100%',
                'max-width': '100%',
                'font-size': '16px',
                'padding': '12px 16px 12px 50px'
            });
            
            $('.search-wrapper button').css({
                'width': '100%',
                'max-width': '100%',
                'font-size': '16px',
                'padding': '12px 16px'
            });
        }
    }

    /**
     * Bind click event to table rows for navigation
     */
    bindRowClick() {
        return;

        const self = this;
        $(this.tableSelector + ' tbody tr').off('click').on('click', function (e) {
            // Check if the clicked element is inside the first td
            if ($(e.target).closest('td').index() === 0) {
                return; // Do nothing if it's the first column
            }

            const coin = $(this).find('.id').val();
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
