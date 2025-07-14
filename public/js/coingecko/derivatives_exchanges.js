"use strict";
function CoingeckoDerivativesExchanges(){

}

CoingeckoDerivativesExchanges.prototype.init = function () {
    // Column labels for data-label attributes (must match table header order)
    var columnLabels = [
        'Exchange',
        'Logo',
        'Description',
        'Open Interest BTC',
        '24h Volume BTC',
        'Perpetual Pairs',
        'Futures Pairs',
        'Established',
        'Country',
        'Website'
    ];

    var oTable = $('#coingecko_derivatives_exchanges').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_derivatives_exchanges_route').val(),
        "scrollX": true,
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'image', name: 'image'},
            {data: 'description', name: 'description'},
            {data: 'open_interest_btc', name: 'open_interest_btc'},
            {data: 'trade_volume_24h_btc', name: 'trade_volume_24h_btc'},
            {data: 'number_of_perpetual_pairs', name: 'number_of_perpetual_pairs'},
            {data: 'number_of_futures_pairs', name: 'number_of_futures_pairs'},
            {data: 'year_established', name: 'year_established'},
            {data: 'country', name: 'country'},
            {data: 'url', name: 'url'}
        ],
        "columnDefs": [
            { "width": "60px", "targets": 1 }
        ],
        "iDisplayLength": 10,
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
        "fnDrawCallback": function() {
            $('#coingecko_derivatives_exchanges tbody tr').click(function () {
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
                // For mobile, add multiline label as HTML for long columns
                if (window.innerWidth <= 767 && (idx === 3 || idx === 4)) {
                    $(this).addClass('mobile-multiline-label');
                    // Remove any previous label span to avoid duplicates
                    $(this).find('.mobile-multiline-label').remove();
                    // Insert the HTML label at the start of the cell
                    $(this).prepend('<span class="mobile-multiline-label">' + columnLabels[idx] + '</span>');
                }
            });
        }
    });

    // Replace default DataTables filter with custom search bar (pink gradient)
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="search-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#ff6a88" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#ff6a88" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" class="form-control" placeholder="Search coins..." aria-controls="coingecko_derivatives_exchanges" style="padding-left:44px;" />
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

    // Force hide thead on mobile after DataTables draw (in case DataTables overrides CSS)
    function hideTheadOnMobile() {
        if (window.innerWidth <= 767) {
            $('.enhanced-thead').css('display', 'none');
        } else {
            $('.enhanced-thead').css('display', '');
        }
    }
    hideTheadOnMobile();
    $(window).on('resize', hideTheadOnMobile);
    oTable.on('draw', hideTheadOnMobile);

    // ======================== Highlight Search Results ========================
    function highlightSearchResults() {
        var table = $('#coingecko_derivatives_exchanges').DataTable();
        var searchTerm = table.search();
        if (!searchTerm) {
            $('#coingecko_derivatives_exchanges tbody td').each(function() {
                $(this).html($(this).text());
            });
            return;
        }
        var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\]/g, '\\$&')+')', 'gi');
        $('#coingecko_derivatives_exchanges tbody tr').each(function() {
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

    // Add highlight on table draw
    oTable.on('draw', highlightSearchResults);

    // ======================== Dark Mode Functionality ========================
    // Enhanced Dark Mode functionality with better UX
    const darkModeBtn = $('#darkModeToggle');
    const darkModeIcon = $('#darkModeIcon');
    const darkModeText = $('#darkModeText');
    const darkModeStatus = $('#darkModeStatus');
    const themePreviewTooltip = $('#themePreviewTooltip');
    const body = $('body');
    
    // Check system preference
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
    
    function setDarkMode(enabled) {
        // Add transition class for smooth animation
        body.addClass('theme-transitioning');
        
        if (enabled) {
            body.addClass('dark-mode');
            darkModeBtn.attr('aria-checked', 'true');
            darkModeText.text('Light Mode');
            darkModeStatus.text('🌙');
            darkModeBtn.addClass('dark-mode-active');
            
            // Update tooltip
            themePreviewTooltip.find('.tooltip-icon').text('☀️');
            themePreviewTooltip.find('.tooltip-text').text('Switch to Light Mode');
            
            // Add success feedback
            showThemeFeedback('Dark mode activated! 🌙', 'success');
        } else {
            body.removeClass('dark-mode');
            darkModeBtn.attr('aria-checked', 'false');
            darkModeText.text('Dark Mode');
            darkModeStatus.text('☀️');
            darkModeBtn.removeClass('dark-mode-active');
            
            // Update tooltip
            themePreviewTooltip.find('.tooltip-icon').text('🌙');
            themePreviewTooltip.find('.tooltip-text').text('Switch to Dark Mode');
            
            // Add success feedback
            showThemeFeedback('Light mode activated! ☀️', 'success');
        }
        
        // Remove transition class after animation
        setTimeout(() => {
            body.removeClass('theme-transitioning');
        }, 300);
    }

    // Show theme feedback notification
    function showThemeFeedback(message, type) {
        const feedback = $(`
            <div class="theme-feedback ${type}">
                <span class="feedback-icon">${type === 'success' ? '✅' : 'ℹ️'}</span>
                <span class="feedback-text">${message}</span>
            </div>
        `);
        
        $('body').append(feedback);
        
        // Animate in
        setTimeout(() => feedback.addClass('show'), 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            feedback.removeClass('show');
            setTimeout(() => feedback.remove(), 300);
        }, 3000);
    }

    // Initialize dark mode based on stored preference or system preference
    const storedDarkMode = localStorage.getItem('darkMode');
    const shouldUseDarkMode = storedDarkMode !== null ? storedDarkMode === 'true' : prefersDarkScheme.matches;
    setDarkMode(shouldUseDarkMode);

    // Enhanced click handler with better feedback
    darkModeBtn.on('click', function(e) {
        e.preventDefault();
        
        // Add click animation
        darkModeBtn.addClass('clicked');
        setTimeout(() => darkModeBtn.removeClass('clicked'), 200);
        
        const enabled = !body.hasClass('dark-mode');
        setDarkMode(enabled);
        localStorage.setItem('darkMode', enabled);
        
        // Update DataTable theme if needed
        const table = $('#coingecko_derivatives_exchanges').DataTable();
        if (table) {
            table.draw();
        }
    });

    // Enhanced hover effects
    darkModeBtn.on('mouseenter', function() {
        themePreviewTooltip.addClass('show');
    }).on('mouseleave', function() {
        themePreviewTooltip.removeClass('show');
    });

    // Keyboard accessibility
    darkModeBtn.on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            $(this).click();
        }
    });

    // Listen for system theme changes
    prefersDarkScheme.addEventListener('change', function(e) {
        const storedPreference = localStorage.getItem('darkMode');
        if (storedPreference === null) {
            // Only auto-switch if user hasn't set a preference
            setDarkMode(e.matches);
            localStorage.setItem('darkMode', e.matches);
        }
    });

    // Fullscreen functionality
    const fullscreenBtn = document.getElementById('fullscreenToggle');
    const fullscreenText = document.getElementById('fullscreenText');
    const fullscreenContainer = document.getElementById('datatableFullscreenContainer');
    const fullscreenIcons = fullscreenBtn ? fullscreenBtn.querySelectorAll('svg') : null;
    function isFullscreen() {
        return document.fullscreenElement === fullscreenContainer;
    }
    if (fullscreenBtn && fullscreenContainer) {
        fullscreenBtn.addEventListener('click', function () {
            if (!isFullscreen()) {
                fullscreenContainer.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        });
        fullscreenContainer.addEventListener('fullscreenchange', function () {
            if (isFullscreen()) {
                fullscreenBtn.classList.add('active');
                fullscreenText.textContent = 'Exit Fullscreen';
                if (fullscreenIcons) {
                    fullscreenIcons[0].style.display = 'none'; // icon-fullscreen
                    fullscreenIcons[1].style.display = '';
                }
            } else {
                fullscreenBtn.classList.remove('active');
                fullscreenText.textContent = 'Fullscreen';
                if (fullscreenIcons) {
                    fullscreenIcons[0].style.display = '';
                    fullscreenIcons[1].style.display = 'none'; // icon-exit-fullscreen
                }
            }
        });
    }
    
    // Refresh button logic with enhanced UX
    var refreshBtn = $('#refreshTable');
    var spinner = refreshBtn.find('.refresh-spinner');
    var label = refreshBtn.find('.refresh-btn-label');
    var icon = refreshBtn.find('.icon-refresh-upgraded');
    var table = $('#coingecko_derivatives_exchanges').DataTable();
    
    function setRefreshing(isRefreshing) {
        if (isRefreshing) {
            refreshBtn.addClass('loading');
            spinner.show();
            icon.hide();
            refreshBtn.attr('aria-busy', 'true').attr('aria-disabled', 'true').prop('disabled', true);
            label.text('Refreshing...');
            
            // Add spinning animation to icon
            icon.addClass('spinning');
        } else {
            refreshBtn.removeClass('loading');
            spinner.hide();
            icon.show();
            refreshBtn.attr('aria-busy', 'false').attr('aria-disabled', 'false').prop('disabled', false);
            label.text('Refresh');
            
            // Remove spinning animation
            icon.removeClass('spinning');
        }
    }
    
    function showRefreshFeedback(message, type = 'success') {
        const feedback = document.createElement('div');
        feedback.className = `refresh-feedback ${type}`;
        feedback.innerHTML = `
            <div class="feedback-content">
                <span class="feedback-icon">${type === 'success' ? '🔄' : '⚠️'}</span>
                <span class="feedback-text">${message}</span>
            </div>
        `;

        document.body.appendChild(feedback);

        // Animate in
        setTimeout(() => {
            feedback.style.transform = 'translateY(0)';
        feedback.style.opacity = '1';
    }, 10);

        // Remove after 3 seconds
        setTimeout(() => {
            feedback.style.transform = 'translateY(-100%)';
        feedback.style.opacity = '0';
        setTimeout(() => {
            if (feedback.parentNode) {
            feedback.parentNode.removeChild(feedback);
        }
    }, 300);
    }, 3000);
    }

    // ======================== Refresh Functionality ========================
    document.getElementById('refreshTable').addEventListener('click', function() {
        // Set refreshing state
        setRefreshing(true);
        updateTableStatus('Refreshing data...', '🔄');

        // Reload the DataTable
        oTable.ajax.reload(function() {
            // Callback after reload is complete
            setRefreshing(false);
            showRefreshFeedback('Data refreshed successfully!', 'success');
            updateTableStatus('Data updated successfully', '✅');

            // Reset status after a delay
            setTimeout(() => {
                updateTableStatus('Ready to display derivatives exchanges data', '📊');
        }, 2000);
        }, false); // false means don't reset paging
    });

    // ======================== Ripple Effect ========================
    function addRippleEffectToButton(btnSelector, rippleColor) {
        const buttons = document.querySelectorAll(btnSelector);

        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.className = 'ripple-effect';
            ripple.style.background = rippleColor || '#ff6a88';

            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
        }, 600);
        });
    });
    }

    // Add ripple effects to buttons
    addRippleEffectToButton('.refresh-btn', '#ff6a88');
    addRippleEffectToButton('.modern-fullscreen-btn', '#ff99ac');
    addRippleEffectToButton('.status-action-btn', '#ff6a88');

    // ======================== Loading Functions ========================
    function showLoading() {
        document.getElementById('datatableLoading').style.display = 'flex';
    }

    function hideLoading() {
        document.getElementById('datatableLoading').style.display = 'none';
    }

    // ======================== Table Status Functions ========================
    function updateTableStatus(text, icon) {
        const statusText = document.querySelector('#tableStatusBar .status-text');
        const statusIcon = document.querySelector('#tableStatusBar .status-icon');

        if (statusText) statusText.textContent = text;
        if (statusIcon) statusIcon.textContent = icon;
    }

    // ======================== Export and Print Functions ========================
    document.getElementById('exportData').addEventListener('click', function() {
        // Trigger CSV export
        const csvButton = document.querySelector('.datatable-btn[data-action="csv"]');
        if (csvButton) {
            csvButton.click();
        }
    });

    document.getElementById('printTable').addEventListener('click', function() {
        // Trigger print
        const printButton = document.querySelector('.datatable-btn[data-action="print"]');
        if (printButton) {
            printButton.click();
        }
    });

    // ======================== Responsive Handling ========================
    function handleResize() {
        // Recalculate table layout on resize
        if (oTable) {
            oTable.columns.adjust();
        }

        // Update mobile-specific behaviors
        hideTheadOnMobile();
    }

    // Listen for window resize
    window.addEventListener('resize', handleResize);

    // ======================== Initial Setup ========================
    // Set initial table status
    updateTableStatus('Ready to display derivatives exchanges data', '📊');

    // Hide loading after initial load
    setTimeout(() => {
        hideLoading();
}, 1000);
};

CoingeckoDerivativesExchanges.prototype.bindEvents = function () {

};

$(document).ready(function() {
    var coins = new CoingeckoDerivativesExchanges();
    coins.init();
    coins.bindEvents();
});
