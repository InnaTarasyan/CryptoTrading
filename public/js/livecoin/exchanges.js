"use strict";
function Exchanges(){

}

Exchanges.prototype.init = function () {
    var columnLabels = [
        'Name', 'Image', 'Markets', 'Volume', 'BidTotal', 'AskTotal', 'Depth', 'Centralized', 'UsCompliant', 'Visitors', 'Volume Per Visitor'
    ];
    var oTable = $('#livecoin_exchanges').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#livecoin_exchanges_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'png128', name: 'png128', render: function(data, type, row) {
                if (!data) return '<div style="width:32px;height:32px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:16px;color:#64748b;margin:0 auto;">🪙</div>';
                return '<img src="'+data+'" alt="Exchange Logo" class="previewable-img" style="width:32px;height:32px;object-fit:contain;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.07);margin:0 auto;display:block;" onerror="this.style.display=\'none\';this.parentNode.innerHTML=\'<div style=\\\'width:32px;height:32px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:16px;color:#64748b;margin:0 auto;\\\'>🪙</div>\';">';
            }},
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
        responsive: false,
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
        "createdRow": function(row, data, dataIndex) {
            // Add data-label attributes for mobile view
            $('td', row).each(function(index) {
                $(this).attr('data-label', columnLabels[index]);
            });
        },
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
    });
    // Always highlight after draw (pagination, search, etc)
    this.table.on('draw.dt', function() {
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
            // Only reset text for non-image columns
            if ($(this).index() !== 1) {
                $(this).html($(this).text());
            }
        });
        $('#livecoin_exchanges tbody tr').removeClass('highlight-row');
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
                // If cell contains an image, leave as is
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

    // Modern Refresh button logic
    var refreshBtn = $('#refreshTable');
    var spinner = refreshBtn.find('.refresh-spinner');
    var label = refreshBtn.find('.refresh-btn-label');
    var icon = refreshBtn.find('.icon-refresh');
    var table = $('#livecoin_exchanges').DataTable();

    function setRefreshing(isRefreshing) {
        if (isRefreshing) {
            spinner.show();
            icon.hide();
            refreshBtn.attr('aria-busy', 'true').attr('aria-disabled', 'true').prop('disabled', true);
        } else {
            spinner.hide();
            icon.show();
            refreshBtn.attr('aria-busy', 'false').attr('aria-disabled', 'false').prop('disabled', false);
        }
    }

    refreshBtn.on('click', function() {
        setRefreshing(true);
        table.ajax.reload(function() {
            setRefreshing(false);
        }, false);
    });

    // Also listen to DataTable processing event for external reloads
    table.on('processing.dt', function(e, settings, processing) {
        setRefreshing(processing);
    });
};

// --- Review Section Logic ---
function getInitials(name) {
    if (!name) return '';
    const parts = name.trim().split(' ');
    if (parts.length === 1) return parts[0][0].toUpperCase();
    return (parts[0][0] + parts[parts.length-1][0]).toUpperCase();
}

function renderReviews(reviews) {
    let html = '';
    if (!reviews || reviews.length === 0) {
        html = '<div class="alert alert-info">No reviews yet. Be the first to review!</div>';
    } else {
        html = reviews.map(r => `
            <div class="modern-review-card">
                <div class="modern-review-avatar">${getInitials(r.name)}</div>
                <div class="modern-review-content">
                    <div class="modern-review-header">
                        <span class="modern-review-name">${r.name}</span>
                        <span class="modern-review-date"><svg style="width:1em;height:1em;vertical-align:middle;margin-right:0.2em;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M12 6v6l4 2" stroke="#43cea2" stroke-width="2" stroke-linecap="round"/></svg> ${new Date(r.created_at).toLocaleString()}</span>
                        <span class="modern-review-rating">${'★'.repeat(r.rating)}${'☆'.repeat(5 - r.rating)}</span>
                    </div>
                    <div class="modern-review-title">${r.title}</div>
                    <div class="modern-review-comment">${r.comment.replace(/\n/g, '<br>')}</div>
                    <div class="modern-review-extra">
                        ${r.country ? `<b>Country:</b> ${r.country} &nbsp;` : ''}
                        ${r.experience_level ? `<b>Experience:</b> ${r.experience_level} &nbsp;` : ''}
                        ${r.pros ? `<b>Pros:</b> ${r.pros} &nbsp;` : ''}
                        ${r.cons ? `<b>Cons:</b> ${r.cons} &nbsp;` : ''}
                        ${typeof r.recommend !== 'undefined' && r.recommend !== null ? `<b>Recommend:</b> ${r.recommend ? 'Yes' : 'No'}` : ''}
                    </div>
                </div>
            </div>
        `).join('');
    }
    const reviewsList = document.getElementById('reviews-list');
    if (reviewsList) reviewsList.innerHTML = html;
}

function fetchReviews() {
    fetch('/livecoinwatch/exchanges/reviews')
        .then(res => res.json())
        .then(data => renderReviews(data));
}

function bindReviewForm() {
    const form = document.getElementById('reviewForm');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        const csrfToken = document.querySelector('input[name="_token"]').value;
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                form.reset();
                document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-success">Thank you for your review!</div>';
                fetchReviews();
            } else {
                document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-danger">There was an error submitting your review.</div>';
            }
        })
        .catch(() => {
            document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-danger">There was an error submitting your review.</div>';
        });
    });
}

$(document).ready(function() {
    var coins = new Exchanges();
    coins.init();
    coins.bindEvents();

    // Image preview logic (copied from history.js for consistency)
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

    fetchReviews();
    bindReviewForm();
});
