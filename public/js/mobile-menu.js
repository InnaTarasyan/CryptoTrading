/* Mobile Menu JavaScript Functionality */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Mobile menu script loaded');
    
    // Mobile menu toggle functionality
    const mobileMenuToggles = document.querySelectorAll('.mobile-menu-toggle');
    console.log('Found mobile menu toggles:', mobileMenuToggles.length);
    
    mobileMenuToggles.forEach(toggle => {
        console.log('Setting up toggle:', toggle);
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Toggle clicked:', this.getAttribute('data-toggle'));
            
            const targetId = this.getAttribute('data-toggle');
            const submenu = document.getElementById(targetId);
            const arrow = this.querySelector('.mobile-menu-arrow');
            
            console.log('Target submenu:', submenu);
            
            // Close other open submenus
            document.querySelectorAll('.mobile-submenu.show').forEach(openSubmenu => {
                if (openSubmenu !== submenu) {
                    openSubmenu.classList.remove('show');
                    const otherToggle = openSubmenu.previousElementSibling;
                    if (otherToggle && otherToggle.classList.contains('mobile-menu-toggle')) {
                        otherToggle.classList.remove('active');
                    }
                }
            });
            
            // Toggle current submenu
            submenu.classList.toggle('show');
            this.classList.toggle('active');
            
            // Animate arrow
            if (arrow) {
                arrow.style.transform = submenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });
    
    // Mobile language switcher functionality
    const mobileLanguageOptions = document.querySelectorAll('.language-option-mobile');
    console.log('Found language options:', mobileLanguageOptions.length);
    
    mobileLanguageOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Language option clicked');
            
            const lang = this.closest('.mobile-submenu-item').getAttribute('data-lang');
            const flag = this.closest('.mobile-submenu-item').getAttribute('data-flag');
            const languageName = this.querySelector('span:last-child').textContent;
            
            console.log('Language selected:', lang, flag, languageName);
            
            // Update desktop language switcher if it exists
            const desktopLanguageBtn = document.getElementById('currentLanguageBtn');
            const desktopLanguageName = document.getElementById('currentLanguage');
            const desktopFlag = document.getElementById('currentFlag');
            
            if (desktopLanguageBtn && desktopLanguageName && desktopFlag) {
                desktopLanguageName.textContent = languageName;
                // Update flag SVG based on selected language
                updateFlagSvg(desktopFlag, flag);
            }
            
            // Close mobile submenu
            const submenu = this.closest('.mobile-submenu');
            const toggle = submenu.previousElementSibling;
            
            if (submenu && toggle) {
                submenu.classList.remove('show');
                toggle.classList.remove('active');
                const arrow = toggle.querySelector('.mobile-menu-arrow');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
            
            // Handle language change - same logic as desktop language switcher
            handleLanguageChange(lang, flag, languageName);
            
            // Optional: Add visual feedback
            this.style.background = '#eff6ff';
            this.style.color = '#1d4ed8';
            
            setTimeout(() => {
                this.style.background = '';
                this.style.color = '';
            }, 300);
        });
    });
    
    // Function to handle language change (same as desktop)
    function handleLanguageChange(lang, flag, languageName) {
        console.log('Language changed to:', lang);
        
        // Update mobile menu language text
        const mobileLanguageToggle = document.querySelector('.mobile-menu-toggle[data-toggle="language-submenu"]');
        if (mobileLanguageToggle) {
            const mobileLanguageText = mobileLanguageToggle.querySelector('.mobile-menu-text');
            if (mobileLanguageText) {
                mobileLanguageText.textContent = 'Language';
            }
        }
        
        // Trigger custom event for language change
        const languageChangeEvent = new CustomEvent('languageChanged', {
            detail: {
                language: lang,
                flag: flag,
                languageName: languageName
            }
        });
        document.dispatchEvent(languageChangeEvent);
        
        // You can add your language change logic here
        // For example, making an AJAX request to change the language
        // or updating the page URL with the new language parameter
        
        // Example AJAX call (uncomment if you have a language change endpoint)
        /*
        fetch('/change-language', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content')
            },
            body: JSON.stringify({
                language: lang
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload page or update content
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error changing language:', error);
        });
        */
        
        // For now, just log the change
        console.log(`Language changed to ${languageName} (${lang})`);
    }
    
    // Function to update flag SVG
    function updateFlagSvg(flagElement, flagType) {
        const flagSvgs = {
            'us': `<svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                <rect width="20" height="15" fill="#1E40AF"/>
                <rect width="20" height="3" fill="#FFFFFF"/>
                <rect y="6" width="20" height="3" fill="#FFFFFF"/>
                <rect y="12" width="20" height="3" fill="#FFFFFF"/>
                <rect width="10" height="8" fill="#DC2626"/>
                <g fill="#FFFFFF">
                    <polygon points="2,1 2.5,2.5 4,2 3.5,3.5 5,4 3.5,4.5 4,6 2.5,5.5 2,7 1.5,5.5 0,6 0.5,4.5 -1,4 0.5,3.5"/>
                </g>
            </svg>`,
            'ru': `<svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                <rect width="20" height="15" fill="#FFFFFF"/>
                <rect y="5" width="20" height="5" fill="#0052CC"/>
                <rect y="10" width="20" height="5" fill="#DC2626"/>
            </svg>`,
            'am': `<svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                <rect width="20" height="5" fill="#0052CC"/>
                <rect y="5" width="20" height="5" fill="#FFD700"/>
                <rect y="10" width="20" height="5" fill="#DC2626"/>
            </svg>`,
            'fi': `<svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                <rect width="20" height="15" fill="#FFFFFF"/>
                <rect width="3" height="15" fill="#0052CC"/>
                <rect y="5" width="20" height="3" fill="#0052CC"/>
            </svg>`
        };
        
        if (flagSvgs[flagType]) {
            flagElement.innerHTML = flagSvgs[flagType];
        }
    }
    
    // Close mobile submenus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.mobile-menu-item')) {
            document.querySelectorAll('.mobile-submenu.show').forEach(submenu => {
                submenu.classList.remove('show');
                const toggle = submenu.previousElementSibling;
                if (toggle && toggle.classList.contains('mobile-menu-toggle')) {
                    toggle.classList.remove('active');
                    const arrow = toggle.querySelector('.mobile-menu-arrow');
                    if (arrow) {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                }
            });
        }
    });
    
    // Handle escape key to close submenus
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.mobile-submenu.show').forEach(submenu => {
                submenu.classList.remove('show');
                const toggle = submenu.previousElementSibling;
                if (toggle && toggle.classList.contains('mobile-menu-toggle')) {
                    toggle.classList.remove('active');
                    const arrow = toggle.querySelector('.mobile-menu-arrow');
                    if (arrow) {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                }
            });
        }
    });
}); 