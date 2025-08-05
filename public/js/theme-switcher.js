document.addEventListener('DOMContentLoaded', function () {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleIcon = document.getElementById('theme-toggle-icon');
    const themeToggleText = document.getElementById('theme-toggle-text');
    const darkThemeCss = document.getElementById('dark-theme-css');

    // Helper to set theme
    function setTheme(isDark) {
        if (isDark) {
            darkThemeCss.removeAttribute('disabled');
            themeToggleIcon.textContent = '☀️';
            themeToggleText.textContent = 'Light Mode';
            document.body.classList.add('dark-mode');
        } else {
            darkThemeCss.setAttribute('disabled', 'true');
            themeToggleIcon.textContent = '🌙';
            themeToggleText.textContent = 'Dark Mode';
            document.body.classList.remove('dark-mode');
        }
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    // Initial theme
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        setTheme(true);
    } else {
        setTheme(false);
    }

    // Toggle on button click
    themeToggleBtn.addEventListener('click', function () {
        const isDark = darkThemeCss.hasAttribute('disabled');
        setTheme(isDark);
    });
}); 