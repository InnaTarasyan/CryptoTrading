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
        (window.innerWidth <= 767 ? 'Price change<br>percentage 24h' : 'Price change percentage 24h'),
        'Market cap change 24h',
        (window.innerWidth <= 767 ? 'Market cap change<br>percentage 24h' : 'Market cap change percentage 24h'),
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
                // For mobile, add multiline label as HTML for long columns
                if (window.innerWidth <= 767 && (idx === 10 || idx === 12)) {
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
        var table = $('#coingecko_markets').DataTable();
        var searchTerm = table.search();
        if (!searchTerm) {
            $('#coingecko_markets tbody td').each(function() {
                $(this).html($(this).text());
            });
            return;
        }
        var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\]/g, '\\$&')+')', 'gi');
        $('#coingecko_markets tbody tr').each(function() {
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
    oTable.on('draw', function() {
        highlightSearchResults();
    });
    // Also highlight on search input change
    searchBox.on('input', function() {
        oTable.search(searchBox.val()).draw();
        highlightSearchResults();
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
    // Help modal elements
    const helpBtn = $('#helpInfoBtn');
    const helpModal = $('#helpInfoModal');
    const helpClose = $('#closeHelpModal');

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

    // Help modal open/close logic
    helpBtn.on('click keypress', function(e) {
        if (e.type === 'click' || (e.type === 'keypress' && (e.key === 'Enter' || e.key === ' '))) {
            helpModal.show();
            helpModal.find('.modern-help-modal-content').attr('tabindex', '-1').focus();
        }
    });
    helpClose.on('click keypress', function(e) {
        if (e.type === 'click' || (e.type === 'keypress' && (e.key === 'Enter' || e.key === ' '))) {
            helpModal.hide();
            helpBtn.focus();
        }
    });
    // Close modal on ESC
    $(document).on('keydown', function(e) {
        if (helpModal.is(':visible') && e.key === 'Escape') {
            helpModal.hide();
            helpBtn.focus();
        }
    });
    // Trap focus in modal
    helpModal.on('keydown', function(e) {
        if (e.key === 'Tab') {
            const focusable = helpModal.find('button, [tabindex]:not([tabindex="-1"])').filter(':visible');
            const first = focusable.first()[0];
            const last = focusable.last()[0];
            if (e.shiftKey ? document.activeElement === first : document.activeElement === last) {
                e.preventDefault();
                (e.shiftKey ? last : first).focus();
            }
        }
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

    // === Image preview logic (copied and adapted from history.js) ===
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

    // ======================== Reviews AJAX Logic ========================
    function getInitials(name) {
        if (!name) return '';
        const parts = name.trim().split(' ');
        if (parts.length === 1) return parts[0][0].toUpperCase();
        return (parts[0][0] + parts[parts.length-1][0]).toUpperCase();
    }
    function renderStars(rating) {
        rating = parseInt(rating) || 0;
        return '★'.repeat(rating) + '☆'.repeat(5 - rating);
    }
    function renderReviews(reviews) {
        let html = '';
        if (!reviews.length) {
            html = '<div class="alert alert-info">No reviews yet. Be the first to review!</div>';
        } else {
            html = reviews.map(r => `
                <div class="modern-review-card">
                    <div class="modern-review-avatar">${getInitials(r.name)}</div>
                    <div class="modern-review-content">
                        <div class="modern-review-header">
                            <span class="modern-review-name">${r.name}</span>
                            <span class="modern-review-date"><svg style="width:1em;height:1em;vertical-align:middle;margin-right:0.2em;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff6a88"/><path d="M12 6v6l4 2" stroke="#ff99ac" stroke-width="2" stroke-linecap="round"/></svg> ${new Date(r.created_at).toLocaleString()}</span>
                            <span class="modern-review-rating">${renderStars(r.rating)}</span>
                        </div>
                        <div class="modern-review-title">${r.title}</div>
                        <div class="modern-review-comment">${r.comment ? r.comment.replace(/\n/g, '<br>') : ''}</div>
                        <div style="margin-top:0.5em;">
                            ${r.country ? `<span title="Country" style="margin-right:1em;"><svg style="width:1em;height:1em;vertical-align:middle;" viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ffd200"/><path d="M2 6l10 7 10-7" stroke="#ff6a88" stroke-width="2"/></svg> ${r.country}</span>` : ''}
                            ${r.experience_level ? `<span title="Experience Level" style="margin-right:1em;"><svg style="width:1em;height:1em;vertical-align:middle;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff99ac"/><path d="M12 6v6l4 2" stroke="#ff6a88" stroke-width="2" stroke-linecap="round"/></svg> ${r.experience_level}</span>` : ''}
                            ${r.pros ? `<span title="Pros" style="margin-right:1em;"><svg style="width:1em;height:1em;vertical-align:middle;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M8 12h8M12 8v8" stroke="#ff6a88" stroke-width="2"/></svg> ${r.pros.replace(/\n/g, '<br>')}</span>` : ''}
                            ${r.cons ? `<span title="Cons" style="margin-right:1em;"><svg style="width:1em;height:1em;vertical-align:middle;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff99ac"/><path d="M8 12h8" stroke="#ff6a88" stroke-width="2"/></svg> ${r.cons.replace(/\n/g, '<br>')}</span>` : ''}
                            ${typeof r.recommend !== 'undefined' && r.recommend !== null ? `<span title="Recommend"><svg style="width:1em;height:1em;vertical-align:middle;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M8 12l2 2 4-4" stroke="#ff6a88" stroke-width="2"/></svg> ${r.recommend ? 'Yes' : 'No'}</span>` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        }
        $('#reviews-list').html(html);
    }
    function fetchReviews() {
        var coinId = $('#coin_id').val();
        $.get('/coingecko/markets/reviews', { coin_id: coinId }, function(data) {
            renderReviews(data);
        });
    }
    fetchReviews();
    $('#reviewForm').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        var csrfToken = $(form).find('input[name="_token"]').val();
        $.ajax({
            url: form.action,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.success) {
                    form.reset();
                    $('#reviewFormMsg').html('<div class="alert alert-success">Thank you for your review!</div>');
                    fetchReviews();
                } else {
                    $('#reviewFormMsg').html('<div class="alert alert-danger">There was an error submitting your review.</div>');
                }
            },
            error: function(xhr) {
                let msg = 'There was an error submitting your review.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg += '<ul>';
                    $.each(xhr.responseJSON.errors, function(k, v) { msg += `<li>${v}</li>`; });
                    msg += '</ul>';
                }
                $('#reviewFormMsg').html('<div class="alert alert-danger">'+msg+'</div>');
            }
        });
    });
});

// --- BEGIN: Logic moved from markets.blade.php inline script ---
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced fullscreen button functionality with ripple effects and better UX
    var refreshBtn = document.getElementById('refreshTable');
    var fullscreenBtn = document.getElementById('fullscreenToggle');
    var fullscreenContainer = document.getElementById('datatableFullscreenContainer');
    var fullscreenText = document.getElementById('fullscreenText');
    var iconFullscreen = fullscreenBtn ? fullscreenBtn.querySelector('.icon-fullscreen') : null;
    var iconExitFullscreen = fullscreenBtn ? fullscreenBtn.querySelector('.icon-exit-fullscreen') : null;
    // Enhanced table status elements
    var tableStatusBar = document.getElementById('tableStatusBar');
    var statusText = tableStatusBar ? tableStatusBar.querySelector('.status-text') : null;
    var exportBtn = document.getElementById('exportData');
    var printBtn = document.getElementById('printTable');
    var scrollToTopBtn = document.getElementById('scrollToTop');

    // Refresh button functionality (if not already handled by jQuery logic)
    if (refreshBtn && !refreshBtn.classList.contains('js-moved')) {
        refreshBtn.addEventListener('click', function() {
            refreshBtn.classList.add('spinning');
            updateTableStatus('Refreshing data...', '🔄');
            setTimeout(function() {
                refreshBtn.classList.remove('spinning');
                updateTableStatus('Data refreshed successfully!', '✅');
                setTimeout(() => {
                    updateTableStatus('Ready to display market data', '📊');
                }, 2000);
            }, 700);
        });
        refreshBtn.classList.add('js-moved');
    }

    // Export data functionality
    if (exportBtn && !exportBtn.classList.contains('js-moved')) {
        exportBtn.addEventListener('click', function() {
            updateTableStatus('Preparing export...', '📤');
            setTimeout(() => {
                // Trigger DataTables export (if available)
                if (window.DataTable && window.DataTable.tables) {
                    var table = window.DataTable.tables().container();
                    if (table && table.buttons) {
                        table.buttons.exportData();
                    }
                }
                updateTableStatus('Export completed!', '✅');
                setTimeout(() => {
                    updateTableStatus('Ready to display market data', '📊');
                }, 2000);
            }, 1000);
        });
        exportBtn.classList.add('js-moved');
    }

    // Print table functionality
    if (printBtn && !printBtn.classList.contains('js-moved')) {
        printBtn.addEventListener('click', function() {
            updateTableStatus('Preparing print...', '🖨️');
            setTimeout(() => {
                window.print();
                updateTableStatus('Print dialog opened!', '✅');
                setTimeout(() => {
                    updateTableStatus('Ready to display market data', '📊');
                }, 2000);
            }, 500);
        });
        printBtn.classList.add('js-moved');
    }

    // Scroll to top functionality
    if (scrollToTopBtn && !scrollToTopBtn.classList.contains('js-moved')) {
        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        scrollToTopBtn.classList.add('js-moved');
    }

    // Update table status function
    function updateTableStatus(text, icon) {
        if (statusText) {
            statusText.textContent = text;
        }
        var statusIcon = tableStatusBar ? tableStatusBar.querySelector('.status-icon') : null;
        if (statusIcon) {
            statusIcon.textContent = icon;
        }
    }

    // Enhanced loading state management
    function showLoading() {
        var loadingElement = document.getElementById('datatableLoading');
        if (loadingElement) {
            loadingElement.style.display = 'flex';
            updateTableStatus('Loading market data...', '⏳');
        }
    }
    function hideLoading() {
        var loadingElement = document.getElementById('datatableLoading');
        if (loadingElement) {
            loadingElement.style.display = 'none';
            updateTableStatus('Data loaded successfully!', '✅');
            setTimeout(() => {
                updateTableStatus('Ready to display market data', '📊');
            }, 2000);
        }
    }

    // Enhanced fullscreen button functionality
    if (fullscreenBtn && !fullscreenBtn.classList.contains('js-moved')) {
        // Ripple effect function
        function createRipple(event) {
            const button = event.currentTarget;
            const ripple = button.querySelector('.ripple-effect');
            if (ripple) {
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = event.clientX - rect.left - size / 2;
                const y = event.clientY - rect.top - size / 2;
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('show');
                setTimeout(() => {
                    ripple.classList.remove('show');
                }, 600);
            }
        }
        // Fullscreen toggle function
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                if (fullscreenContainer.requestFullscreen) {
                    fullscreenContainer.requestFullscreen();
                } else if (fullscreenContainer.webkitRequestFullscreen) {
                    fullscreenContainer.webkitRequestFullscreen();
                } else if (fullscreenContainer.msRequestFullscreen) {
                    fullscreenContainer.msRequestFullscreen();
                }
                fullscreenBtn.setAttribute('aria-pressed', 'true');
                if (fullscreenText) fullscreenText.textContent = 'Exit Fullscreen';
                if (iconFullscreen) iconFullscreen.style.display = 'none';
                if (iconExitFullscreen) iconExitFullscreen.style.display = 'block';
                fullscreenBtn.classList.add('success');
                updateTableStatus('Entered fullscreen mode', '🖥️');
                setTimeout(() => {
                    fullscreenBtn.classList.remove('success');
                }, 600);
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
                fullscreenBtn.setAttribute('aria-pressed', 'false');
                if (fullscreenText) fullscreenText.textContent = 'Fullscreen';
                if (iconFullscreen) iconFullscreen.style.display = 'block';
                if (iconExitFullscreen) iconExitFullscreen.style.display = 'none';
                updateTableStatus('Exited fullscreen mode', '📊');
            }
        }
        fullscreenBtn.addEventListener('click', function(e) {
            e.preventDefault();
            createRipple(e);
            toggleFullscreen();
        });
        fullscreenBtn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
        document.addEventListener('fullscreenchange', function() {
            if (!document.fullscreenElement) {
                fullscreenBtn.setAttribute('aria-pressed', 'false');
                if (fullscreenText) fullscreenText.textContent = 'Fullscreen';
                if (iconFullscreen) iconFullscreen.style.display = 'block';
                if (iconExitFullscreen) iconExitFullscreen.style.display = 'none';
            }
        });
        document.addEventListener('webkitfullscreenchange', function() {
            if (!document.webkitFullscreenElement) {
                fullscreenBtn.setAttribute('aria-pressed', 'false');
                if (fullscreenText) fullscreenText.textContent = 'Fullscreen';
                if (iconFullscreen) iconFullscreen.style.display = 'block';
                if (iconExitFullscreen) iconExitFullscreen.style.display = 'none';
            }
        });
        document.addEventListener('MSFullscreenChange', function() {
            if (!document.msFullscreenElement) {
                fullscreenBtn.setAttribute('aria-pressed', 'false');
                if (fullscreenText) fullscreenText.textContent = 'Fullscreen';
                if (iconFullscreen) iconFullscreen.style.display = 'block';
                if (iconExitFullscreen) iconExitFullscreen.style.display = 'none';
            }
        });
        fullscreenBtn.addEventListener('mouseenter', function() {
            if (!this.classList.contains('loading')) {
                this.style.transform = 'translateY(-2px) scale(1.04)';
            }
        });
        fullscreenBtn.addEventListener('mouseleave', function() {
            if (!this.classList.contains('loading')) {
                this.style.transform = 'translateY(0) scale(1)';
            }
        });
        fullscreenBtn.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.95)';
        });
        fullscreenBtn.addEventListener('touchend', function() {
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
        fullscreenBtn.classList.add('js-moved');
    }

    // Enhanced table interactions
    var tableHeaders = document.querySelectorAll('.enhanced-th');
    tableHeaders.forEach(function(header) {
        header.addEventListener('click', function() {
            this.classList.add('sorting');
            setTimeout(() => {
                this.classList.remove('sorting');
            }, 300);
        });
        header.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });

    // Enhanced responsive behavior
    function handleResize() {
        var isMobile = window.innerWidth <= 768;
        var statusBar = document.getElementById('tableStatusBar');
        if (statusBar) {
            if (isMobile) {
                statusBar.classList.add('mobile-layout');
            } else {
                statusBar.classList.remove('mobile-layout');
            }
        }
    }
    handleResize();
    window.addEventListener('resize', handleResize);

    // Enhanced accessibility
    document.addEventListener('keydown', function(e) {
        // Escape key to exit fullscreen
        if (e.key === 'Escape' && document.fullscreenElement) {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
        // Ctrl/Cmd + P for print
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            if (printBtn) {
                printBtn.click();
            }
        }
    });

    // Initialize DataTable with enhanced callbacks (if not already handled)
    if (typeof $ !== 'undefined' && $.fn && $.fn.DataTable && !$.fn.DataTable._enhancedInit) {
        var originalDataTable = $.fn.DataTable;
        $.fn.DataTable = function(settings) {
            var table = originalDataTable.apply(this, arguments);
            if (settings && settings.initComplete) {
                var originalInitComplete = settings.initComplete;
                settings.initComplete = function(settings, json) {
                    hideLoading();
                    if (originalInitComplete) {
                        originalInitComplete.call(this, settings, json);
                    }
                };
            }
            return table;
        };
        $.fn.DataTable._enhancedInit = true;
    }

    // Add clear search button to DataTable search input
    setTimeout(function() {
        var filter = document.querySelector('.dataTables_filter');
        if (filter && !document.getElementById('clear-search')) {
            var input = filter.querySelector('input[type="search"]');
            var btn = document.createElement('button');
            btn.id = 'clear-search';
            btn.type = 'button';
            btn.innerHTML = '✕';
            btn.setAttribute('aria-label', 'Clear search');
            btn.style.marginLeft = '0.5em';
            btn.style.fontSize = '1.1em';
            btn.style.background = 'transparent';
            btn.style.border = 'none';
            btn.style.cursor = 'pointer';
            btn.style.color = '#ff6a88';
            btn.style.outline = 'none';
            btn.addEventListener('click', function() {
                if (input) {
                    input.value = '';
                    var event = new Event('keyup', { bubbles: true });
                    input.dispatchEvent(event);
                }
            });
            filter.appendChild(btn);
        }
    }, 500);
});
// --- END: Logic moved from markets.blade.php inline script ---
