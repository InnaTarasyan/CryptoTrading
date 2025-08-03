"use strict";

// --- Auto-convert URLs to clickable links in timeline text ---
function convertUrlsToLinks() {
    const timelineTexts = document.querySelectorAll('.m-timeline-2__item-text');
    
    timelineTexts.forEach(function(element) {
        // Skip if already processed
        if (element.dataset.linksProcessed) return;
        
        // Convert URLs to clickable links
        const urlRegex = /(https?:\/\/[^\s]+)/g;
        element.innerHTML = element.innerHTML.replace(urlRegex, function(url) {
            return '<a href="' + url + '" target="_blank" rel="noopener noreferrer">' + url + '</a>';
        });
        
        // Mark as processed
        element.dataset.linksProcessed = 'true';
    });
}

function Base() {
}

Base.prototype.bindEvents = function () {
    $(document).on('click', '#updateAllData', this.updateAll.bind(this));
};

Base.prototype.updateAll = function (event) {
    var btn = $('#updateAllData');
    var spinner = $('#updateAllDataSpinner');
    var btnText = $('#updateAllDataText');
    btn.attr('aria-busy', 'true').prop('disabled', true);
    spinner.show();
    btnText.text('Updating Data ...');

    $.ajax({
        type: 'Get',
        url: 'reloadData',
        success: function (res) {
            btn.attr('aria-busy', 'false').prop('disabled', false);
            spinner.hide();
            btnText.text('Update All Data');
        },
        error: function (res) {
            btn.attr('aria-busy', 'false').prop('disabled', false);
            spinner.hide();
            btnText.text('Update All Data');
        }
    });
};

$(document).ready(function() {
    var base = new Base();
    base.bindEvents();
    
    // Convert URLs to clickable links
    convertUrlsToLinks();
    
    // Run after any dynamic content is loaded
    setTimeout(convertUrlsToLinks, 1000);
});