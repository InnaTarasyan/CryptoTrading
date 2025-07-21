"use strict";
function Derivatives(){

}

Derivatives.prototype.init = function () {
    var oTable = $('#coingecko_derivatives').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#coingecko_derivatives_route').val(),
        "columns": [
            {data: 'market', name: 'market'},
            {data: 'index_id', name: 'index_id'},
            {data: 'price', name: 'price'},
            {data: 'price_percentage_change_24h', name: 'price_percentage_change_24h'},
            {data: 'contract_type', name: 'contract_type'},
            {data: 'index', name: 'index'},
            {data: 'basis', name: 'basis'},
            {data: 'spread', name: 'spread'},
            {data: 'funding_rate', name: 'funding_rate'},
            {data: 'open_interest', name: 'open_interest'},
            {data: 'volume_24h', name: 'volume_24h'},
            {data: 'last_traded_at', name: 'last_traded_at'},
            {data: 'expired_at', name: 'expired_at'},
        ],
        "iDisplayLength": 20,
        pageLength: 10,
        "aaSorting": [[1, "asc"]],
        "fnDrawCallback": function() {
            $('#coingecko_derivatives tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
        }
    });

    // Replace default DataTables filter with custom search bar (pink gradient)
    const filter = $('.dataTables_filter');
    const customSearch = `
        <div class="search-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#ff6a88" stroke-width="2"/><line x1="16.018" y1="16.4853" x2="21" y2="21.4673" stroke="#ff6a88" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" class="form-control" placeholder="Search derivatives..." aria-controls="coingecko_derivatives" style="padding-left:44px;" />
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
        var table = $('#coingecko_derivatives').DataTable();
        var searchTerm = table.search();
        if (!searchTerm) {
            $('#coingecko_derivatives tbody td').each(function() {
                $(this).html($(this).text());
            });
            return;
        }
        var regex = new RegExp('('+searchTerm.replace(/[.*+?^${}()|[\\]\]/g, '\\$&')+')', 'gi');
        $('#coingecko_derivatives tbody tr').each(function() {
            var row = $(this);
            var found = false;
            row.find('td').each(function(idx) {
                var cell = $(this);
                var original = cell.text();
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

    // ======================== Responsive DataTable: Add data-labels for mobile ========================
    function setDerivativesDataLabels() {
        var headers = [];
        $('#coingecko_derivatives thead th').each(function() {
            headers.push($(this).text().trim());
        });
        $('#coingecko_derivatives tbody tr').each(function() {
            $(this).find('td').each(function(i) {
                if (headers[i]) $(this).attr('data-label', headers[i]);
            });
        });
    }
    setDerivativesDataLabels();
    oTable.on('draw', setDerivativesDataLabels);
};

Derivatives.prototype.bindEvents = function () {

};

// --- Derivatives Reviews Logic ---
function getInitials(name) {
    if (!name) return '?';
    return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0,2);
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
    fetch('/coingecko/derivatives/reviews')
        .then(res => res.json())
        .then(data => renderReviews(data))
        .catch(() => {
            const reviewsList = document.getElementById('reviews-list');
            if (reviewsList) reviewsList.innerHTML = '<div class="alert alert-danger">Could not load reviews.</div>';
        });
}
document.addEventListener('DOMContentLoaded', function() {
    fetchReviews();
    const form = document.getElementById('reviewForm');
    if (form) {
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
});

$(document).ready(function() {
    var coins = new Derivatives();
    coins.init();
    coins.bindEvents();
});
