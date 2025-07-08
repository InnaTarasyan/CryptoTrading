"use strict";
function CoingeckoExchanges(){

}

CoingeckoExchanges.prototype.init = function () {
    var oTable = $('#coingecko_exchanges').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: $('#coingecko_exchanges_route').val(),
            dataSrc: function(json) {
                if (!json || typeof json !== 'object' || !Array.isArray(json.data)) {
                    // Optionally show an error to the user here
                    return [];
                }
                return json.data;
            }
        },
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'image', name: 'image'},
            {data: 'url', name: 'url'},
            {data: 'year_established', name: 'year_established'},
            {data: 'country', name: 'country'},
            {data: 'description', name: 'description'},
            {data: 'trust_score', name: 'trust_score'},
            {data: 'trust_score_rank', name: 'trust_score_rank'},
           // {data: 'trade_volume_24h_btc_normalized', name: 'trade_volume_24h_btc_normalized'},
            {data: 'has_trading_incentive', name: 'has_trading_incentive'},
        ],
        "iDisplayLength": 5,
        pageLength: 10,
        "aaSorting": [[1, "asc"]],
        "infoCallback": function(settings, start, end, max, total, pre) {
            return `\n                <div class=\"datatable-info-beautiful pinky-gradient\">\n                    <span class=\"datatable-info-icon\">💖</span>\n                    <span class=\"datatable-info-text\">\n                        Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries\n                    </span>\n                </div>\n            `;
        },
        "fnDrawCallback": function() {
            $('#coingecko_exchanges tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
        }
    });

    // Custom search bar (match markets.js style)
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="search-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#ff6a88" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#ff6a88" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" class="form-control" placeholder="Search exchanges..." aria-controls="coingecko_exchanges" style="padding-left:44px; background:#fff6fa; border:1.5px solid #ff6a88; border-radius:24px; color:#ff6a88; font-size:15px; box-shadow:0 2px 8px rgba(255,106,136,0.08); transition:border 0.2s, box-shadow 0.2s; width:100%;" />
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
        var table = $('#coingecko_exchanges').DataTable();
        var searchTerm = table.search();
        if (!searchTerm) {
            $('#coingecko_exchanges tbody td').each(function() {
                $(this).html($(this).text());
            });
            return;
        }
        var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\\]/g, '\\$&')+')', 'gi');
        $('#coingecko_exchanges tbody tr').each(function() {
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
    oTable.on('draw', highlightSearchResults);
    searchBox.on('input', highlightSearchResults);
    filter.on('click', '#clear-search', highlightSearchResults);

    // ======================== Add data-labels for mobile responsiveness ========================
    function setDataLabels() {
        var columnLabels = [
            'Name',
            'Image',
            'URL',
            'Year Established',
            'Country',
            'Description',
            'Trust score',
            'Trust score rank',
            'Has trading incentive'
        ];
        $('#coingecko_exchanges tbody tr').each(function() {
            $(this).find('td').each(function(index) {
                $(this).attr('data-label', columnLabels[index]);
            });
        });
    }
    oTable.on('draw', setDataLabels);
};

CoingeckoExchanges.prototype.bindEvents = function () {
    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function () {
            const isDark = document.body.classList.toggle('dark-mode');
            // Update icon and status
            const iconMoon = darkModeToggle.querySelector('.icon-moon');
            const iconSun = darkModeToggle.querySelector('.icon-sun');
            if (isDark) {
                iconMoon.style.display = 'none';
                iconSun.style.display = '';
                darkModeToggle.setAttribute('aria-checked', 'true');
                document.getElementById('darkModeText').textContent = 'Light Mode';
                document.getElementById('darkModeStatus').textContent = 'Dark mode enabled';
            } else {
                iconMoon.style.display = '';
                iconSun.style.display = 'none';
                darkModeToggle.setAttribute('aria-checked', 'false');
                document.getElementById('darkModeText').textContent = 'Dark Mode';
                document.getElementById('darkModeStatus').textContent = 'Light mode enabled';
            }
        });
    }

    // Refresh Button
    const refreshBtn = document.getElementById('refreshTable');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function () {
            refreshBtn.setAttribute('aria-busy', 'true');
            refreshBtn.setAttribute('aria-disabled', 'true');
            // Show spinner if desired
            const table = $('#coingecko_exchanges').DataTable();
            table.ajax.reload(function () {
                refreshBtn.setAttribute('aria-busy', 'false');
                refreshBtn.setAttribute('aria-disabled', 'false');
            }, false);
        });
    }

    // Fullscreen Button
    const fullscreenBtn = document.getElementById('fullscreenToggle');
    const fullscreenContainer = document.getElementById('datatableFullscreenContainer');
    if (fullscreenBtn && fullscreenContainer) {
        fullscreenBtn.addEventListener('click', function () {
            if (!document.fullscreenElement) {
                if (fullscreenContainer.requestFullscreen) {
                    fullscreenContainer.requestFullscreen();
                }
                fullscreenContainer.classList.add('fullscreen-active');
                fullscreenBtn.setAttribute('aria-pressed', 'true');
                fullscreenBtn.querySelector('.icon-fullscreen').style.display = 'none';
                fullscreenBtn.querySelector('.icon-exit-fullscreen').style.display = '';
                document.getElementById('fullscreenText').textContent = 'Exit Fullscreen';
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        });
        document.addEventListener('fullscreenchange', function () {
            if (!document.fullscreenElement) {
                fullscreenContainer.classList.remove('fullscreen-active');
                fullscreenBtn.setAttribute('aria-pressed', 'false');
                fullscreenBtn.querySelector('.icon-fullscreen').style.display = '';
                fullscreenBtn.querySelector('.icon-exit-fullscreen').style.display = 'none';
                document.getElementById('fullscreenText').textContent = 'Fullscreen';
            }
        });
    }
};

$(document).ready(function() {
    var coins = new CoingeckoExchanges();
    coins.init();
    coins.bindEvents();
});
