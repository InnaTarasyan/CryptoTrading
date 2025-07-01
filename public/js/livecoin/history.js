"use strict";
function LiveCoin(){
    this.currentColumnGroup = 0;
    this.columnsPerGroup = 5; // Additional columns to show (excluding code column)
    this.totalColumns = 13;
    this.totalGroups = Math.ceil((this.totalColumns - 1) / this.columnsPerGroup); // -1 because code column is always visible
}

// Helper to format big numbers with abbreviations (K, M, B) and thousands separators
function formatBigNumber(num) {
    if (num === null || num === undefined || num === "") return '';
    let n = Number(num);
    if (isNaN(n)) return num;
    if (Math.abs(n) >= 1e12) return (n / 1e12).toFixed(2) + 'T';
    if (Math.abs(n) >= 1e9) return (n / 1e9).toFixed(2) + 'B';
    if (Math.abs(n) >= 1e6) return (n / 1e6).toFixed(2) + 'M';
    if (Math.abs(n) >= 1e3) return n.toLocaleString();
    return n.toString();
}

LiveCoin.prototype.init = function () {
    var self = this;
    var oTable = $('#livecoin_history').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#livecoin_history_route').val(),
        "columns": [
            {data: 'code', name: 'code'},
            {data: 'png64', name: 'png64'},
            {data: 'rate', name: 'rate', render: function(data){ return formatBigNumber(data); }},
            {data: 'age', name: 'age'},
            {data: 'pairs', name: 'pairs', render: function(data){ return formatBigNumber(data); }},
            {data: 'volume', name: 'volume', render: function(data){ return formatBigNumber(data); }},
            {data: 'cap', name: 'cap', render: function(data){ return formatBigNumber(data); }},
            {data: 'rank', name: 'rank', render: function(data){ return formatBigNumber(data); }},
            {data: 'markets', name: 'markets', render: function(data){ return formatBigNumber(data); }},
            {data: 'totalSupply', name: 'totalSupply', render: function(data){ return formatBigNumber(data); }},
            {data: 'maxSupply', name: 'maxSupply', render: function(data){ return formatBigNumber(data); }},
            {data: 'circulatingSupply', name: 'circulatingSupply', render: function(data){ return formatBigNumber(data); }},
            {data: 'allTimeHighUSD', name: 'allTimeHighUSD', render: function(data){ return formatBigNumber(data); }},
            {data: 'categories', name: 'categories'},
        ],
        "iDisplayLength": 20,
        pageLength: 10,
        "aaSorting": [[3, "desc"]],
        responsive: true,
        dom: "<'datatable-toolbar'B>lfrtip",
        buttons: [
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
        fixedHeader: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search coins, markets, etc...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries"
        },
        "createdRow": function(row, data, dataIndex) {
            var labels = [
                'Code', 'Image', 'Rate', 'Age', 'Pairs', 'Volume', 'Cap', 'Rank',
                'Markets', 'Total Supply', 'Max Supply', 'Circulating Supply', 'All Time High USD', 'Categories'
            ];
            $('td', row).each(function(index) {
                $(this).attr('data-label', labels[index]);
            });
        },
        "fnDrawCallback": function() {
            $('#livecoin_history tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
            
            // Add error handling for images
            $('#livecoin_history tbody td:nth-child(2) img').on('error', function() {
                var $img = $(this);
                var $td = $img.closest('td');
                $img.hide();
                $td.html('<div style="width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #64748b; margin: 0 auto;">🪙</div>');
            });
            
            highlightSearchResults();
            self.updateColumnVisibility();
            // Add row highlight on hover
            $('#livecoin_history tbody tr').on('mouseenter', function () {
                $(this).addClass('table-row-hover');
            }).on('mouseleave', function () {
                $(this).removeClass('table-row-hover');
            });
        },
        "fnInitComplete": function() {
            self.updateColumnVisibility();
            self.bindColumnNavigation();
        },
        infoCallback: function(settings, start, end, max, total, pre) {
            return `\n            <div class=\"datatable-info-beautiful\">\n                <span class=\"datatable-info-icon\">📊</span>\n                <span class=\"datatable-info-text\">\n                    Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries\n                </span>\n            </div>\n        `;
        }
    });
    
    this.table = oTable;
    
    // Replace default DataTables filter with custom search bar
    replaceCustomSearchBar(this.table);
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            $('.dataTables_filter input[type="search"]').focus();
        }
    });

    // Enhanced search experience
    $('.dataTables_filter input[type="search"]').on('input', function() {
        var $input = $(this);
        var searchTerm = $input.val();
        
        if (searchTerm.length > 0) {
            $('.dataTables_filter').addClass('searching');
        } else {
            $('.dataTables_filter').removeClass('searching');
        }
    });

    // Remove searching class when search is complete
    this.table.on('search.dt', function() {
        $('.dataTables_filter').removeClass('searching');
    });

    // Loading spinner logic
    $('#livecoin_history').on('processing.dt', function (e, settings, processing) {
        $('#datatableLoading').css('display', processing ? 'block' : 'none');
    });
};

LiveCoin.prototype.updateColumnVisibility = function() {
    var self = this;
    var startCol = this.currentColumnGroup * this.columnsPerGroup + 1; // +1 because we start after code column
    var endCol = Math.min(startCol + this.columnsPerGroup, this.totalColumns);
    
    // Add loading state
    $('#livecoin_history').addClass('updating');
    
    // Hide all columns first
    for (var i = 0; i < this.totalColumns; i++) {
        this.table.column(i).visible(false);
    }
    
    // Always show the code column (first column)
    this.table.column(0).visible(true);
    
    // Show the current group of additional columns
    for (var i = startCol; i < endCol; i++) {
        this.table.column(i).visible(true);
    }
    
    // Update the column range indicator to show total visible columns
    var visibleColumns = 1 + (endCol - startCol); // code column + additional columns
    $('#column-range').text('1-' + visibleColumns);
    
    // Update navigation buttons
    $('#prev-columns').prop('disabled', this.currentColumnGroup === 0);
    $('#next-columns').prop('disabled', this.currentColumnGroup >= this.totalGroups - 1);
    
    // Remove loading state after a short delay
    setTimeout(function() {
        $('#livecoin_history').removeClass('updating');
    }, 300);
    
    // Add visual feedback for the current group
    $('.column-indicator').addClass('pulse');
    setTimeout(function() {
        $('.column-indicator').removeClass('pulse');
    }, 500);
};

LiveCoin.prototype.bindColumnNavigation = function() {
    var self = this;
    
    $('#prev-columns').on('click', function() {
        if (self.currentColumnGroup > 0) {
            self.currentColumnGroup--;
            self.updateColumnVisibility();
            self.table.draw();
        }
    });
    
    $('#next-columns').on('click', function() {
        if (self.currentColumnGroup < self.totalGroups - 1) {
            self.currentColumnGroup++;
            self.updateColumnVisibility();
            self.table.draw();
        }
    });
    
    // Add keyboard navigation
    $(document).on('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            if (e.keyCode === 37) { // Left arrow
                e.preventDefault();
                $('#prev-columns').click();
            } else if (e.keyCode === 39) { // Right arrow
                e.preventDefault();
                $('#next-columns').click();
            }
        }
    });
};

LiveCoin.prototype.bindEvents = function () {
    // Add search results counter
    var self = this;
    this.table.on('search.dt', function() {
        var searchTerm = self.table.search();
        var info = self.table.page.info();
        var totalRecords = info.recordsTotal;
        var filteredRecords = info.recordsDisplay;
        
        if (searchTerm && filteredRecords !== totalRecords) {
            if (!$('.search-results-info').length) {
                $('.dataTables_filter').after('<div class="search-results-info">Showing ' + filteredRecords + ' of ' + totalRecords + ' results for "' + searchTerm + '"</div>');
            } else {
                $('.search-results-info').text('Showing ' + filteredRecords + ' of ' + totalRecords + ' results for "' + searchTerm + '"');
            }
            $('.search-results-info').addClass('show');
        } else {
            $('.search-results-info').removeClass('show');
        }
    });
};

$(document).ready(function() {
    var coins = new LiveCoin();
    coins.init();
    coins.bindEvents();

    // Image preview logic
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

    // Add refresh button handler
    $('#refreshTable').on('click', function() {
        if (coins.table) {
            coins.table.ajax.reload(null, false); // false = keep current page
        }
    });

    // ======================== Fullscreen Button Logic ========================
    const fullscreenBtn = $('#fullscreenToggle');
    const fullscreenIcon = fullscreenBtn.find('.icon-fullscreen');
    const exitFullscreenIcon = fullscreenBtn.find('.icon-exit-fullscreen');
    const fullscreenText = $('#fullscreenText');
    const fullscreenContainer = document.getElementById('datatableFullscreenContainer');

    function isFullscreen() {
        return document.fullscreenElement === fullscreenContainer;
    }

    function enterFullscreen() {
        if (fullscreenContainer.requestFullscreen) {
            fullscreenContainer.requestFullscreen();
            fullscreenContainer.classList.add('datatable-fullscreen');
        }
    }

    function exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
            fullscreenContainer.classList.remove('datatable-fullscreen');
        }
    }

    fullscreenBtn.on('click', function() {
        if (!isFullscreen()) {
            enterFullscreen();
        } else {
            exitFullscreen();
        }
    });

    document.addEventListener('fullscreenchange', function() {
        if (isFullscreen()) {
            fullscreenIcon.hide();
            exitFullscreenIcon.show();
            fullscreenText.text('Exit Fullscreen');
            fullscreenBtn.attr('aria-pressed', 'true');
            fullscreenContainer.classList.add('datatable-fullscreen');
        } else {
            fullscreenIcon.show();
            exitFullscreenIcon.hide();
            fullscreenText.text('Fullscreen');
            fullscreenBtn.attr('aria-pressed', 'false');
            fullscreenContainer.classList.remove('datatable-fullscreen');
        }
        if (window.coins && window.coins.table) {
            setTimeout(function() {
                window.coins.table.columns.adjust().draw(false);
            }, 200);
        }
    });
    // Initialize icon state
    exitFullscreenIcon.hide();

    // ======================== Dark Mode Button Logic ========================
    const darkModeBtn = $('#darkModeToggle');
    const darkModeIcon = $('#darkModeIcon');
    const darkModeText = $('#darkModeText');
    const body = $('body');

    function setDarkMode(enabled) {
        if (enabled) {
            body.addClass('dark-mode');
            darkModeBtn.attr('aria-checked', 'true');
            darkModeText.text('Light Mode');
        } else {
            body.removeClass('dark-mode');
            darkModeBtn.attr('aria-checked', 'false');
            darkModeText.text('Dark Mode');
        }
    }

    // Optionally, persist dark mode in localStorage
    const darkModePref = localStorage.getItem('darkMode') === 'true';
    setDarkMode(darkModePref);

    darkModeBtn.on('click', function() {
        const enabled = !body.hasClass('dark-mode');
        setDarkMode(enabled);
        localStorage.setItem('darkMode', enabled);
    });
});
function highlightSearchResults() {
    var table = $('#livecoin_history').DataTable();
    var searchTerm = table.search();
    if (!searchTerm) {
        $('#livecoin_history tbody td').each(function() {
            $(this).html($(this).text());
        });
        return;
    }
    var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\]/g, '\\$&')+')', 'gi');
    $('#livecoin_history tbody tr').each(function() {
        var row = $(this);
        var found = false;
        row.find('td').each(function(idx) {
            var cell = $(this);
            var original = cell.text();
            // Skip highlighting for png64 column (index 1)
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

// Replace default DataTables filter with custom search bar
function replaceCustomSearchBar(table) {
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="search-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#f7971e" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#f7971e" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" class="form-control" placeholder="Search coins..." aria-controls="livecoin_history" style="padding-left:44px;" />
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

