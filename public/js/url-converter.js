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

// Run on page load
document.addEventListener('DOMContentLoaded', convertUrlsToLinks);

// Run after any dynamic content is loaded
setTimeout(convertUrlsToLinks, 1000);

// Also run when new content is added dynamically
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.type === 'childList') {
            convertUrlsToLinks();
        }
    });
});

// Start observing
observer.observe(document.body, {
    childList: true,
    subtree: true
}); 