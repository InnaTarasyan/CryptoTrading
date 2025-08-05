// Patch to prevent Metronic header JS error if mHeader is missing
if (typeof $.fn.mHeader !== 'function') {
    $.fn.mHeader = function() { return this; };
} 