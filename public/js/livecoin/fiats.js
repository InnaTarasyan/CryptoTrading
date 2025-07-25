"use strict";
function Fiats(){

}

Fiats.prototype.init = function () {
    var oTable = $('#livecoin_fiats').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#livecoin_fiats_route').val(),
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'countries', name: 'countries'},
            {data: 'flag', name: 'flag'},
        ],
        "iDisplayLength": 20,
        pageLength: 10,
        "aaSorting": [[1, "asc"]],
        dom: "<'datatable-toolbar'B><'datatable-controls-row'lf>rtip",
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
            var labels = ['Fiat', 'Flag', 'Countries'];
            $('td', row).each(function(index) {
                $(this).attr('data-label', labels[index]);
            });
        },
        // "fnDrawCallback": function() {
        //     $('#livecoin_fiats tbody tr').click(function () {
        //         var coin = $(this).find('.id').val();
        //         window.location.href = "/details/" + coin;
        //     });
        // },
        infoCallback: function(settings, start, end, max, total, pre) {
            return `\n            <div class=\"datatable-info-beautiful\">\n                <span class=\"datatable-info-icon\">💱</span>\n                <span class=\"datatable-info-text\">\n                    Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries\n                </span>\n            </div>\n        `;
        }
    });
    // Add custom search bar after DataTable initialization
    replaceCustomSearchBar(oTable);

    // Highlight search results after every draw
    oTable.on('draw.dt', function() {
        highlightSearchResultsFiats();
    });
    // Initial highlight
    highlightSearchResultsFiats();
};

Fiats.prototype.bindEvents = function () {

};

// Replace default DataTables filter with custom search bar (copied/adapted from history.js)
function replaceCustomSearchBar(table) {
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="search-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#f7971e" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#f7971e" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" class="form-control" placeholder="Search fiats..." aria-controls="livecoin_fiats" style="padding-left:44px;" />
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

// Highlight search results in the fiats table
function highlightSearchResultsFiats() {
    var table = $('#livecoin_fiats').DataTable();
    var searchTerm = table.search();
    if (!searchTerm) {
        $('#livecoin_fiats tbody td').each(function() {
            // Only reset text for non-flag columns
            if ($(this).index() !== 1) {
                $(this).html($(this).text());
            }
        });
        $('#livecoin_fiats tbody tr').removeClass('highlight-row');
        return;
    }
    var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')+')', 'gi');
    $('#livecoin_fiats tbody tr').each(function() {
        var row = $(this);
        var found = false;
        row.find('td').each(function(idx) {
            var cell = $(this);
            var original = cell.text();
            // Skip highlighting for flag column (index 1)
            if (idx === 1) {
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

// --- Review Section Logic ---
function getInitials(name) {
    if (!name) return '';
    const parts = name.trim().split(' ');
    if (parts.length === 1) return parts[0][0].toUpperCase();
    return (parts[0][0] + parts[parts.length-1][0]).toUpperCase();
}

function renderFiatReviews(reviews) {
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
                        <span class="modern-review-date"><svg style="width:1em;height:1em;vertical-align:middle;margin-right:0.2em;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M12 6v6l4 2" stroke="#ff512f" stroke-width="2" stroke-linecap="round"/></svg> ${new Date(r.created_at).toLocaleString()}</span>
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
    const reviewsList = document.getElementById('fiat-reviews-list');
    if (reviewsList) reviewsList.innerHTML = html;
}

function fetchFiatReviews() {
    fetch('/livecoinwatch/fiats/reviews')
        .then(res => res.json())
        .then(data => renderFiatReviews(data));
}

function bindFiatReviewForm() {
    const form = document.getElementById('fiatReviewForm');
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
                document.getElementById('fiatReviewFormMsg').innerHTML = '<div class="alert alert-success">Thank you for your review!</div>';
                fetchFiatReviews();
            } else {
                document.getElementById('fiatReviewFormMsg').innerHTML = '<div class="alert alert-danger">There was an error submitting your review.</div>';
            }
        })
        .catch(() => {
            document.getElementById('fiatReviewFormMsg').innerHTML = '<div class="alert alert-danger">There was an error submitting your review.</div>';
        });
    });
}

$(document).ready(function() {
    var coins = new Fiats();
    coins.init();
    coins.bindEvents();
    fetchFiatReviews();
    bindFiatReviewForm();
});
