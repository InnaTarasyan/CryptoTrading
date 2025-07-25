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
        "fixedHeader": true,
        "columns": [
            {data: 'name', name: 'name', render: function(data, type, row, meta) {
                if (!data) return '';
                // Split at the last space for two lines
                var idx = data.lastIndexOf(' ');
                if (idx > 0) {
                    return data.substring(0, idx) + '<br>' + data.substring(idx + 1);
                } else {
                    return data;
                }
            }},
            {data: 'image', name: 'image'},
            // {data: 'description', name: 'description', render: function(data, type, row, meta) {
            //     if (!data) return '<span class="desc-tooltip" style="color:#bbb;">—</span>';
            //     var clean = data.replace(/(<([^>]+)>)/gi, "");
            //     var short = clean.length > 100 ? clean.substring(0, 100).trim() + '…' : clean;
            //     var html = short.replace(/\n/g, '<br>');
            //     // Escape for tooltip, but allow line breaks and links
            //
            //     var escaped = data
            //         .replace(/&/g, '&amp;')
            //         .replace(/</g, '&lt;')
            //         .replace(/>/g, '&gt;')
            //         .replace(/\n/g, '<br>')
            //         .replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" rel="noopener" style="color:#43cea2;text-decoration:underline;">$1</a>');
            //     var readMore = clean.length > 100 ? '<span class="desc-readmore" style="color:#43cea2;cursor:pointer;font-weight:500;margin-left:6px;">Read more</span>' : '';
            //     // Always wrap in .desc-tooltip for preview panel logic
            //     return `<span class="desc-tooltip" data-tooltip="${escaped}" style="cursor: help; word-break: break-word;">${html}${readMore}</span>`;
            // }},
            {data: 'description', name: 'description'},
            {data: 'open_interest_btc', name: 'open_interest_btc', render: function(data, type, row, meta) {
                if (!data) return '';
                var str = data.toString();
                var idx = str.lastIndexOf(' ');
                if (idx > 0) {
                    return str.substring(0, idx) + '<br>' + str.substring(idx + 1);
                } else {
                    return str;
                }
            }},
            {data: 'trade_volume_24h_btc', name: 'trade_volume_24h_btc', render: function(data, type, row, meta) {
                if (!data) return '';
                var str = data.toString();
                var idx = str.lastIndexOf(' ');
                if (idx > 0) {
                    return str.substring(0, idx) + '<br>' + str.substring(idx + 1);
                } else {
                    return str;
                }
            }},
            {data: 'number_of_perpetual_pairs', name: 'number_of_perpetual_pairs', render: function(data, type, row, meta) {
                if (!data) return '';
                var str = data.toString();
                var idx = str.lastIndexOf(' ');
                if (idx > 0) {
                    return str.substring(0, idx) + '<br>' + str.substring(idx + 1);
                } else {
                    return str;
                }
            }},
            {data: 'number_of_futures_pairs', name: 'number_of_futures_pairs', render: function(data, type, row, meta) {
                if (!data) return '';
                var str = data.toString();
                var idx = str.lastIndexOf(' ');
                if (idx > 0) {
                    return str.substring(0, idx) + '<br>' + str.substring(idx + 1);
                } else {
                    return str;
                }
            }},
            {data: 'year_established', name: 'year_established', render: function(data, type, row, meta) {
                if (!data) return '<span style="color:#bbb;">—</span>';
                var str = data.toString();
                var idx = str.lastIndexOf(' ');
                var display = (idx > 0) ? str.substring(0, idx) + '<br>' + str.substring(idx + 1) : str;
                return '<span style="display:inline-flex;align-items:center;gap:0.4em;font-weight:500;">' +
                    '<span style="font-size:1.2em;vertical-align:middle;">📅</span>' +
                    '<span>' + display + '</span>' +
                    '</span>';
            }},
            {data: 'country', name: 'country', render: function(data, type, row, meta) {
                if (!data) return '<span style="color:#bbb;">—</span>';
                // Try to get country code from row.country_code or row.country_code_2 (fallback)
                var code = (row.country_code || row.country_code_2 || '').toLowerCase();
                var flag = '';
                if (code && /^[a-z]{2}$/.test(code)) {
                    flag = `<img src="https://flagcdn.com/24x18/${code}.png" style="margin-right:6px;vertical-align:middle;" alt="${data} flag">`;
                }
                return `${flag}${data}`;
            }},
            {data: 'url', name: 'url', render: function(data, type, row, meta) {
                if (!data) return '';
                var idx = data.lastIndexOf(' ');
                if (idx > 0) {
                    return data.substring(0, idx) + '<br>' + data.substring(idx + 1);
                } else {
                    return data;
                }
            }}
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
        // "fnDrawCallback": function() {
        //     $('#coingecko_derivatives_exchanges tbody tr').off('click').on('click', function (e) {
        //         // Exclude clicks on the Website column (last cell) or any links inside it
        //         var $td = $(e.target).closest('td');
        //         var $tr = $(this);
        //         var colIdx = $tr.find('td').index($td);
        //         // Website column is index 9 (0-based)
        //         if (colIdx === 9 || $(e.target).is('a')) {
        //             return;
        //         }
        //         var coin = $tr.find('.id').val();
        //         window.location.href = "/details/" + coin;
        //     });
        // },
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

    // Ensure table uses fixed layout
    $('#coingecko_derivatives_exchanges').css('table-layout', 'fixed');
    // Ensure parent container allows horizontal scroll
    $('#datatableFullscreenContainer').css('overflow-x', 'auto');

    // Add preview panel to body if not present or if removed
    function ensureDescriptionPreviewPanel() {
        let panel = document.getElementById('description-preview-panel');
        if (!panel) {
            panel = document.createElement('div');
            panel.id = 'description-preview-panel';
            document.body.appendChild(panel);
        }
        panel.style.position = 'fixed';
        panel.style.bottom = '32px';
        panel.style.right = '32px';
        panel.style.zIndex = '2147483647';
        panel.style.maxWidth = '420px';
        panel.style.minWidth = '220px';
        panel.style.background = '#232946';
        panel.style.color = '#ffd200';
        panel.style.padding = '18px 22px 18px 22px';
        panel.style.borderRadius = '16px';
        panel.style.boxShadow = '0 8px 32px rgba(0,0,0,0.18)';
        panel.style.fontSize = '1.08em';
        panel.style.lineHeight = '1.7';
        panel.style.pointerEvents = 'auto';
        panel.style.whiteSpace = 'normal';
        panel.style.overflow = 'auto';
        panel.style.maxHeight = '320px';
        panel.style.display = 'none';
        panel.style.border = '2px solid #ff6a88'; // Debug border
        panel.innerHTML = '';
        return panel;
    }

    function enableDescriptionPreviewPanel() {
        $('.desc-tooltip').off('mouseenter mouseleave').on({
            mouseenter: function(e) {
                const html = $(this).attr('data-tooltip');
                if (!html) return;
                const panel = ensureDescriptionPreviewPanel();
                panel.innerHTML = `
                    <div style="font-weight:700;font-size:1.13em;margin-bottom:0.5em;letter-spacing:0.01em;color:#43cea2;display:flex;align-items:center;gap:0.5em;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align:middle;"><defs><linearGradient id="descTooltipGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#43cea2"/><stop offset="1" stop-color="#185a9d"/></linearGradient></defs><rect x="2" y="4" width="20" height="16" rx="4" fill="url(#descTooltipGradient)"/><path d="M6 8h12M6 12h8" stroke="#fff" stroke-width="2"/></svg>
                        Exchange Description
                    </div>
                    <div class="desc-tooltip-content" style="color:#ffd200;word-break:break-word;">${html}</div>
                `;
                panel.style.display = 'block';
            },
            mouseleave: function() {
                const panel = ensureDescriptionPreviewPanel();
                panel.style.display = 'none';
                panel.innerHTML = '';
            }
        });
    }
    oTable.on('draw', enableDescriptionPreviewPanel);
    enableDescriptionPreviewPanel();

    // Replace default DataTables filter with custom search bar (pink gradient)
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="search-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#ff6a88" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#ff6a88" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" class="form-control" placeholder="Search exchanges..." aria-controls="coingecko_derivatives_exchanges" style="padding-left:44px; background:#fff6fa; border:1.5px solid #ff6a88; border-radius:24px; color:#ff6a88; font-size:15px; box-shadow:0 2px 8px rgba(255,106,136,0.08); transition:border 0.2s, box-shadow 0.2s; width:100%;" />
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
        var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\\]/g, '\\$&')+')', 'gi');
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
    searchBox.on('input', highlightSearchResults);
    filter.on('click', '#clear-search', highlightSearchResults);

    // ======================== Full Screen Functionality ========================
    const fullscreenBtn = document.getElementById('fullscreenToggle');
    const fullscreenContainer = document.getElementById('datatableFullscreenContainer');
    const fullscreenText = document.getElementById('fullscreenText');
    const iconFullscreen = fullscreenBtn ? fullscreenBtn.querySelector('.icon-fullscreen') : null;
    const iconExitFullscreen = fullscreenBtn ? fullscreenBtn.querySelector('.icon-exit-fullscreen') : null;

    function toggleFullscreen() {
        if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
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
    if (fullscreenBtn && fullscreenContainer) {
        fullscreenBtn.addEventListener('click', function(e) {
            e.preventDefault();
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
    }

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

    // ======================== Refresh Functionality ========================
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
    refreshBtn.on('click', function(e) {
        e.preventDefault();
        // Add click animation
        refreshBtn.addClass('clicked');
        setTimeout(() => refreshBtn.removeClass('clicked'), 200);
        setRefreshing(true);
        // Simulate a small delay for better UX
        setTimeout(() => {
            oTable.ajax.reload(function(json) {
            setRefreshing(false);
            // Fix header bug: force DataTable to recalculate columns
            oTable.columns.adjust();
            // Check if reload was successful
            if (json && !json.error) {
                showRefreshFeedback('Data refreshed! ✅', 'success');
                refreshBtn.addClass('success-bounce');
                setTimeout(() => refreshBtn.removeClass('success-bounce'), 600);
            } else {
                showRefreshFeedback('Refresh failed! ❌', 'error');
            }
        }, false);
    }, 300);
    });
    // Handle processing state from DataTable
    oTable.on('processing.dt', function(e, settings, processing) {
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
    refreshBtn.attr('title', 'Refresh derivatives exchanges data (Ctrl+R)');
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

// Ensure tooltip is always visible and not hidden by CSS
$(document).off('mouseleave.descTooltip').on('mouseleave.descTooltip', '.desc-tooltip', function() {
    $('.custom-tooltip-box').remove();
});
$(document).off('mouseenter.descTooltip').on('mouseenter.descTooltip', '.desc-tooltip', function(e) {
    const text = $(this).attr('data-tooltip');
    if (!text) return;
    $('.custom-tooltip-box').remove();
    const tooltip = $('<div class="custom-tooltip-box"></div>').text(text).appendTo('body');
    tooltip.css({
        display: 'block',
        position: 'absolute',
        top: e.clientY + 12 + window.scrollY,
        left: e.clientX + 12 + window.scrollX,
        zIndex: 99999
    });
});
$(document).off('mousemove.descTooltip').on('mousemove.descTooltip', '.desc-tooltip', function(e) {
    $('.custom-tooltip-box').css({
        top: e.clientY + 12 + window.scrollY,
        left: e.clientX + 12 + window.scrollX
    });
});


$(document).off('.descTooltip');
$(document).on('mouseenter.descTooltip', '.desc-tooltip', function(e) {
    const text = $(this).attr('data-tooltip');
    if (!text) return;
    $('.custom-tooltip-box').remove();
    const tooltip = $('<div class="custom-tooltip-box"></div>').text(text).appendTo('body');
    tooltip.css({
        display: 'block',
        top: e.clientY + 12,
        left: e.clientX + 12
    });
});
$(document).on('mousemove.descTooltip', '.desc-tooltip', function(e) {
    $('.custom-tooltip-box').css({
        top: e.clientY + 12,
        left: e.clientX + 12
    });
});
$(document).on('mouseleave.descTooltip', '.desc-tooltip', function() {
    $('.custom-tooltip-box').remove();
});

// === Robust image preview logic for logo column ===
(function() {
    var $imgPreview = $('<div id="img-hover-preview"></div>').css({
        'position': 'fixed',
        'z-index': 99999,
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
    if (!$('#img-hover-preview').length) $('body').append($imgPreview);

    $(document).off('.imgPreviewer');
    $(document).on('mouseenter.imgPreviewer', '.previewable-img', function(e) {
        var src = $(this).attr('src');
        var alt = $(this).attr('alt') || '';
        $imgPreview.html('<img src="'+src+'" alt="'+alt+'" style="width:96px;height:96px;object-fit:contain;display:block;margin:auto;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.10);">');
        $imgPreview.css({
            'display': 'block',
            'opacity': 1,
            'transform': 'scale(1.08)'
        });
    });
    $(document).on('mousemove.imgPreviewer', '.previewable-img', function(e) {
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
    $(document).on('mouseleave.imgPreviewer', '.previewable-img', function() {
        $imgPreview.css({
            'display': 'none',
            'opacity': 0,
            'transform': 'scale(0.98)'
        });
    });
})();