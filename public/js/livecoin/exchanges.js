"use strict";
function Exchanges(){

}

Exchanges.prototype.init = function () {
    var oTable = $('#livecoin_exchanges').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#livecoin_exchanges_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'png128', name: 'png128'},
            {data: 'markets', name: 'markets'},
            {data: 'volume', name: 'volume'},
            {data: 'bidTotal', name: 'bidTotal'},
            {data: 'askTotal', name: 'askTotal'},
            {data: 'depth', name: 'depth'},
            {data: 'centralized', name: 'centralized'},
            {data: 'usCompliant', name: 'usCompliant'},
            {data: 'visitors', name: 'visitors'},
            {data: 'volumePerVisitor', name: 'volumePerVisitor'}
        ],
        "iDisplayLength": 20,
        pageLength: 10,
        "aaSorting": [[5, "desc"], [6, "desc"], [7, "desc"], [8, "desc"]],
        "fnDrawCallback": function() {
            $('#livecoin_exchanges tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
        },
        infoCallback: function(settings, start, end, max, total, pre) {
            return `\n            <div class=\"datatable-info-beautiful\">\n                <span class=\"datatable-info-icon\">📊</span>\n                <span class=\"datatable-info-text\">\n                    Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries\n                </span>\n            </div>\n        `;
        }
    });
    this.table = oTable;
    // Replace default DataTables filter with custom search bar
    replaceCustomSearchBar(this.table);
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
        highlightSearchResults();
    });
    // Initial highlight
    highlightSearchResults();
    // Loading spinner logic
    $('#livecoin_exchanges').on('processing.dt', function (e, settings, processing) {
        $('#datatableLoading').css('display', processing ? 'block' : 'none');
    });
};

// Highlight search results in the table
function highlightSearchResults() {
    var table = $('#livecoin_exchanges').DataTable();
    var searchTerm = table.search();
    if (!searchTerm) {
        $('#livecoin_exchanges tbody td').each(function() {
            $(this).html($(this).text());
        });
        return;
    }
    var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\]/g, '\\$&')+')', 'gi');
    $('#livecoin_exchanges tbody tr').each(function() {
        var row = $(this);
        var found = false;
        row.find('td').each(function(idx) {
            var cell = $(this);
            var original = cell.text();
            // Skip highlighting for logo column (index 1)
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
            <input type="search" class="form-control" placeholder="Search exchanges..." aria-controls="livecoin_exchanges" style="padding-left:44px;" />
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

Exchanges.prototype.bindEvents = function () {
    // Fullscreen functionality
    const fullscreenBtn = document.getElementById('fullscreenToggle');
    const fullscreenIcon = document.querySelector('#fullscreenIcon .icon-fullscreen');
    const exitFullscreenIcon = document.querySelector('#fullscreenIcon .icon-exit-fullscreen');
    const fullscreenText = document.getElementById('fullscreenText');
    const fullscreenContainer = document.getElementById('datatableFullscreenContainer');

    function isFullscreen() {
        return document.fullscreenElement === fullscreenContainer;
    }

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
            fullscreenIcon.style.display = 'none';
            exitFullscreenIcon.style.display = '';
        } else {
            fullscreenBtn.classList.remove('active');
            fullscreenText.textContent = 'Fullscreen';
            fullscreenIcon.style.display = '';
            exitFullscreenIcon.style.display = 'none';
        }
    });

    // Dark mode functionality
    const darkModeBtn = document.getElementById('darkModeToggle');
    const darkModeText = document.getElementById('darkModeText');
    const darkModeIcon = document.getElementById('darkModeIcon');
    const iconMoon = darkModeIcon.querySelector('.icon-moon');
    const iconSun = darkModeIcon.querySelector('.icon-sun');
    const root = document.documentElement;

    function setDarkMode(enabled) {
        if (enabled) {
            root.classList.add('dark-mode');
            darkModeBtn.setAttribute('aria-checked', 'true');
            darkModeText.textContent = 'Light Mode';
            iconMoon.style.display = 'none';
            iconSun.style.display = '';
            localStorage.setItem('darkMode', '1');
        } else {
            root.classList.remove('dark-mode');
            darkModeBtn.setAttribute('aria-checked', 'false');
            darkModeText.textContent = 'Dark Mode';
            iconMoon.style.display = '';
            iconSun.style.display = 'none';
            localStorage.setItem('darkMode', '0');
        }
    }

    // Initial state
    const darkPref = localStorage.getItem('darkMode');
    setDarkMode(darkPref === '1');

    darkModeBtn.addEventListener('click', function () {
        setDarkMode(!root.classList.contains('dark-mode'));
    });

    // Refresh functionality
    const refreshBtn = document.getElementById('refreshTable');
    refreshBtn.addEventListener('click', function () {
        if ($.fn.DataTable.isDataTable('#livecoin_exchanges')) {
            $('#livecoin_exchanges').DataTable().ajax.reload();
        }
    });
};

$(document).ready(function() {
    var coins = new Exchanges();
    coins.init();
    coins.bindEvents();
});
