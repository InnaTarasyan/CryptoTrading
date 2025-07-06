"use strict";
function Coingecko(){

}

Coingecko.prototype.init = function () {
    // Column labels for data-label attributes (must match table header order)
    var columnLabels = [
        'Name',
        'Image',
        'Current price',
        'Market cap',
        'Market cap rank',
        'Fully diluted Valuation',
        'Total Volume',
        'High 24h',
        'Low 24h',
        'Price change 24h',
        'Price change percentage 24h',
        'Market cap change 24h',
        'Market cap change percentage 24h',
        'Circulating supply',
        'Total supply',
        'Max supply',
        'Ath',
        'Ath change percentage',
        'Atl',
        'Atl change percentage',
        'Roi',
        'Ath date',
        'Last updated'
    ];
    var oTable = $('#coingecko_markets').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_markets_route').val(),
        "scrollX": true,
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'image', name: 'image'},
            {data: 'current_price', name: 'current_price'},
            {data: 'market_cap', name: 'market_cap'},
            {data: 'market_cap_rank', name: 'market_cap_rank'},
            {data: 'fully_diluted_valuation', name: 'fully_diluted_valuation'},
            {data: 'total_volume', name: 'total_volume'},
            {data: 'high_24h', name: 'high_24h'},
            {data: 'low_24h', name: 'low_24h'},
            {data: 'price_change_24h', name: 'price_change_24h'},
            {data: 'price_change_percentage_24h', name: 'price_change_percentage_24h'},
            {data: 'market_cap_change_24h', name: 'market_cap_change_24h'},
            {data: 'market_cap_change_percentage_24h', name: 'market_cap_change_percentage_24h'},
            {data: 'circulating_supply', name: 'circulating_supply'},
            {data: 'total_supply', name: 'total_supply'},
            {data: 'max_supply', name: 'max_supply'},
            {data: 'ath', name: 'ath'},
            {data: 'ath_change_percentage', name: 'ath_change_percentage'},
            {data: 'atl', name: 'atl'},
            {data: 'atl_change_percentage', name: 'atl_change_percentage'},
            {data: 'roi', name: 'roi'},
            {data: 'ath_date', name: 'ath_date'},
            {data: 'last_updated', name: 'last_updated'},
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
            $('#coingecko_markets tbody tr').click(function () {
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
            });
        }
    });

    // Replace default DataTables filter with custom search bar (pink gradient)
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="search-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#ff6a88" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#ff6a88" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" class="form-control" placeholder="Search coins..." aria-controls="coingecko_markets" style="padding-left:44px;" />
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
};

Coingecko.prototype.bindEvents = function () {
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
        const table = $('#coingecko_markets').DataTable();
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
    var table = $('#coingecko_markets').DataTable();
    
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
        // Remove any existing feedback
        refreshBtn.removeClass('success error');
        
        // Add appropriate class
        refreshBtn.addClass(type);
        
        // Update label temporarily
        const originalText = label.text();
        label.text(message);
        
        // Show success/error state
        setTimeout(() => {
            refreshBtn.removeClass(type);
            label.text(originalText);
        }, 2000);
    }
    
    refreshBtn.on('click', function(e) {
        e.preventDefault();
        
        // Add click animation
        refreshBtn.addClass('clicked');
        setTimeout(() => refreshBtn.removeClass('clicked'), 200);
        
        setRefreshing(true);
        
        // Simulate a small delay for better UX
        setTimeout(() => {
            table.ajax.reload(function(json) {
                setRefreshing(false);
                
                // Check if reload was successful
                if (json && !json.error) {
                    showRefreshFeedback('Data refreshed! ✅', 'success');
                    
                    // Add subtle success animation
                    refreshBtn.addClass('success-bounce');
                    setTimeout(() => refreshBtn.removeClass('success-bounce'), 600);
                } else {
                    showRefreshFeedback('Refresh failed! ❌', 'error');
                }
            }, false);
        }, 300);
    });
    
    // Handle processing state from DataTable
    table.on('processing.dt', function(e, settings, processing) {
        if (processing && !refreshBtn.hasClass('loading')) {
            setRefreshing(true);
        } else if (!processing && refreshBtn.hasClass('loading')) {
            setRefreshing(false);
        }
    });
    
    // Add keyboard support for refresh button
    refreshBtn.on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            $(this).click();
        }
    });
    
    // Add hover tooltip for refresh button
    refreshBtn.attr('title', 'Refresh market data (Ctrl+R)');
    
    // Add keyboard shortcut
    $(document).on('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
            e.preventDefault();
            if (!refreshBtn.hasClass('loading')) {
                refreshBtn.click();
            }
        }
    });
    
    // Add touch feedback for mobile
    refreshBtn.on('touchstart', function() {
        $(this).addClass('touch-active');
    }).on('touchend touchcancel', function() {
        $(this).removeClass('touch-active');
    });
};

$(document).ready(function() {
    var coins = new Coingecko();
    coins.init();
    coins.bindEvents();

    // Enhanced ripple effect for action buttons
    function addRippleEffectToButton(btnSelector, rippleColor) {
        $(document).on('pointerdown', btnSelector, function(e) {
            var $btn = $(this);
            var $ripple = $btn.find('.ripple-effect');
            if ($ripple.length === 0) return;
            
            $ripple.removeClass('show'); // Reset
            var btnOffset = $btn.offset();
            var x = e.pageX - btnOffset.left;
            var y = e.pageY - btnOffset.top;
            
            $ripple.css({
                left: x - $ripple.width() / 2,
                top: y - $ripple.height() / 2,
                background: rippleColor,
                opacity: 1,
                transform: 'scale(0)'
            });
            
            // Force reflow for restart
            void $ripple[0].offsetWidth;
            $ripple.addClass('show');
            
            setTimeout(function() {
                $ripple.removeClass('show');
            }, 500);
        });
    }
    
    // Pinky gradient ripple for markets theme
    var pinkRipple = 'radial-gradient(circle, rgba(255,106,136,0.25) 0%, rgba(255,153,172,0.18) 80%, rgba(255,106,136,0.10) 100%)';
    addRippleEffectToButton('#refreshTable', pinkRipple);
    addRippleEffectToButton('#fullscreenToggle', pinkRipple);
    addRippleEffectToButton('#darkModeToggle', pinkRipple);
});
