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

// --- Calendar Fullscreen Functionality ---
function initCalendarFullscreen() {
    const calendarPortlet = document.getElementById('m_portlet_calendar');
    
    if (!calendarPortlet) return;
    
    // Create and insert the fullscreen button
    createFullscreenButton();
    
    const calendarFullscreenBtn = document.getElementById('calendarFullscreenBtn');
    
    if (!calendarFullscreenBtn) return;
    
    let isFullscreen = false;
    
    calendarFullscreenBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (!isFullscreen) {
            enterFullscreen();
        } else {
            exitFullscreen();
        }
    });
    
    // Keyboard support
    calendarFullscreenBtn.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            calendarFullscreenBtn.click();
        }
    });
    
    // ESC key to exit fullscreen
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isFullscreen) {
            exitFullscreen();
        }
    });
    
    function createFullscreenButton() {
        const headTools = calendarPortlet.querySelector('.m-portlet__head-tools .m-portlet__nav');
        
        if (headTools && !document.getElementById('calendarFullscreenBtn')) {
            const fullscreenBtn = document.createElement('li');
            fullscreenBtn.className = 'm-portlet__nav-item';
            fullscreenBtn.innerHTML = `
                <button id="calendarFullscreenBtn" class="m-portlet__nav-link m-portlet__nav-link--icon calendar-fullscreen-btn" title="Full Screen" aria-label="Full Screen Calendar" type="button">
                    <i class="la la-expand"></i>
                </button>
            `;
            
            // Insert before the existing collapse button
            const existingNavItem = headTools.querySelector('.m-portlet__nav-item');
            if (existingNavItem) {
                headTools.insertBefore(fullscreenBtn, existingNavItem);
            } else {
                headTools.appendChild(fullscreenBtn);
            }
        }
    }
    
    function enterFullscreen() {
        isFullscreen = true;
        calendarPortlet.classList.add('fullscreen-active');
        calendarFullscreenBtn.classList.add('fullscreen-active');
        calendarFullscreenBtn.querySelector('i').className = 'la la-compress';
        calendarFullscreenBtn.setAttribute('title', 'Exit Full Screen');
        calendarFullscreenBtn.setAttribute('aria-label', 'Exit Full Screen Calendar');
        
        // Disable body scroll
        document.body.style.overflow = 'hidden';
        
        // Focus management
        calendarFullscreenBtn.focus();
        
        // Announce to screen readers
        announceToScreenReader('Calendar entered full screen mode');
    }
    
    function exitFullscreen() {
        isFullscreen = false;
        calendarPortlet.classList.remove('fullscreen-active');
        calendarFullscreenBtn.classList.remove('fullscreen-active');
        calendarFullscreenBtn.querySelector('i').className = 'la la-expand';
        calendarFullscreenBtn.setAttribute('title', 'Full Screen');
        calendarFullscreenBtn.setAttribute('aria-label', 'Full Screen Calendar');
        
        // Re-enable body scroll
        document.body.style.overflow = '';
        
        // Focus management
        calendarFullscreenBtn.focus();
        
        // Announce to screen readers
        announceToScreenReader('Calendar exited full screen mode');
    }
    
    function announceToScreenReader(message) {
        const announcement = document.createElement('div');
        announcement.setAttribute('aria-live', 'polite');
        announcement.setAttribute('aria-atomic', 'true');
        announcement.style.position = 'absolute';
        announcement.style.left = '-10000px';
        announcement.style.width = '1px';
        announcement.style.height = '1px';
        announcement.style.overflow = 'hidden';
        announcement.textContent = message;
        
        document.body.appendChild(announcement);
        
        setTimeout(() => {
            document.body.removeChild(announcement);
        }, 1000);
    }
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
    
    // Initialize calendar fullscreen functionality
    initCalendarFullscreen();
    
    // Run after any dynamic content is loaded
    setTimeout(convertUrlsToLinks, 1000);
});