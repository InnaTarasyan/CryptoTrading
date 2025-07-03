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
        "createdRow": function(row, data, dataIndex) {
            var labels = ['Fiat', 'Flag', 'Countries'];
            $('td', row).each(function(index) {
                $(this).attr('data-label', labels[index]);
            });
        },
        "fnDrawCallback": function() {
            $('#livecoin_fiats tbody tr').click(function () {
                var coin = $(this).find('.id').val();
                window.location.href = "/details/" + coin;
            });
        },
        infoCallback: function(settings, start, end, max, total, pre) {
            return `\n            <div class=\"datatable-info-beautiful\">\n                <span class=\"datatable-info-icon\">💱</span>\n                <span class=\"datatable-info-text\">\n                    Showing <strong>${start}</strong> to <strong>${end}</strong> of <strong>${total.toLocaleString()}</strong> entries\n                </span>\n            </div>\n        `;
        }
    });
    // Add custom search bar after DataTable initialization
    replaceCustomSearchBar(oTable);
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

$(document).ready(function() {
    var coins = new Fiats();
    coins.init();
    coins.bindEvents();

    // Fetch and render reviews
    function fetchFiatReviews() {
        $.get('/livecoinwatch/fiats/reviews?fiat_code=all', function(reviews) {
            var $list = $('#fiat-reviews-list');
            $list.empty();
            if (!reviews.length) {
                $list.append('<div class="review-card">No reviews yet. Be the first to review!</div>');
                return;
            }
            reviews.forEach(function(review) {
                $list.append(renderFiatReviewCard(review));
            });
        });
    }

    function renderFiatReviewCard(review) {
        var stars = '';
        for (var i = 0; i < review.rating; i++) {
            stars += '<span class="review-rating">★</span>';
        }
        for (var i = review.rating; i < 5; i++) {
            stars += '<span class="review-rating" style="color:#eee;">★</span>';
        }
        return `
        <div class="review-card">
            <div class="review-header">
                <span class="review-rating">${stars}</span>
                <span class="review-title">${escapeHtml(review.title)}</span>
            </div>
            <div class="review-meta">
                <span><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" fill="#ffd200"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4" stroke="#ff512f" stroke-width="2"/></svg> ${escapeHtml(review.name)}</span>
                <span><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ffd200"/><path d="M2 6l10 7 10-7" stroke="#43cea2" stroke-width="2"/></svg> ${escapeHtml(review.country || 'N/A')}</span>
                <span><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#ffd200" stroke-width="2"/></svg> ${escapeHtml(review.experience_level || 'N/A')}</span>
            </div>
            <div class="review-body">${escapeHtml(review.comment)}</div>
            ${review.pros ? `<div class="review-pros"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#ffd200" stroke-width="2"/></svg> <b>Pros:</b> ${escapeHtml(review.pros)}</div>` : ''}
            ${review.cons ? `<div class="review-cons"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#ffd200"/><path d="M8 12h8M8 16h4" stroke="#43cea2" stroke-width="2"/></svg> <b>Cons:</b> ${escapeHtml(review.cons)}</div>` : ''}
            <div class="review-footer">
                <span class="review-recommend${review.recommend === 0 ? ' no' : ''}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#ffd200" stroke-width="2"/></svg>
                    ${review.recommend === 1 ? 'Recommended' : 'Not recommended'}
                </span>
                <span><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" fill="#ffd200"/></svg> ${review.rating}/5</span>
                <span>${new Date(review.created_at).toLocaleDateString()}</span>
            </div>
        </div>
        `;
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text.replace(/[&<>"']/g, function (c) {
            return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[c];
        });
    }

    // Handle review form submission
    $('#fiatReviewForm').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $msg = $('#fiatReviewFormMsg');
        $msg.text('');
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            headers: {'X-CSRF-TOKEN': $form.find('input[name="_token"]').val()},
            success: function(res) {
                $msg.css('color', '#43cea2').text('Thank you for your review!');
                $form[0].reset();
                fetchFiatReviews();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON && xhr.responseJSON.errors;
                if (errors) {
                    $msg.css('color', '#ff512f').html(Object.values(errors).map(function(e){return e;}).join('<br>'));
                } else {
                    $msg.css('color', '#ff512f').text('An error occurred. Please try again.');
                }
            }
        });
    });

    // Initial fetch
    fetchFiatReviews();
});
