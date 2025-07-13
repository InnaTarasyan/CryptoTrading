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
            <input type="search" class="form-control" placeholder="Search exchanges..." aria-controls="coingecko_derivatives_exchanges" style="padding-left:44px;" />
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
    function setDarkMode(enabled) {
        const body = document.body;
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeIcon = document.getElementById('darkModeIcon');
        const darkModeText = document.getElementById('darkModeText');
        const darkModeStatus = document.getElementById('darkModeStatus');

        if (enabled) {
            body.classList.add('dark-mode');
            darkModeToggle.setAttribute('aria-checked', 'true');
            darkModeIcon.querySelector('.icon-moon').style.display = 'none';
            darkModeIcon.querySelector('.icon-sun').style.display = 'block';
            darkModeText.textContent = 'Light Mode';
            darkModeStatus.textContent = 'Dark mode enabled';
            localStorage.setItem('darkMode', 'enabled');
        } else {
            body.classList.remove('dark-mode');
            darkModeToggle.setAttribute('aria-checked', 'false');
            darkModeIcon.querySelector('.icon-moon').style.display = 'block';
            darkModeIcon.querySelector('.icon-sun').style.display = 'none';
            darkModeText.textContent = 'Dark Mode';
            darkModeStatus.textContent = 'Light mode enabled';
            localStorage.setItem('darkMode', 'disabled');
        }
    }

    // Initialize dark mode from localStorage
    const savedDarkMode = localStorage.getItem('darkMode');
    if (savedDarkMode === 'enabled') {
        setDarkMode(true);
    }

    // Dark mode toggle event
    document.getElementById('darkModeToggle').addEventListener('click', function() {
        const isDarkMode = this.getAttribute('aria-checked') === 'true';
        setDarkMode(!isDarkMode);
        showThemeFeedback(isDarkMode ? 'Switched to Light Mode' : 'Switched to Dark Mode', 'success');
    });

    // ======================== Theme Feedback ========================
    function showThemeFeedback(message, type) {
        const feedback = document.createElement('div');
        feedback.className = `theme-feedback ${type}`;
        feedback.innerHTML = `
            <div class="feedback-content">
                <span class="feedback-icon">${type === 'success' ? '✅' : '❌'}</span>
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

    // ======================== Fullscreen Functionality ========================
    var fullscreenBtn = document.getElementById('fullscreenToggle');
    var tableWrapper = document.querySelector('.table-wrapper');
    var fullscreenText = document.getElementById('fullscreenText');
    var fullscreenIcons = fullscreenBtn ? fullscreenBtn.querySelectorAll('.icon-fullscreen, .icon-exit-fullscreen') : null;

    function isFullscreen() {
        return !!(document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement);
    }

    function enterFullscreen(element) {
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    }

    function exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }

    if (fullscreenBtn && tableWrapper) {
        fullscreenBtn.addEventListener('click', function () {
            if (!isFullscreen()) {
                // Prepare table wrapper for fullscreen
                tableWrapper.style.background = '#fff';
                tableWrapper.style.padding = '20px';
                tableWrapper.style.borderRadius = '0';
                tableWrapper.style.boxShadow = 'none';
                tableWrapper.style.width = '100%';
                tableWrapper.style.height = '100%';

                enterFullscreen(tableWrapper);
            } else {
                exitFullscreen();
            }
        });

        // Handle fullscreen change events
        document.addEventListener('fullscreenchange', handleFullscreenChange);
        document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
        document.addEventListener('mozfullscreenchange', handleFullscreenChange);
        document.addEventListener('MSFullscreenChange', handleFullscreenChange);

        function handleFullscreenChange() {
            if (isFullscreen()) {
                fullscreenBtn.classList.add('active');
                fullscreenText.textContent = 'Exit Fullscreen';
                if (fullscreenIcons) {
                    fullscreenIcons[0].style.display = 'none'; // icon-fullscreen
                    fullscreenIcons[1].style.display = 'block'; // icon-exit-fullscreen
                }

                // Ensure all DataTables elements are visible in fullscreen
                const dataTablesWrapper = tableWrapper.querySelector('.dataTables_wrapper');
                if (dataTablesWrapper) {
                    dataTablesWrapper.style.width = '100%';
                    dataTablesWrapper.style.height = '100%';
                    dataTablesWrapper.style.display = 'flex';
                    dataTablesWrapper.style.flexDirection = 'column';
                }

                // Make sure pagination and other controls are visible
                const pagination = tableWrapper.querySelector('.dataTables_paginate');
                const info = tableWrapper.querySelector('.dataTables_info');
                const length = tableWrapper.querySelector('.dataTables_length');
                const filter = tableWrapper.querySelector('.dataTables_filter');
                const toolbar = tableWrapper.querySelector('.datatable-toolbar');

                if (pagination) pagination.style.display = 'block';
                if (info) info.style.display = 'block';
                if (length) length.style.display = 'block';
                if (filter) filter.style.display = 'block';
                if (toolbar) toolbar.style.display = 'block';

            } else {
                fullscreenBtn.classList.remove('active');
                fullscreenText.textContent = 'Fullscreen';
                if (fullscreenIcons) {
                    fullscreenIcons[0].style.display = 'block'; // icon-fullscreen
                    fullscreenIcons[1].style.display = 'none'; // icon-exit-fullscreen
                }

                // Restore normal table wrapper styling
                tableWrapper.style.background = 'rgba(255,255,255,0.7)';
                tableWrapper.style.padding = '';
                tableWrapper.style.borderRadius = '1em';
                tableWrapper.style.boxShadow = '0 2px 12px rgba(80,80,200,0.06)';
                tableWrapper.style.width = '';
                tableWrapper.style.height = '';
            }
        }
    }

    function setRefreshing(isRefreshing) {
        const refreshBtn = document.getElementById('refreshTable');
        const refreshIcon = refreshBtn.querySelector('.refresh-icon-bg');
        const refreshSpinner = refreshBtn.querySelector('.refresh-spinner');
        const refreshLabel = refreshBtn.querySelector('.refresh-btn-label');

        if (isRefreshing) {
            refreshBtn.setAttribute('aria-busy', 'true');
            refreshBtn.setAttribute('aria-disabled', 'true');
            refreshIcon.style.display = 'none';
            refreshSpinner.style.display = 'block';
            refreshLabel.textContent = 'Refreshing...';
            refreshBtn.style.pointerEvents = 'none';
        } else {
            refreshBtn.setAttribute('aria-busy', 'false');
            refreshBtn.setAttribute('aria-disabled', 'false');
            refreshIcon.style.display = 'block';
            refreshSpinner.style.display = 'none';
            refreshLabel.textContent = 'Refresh';
            refreshBtn.style.pointerEvents = 'auto';
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
