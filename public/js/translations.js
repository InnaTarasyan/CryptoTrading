// Translation Helper for Crypto Trading Platform
class TranslationHelper {
    constructor() {
        this.currentLanguage = 'en';
        this.translations = {
            en: {
                // Main Navigation
                'dashboard': 'Dashboard',
                'about': 'About',
                'language': 'Language',
                'trading_tutorials': 'Trading Tutorials',
                
                // Dashboard Submenu
                'live_coin_watch': 'Live Coin Watch',
                'coingecko': 'Coingecko',
                'coin_market_cal': 'Coin Market Cal',
                
                // Page Titles
                'livecoin_history': 'Livecoin History',
                'exchanges': 'Exchanges',
                'fiats': 'Fiats',
                
                // Action Buttons
                'refresh': 'Refresh',
                'fullscreen': 'Fullscreen',
                'dark_mode': 'Dark Mode',
                
                // Table Headers
                'coin': 'Coin',
                'logo': 'Logo',
                'rate': 'Rate',
                'age': 'Age',
                'pairs': 'Pairs',
                'volume_24h': 'Volume (24h)',
                'market_cap': 'Market Cap',
                'rank': 'Rank',
                'markets': 'Markets',
                'total_supply': 'Total Supply',
                'max_supply': 'Max Supply',
                'circulating_supply': 'Circulating Supply',
                'all_time_high': 'All-Time High',
                'categories': 'Categories',
                
                // Content Sections
                'about_live_coin_watch': 'About Live Coin Watch',
                'visit_live_coin_watch': 'Visit Live Coin Watch',
                'user_reviews': 'User Reviews',
                'leave_a_review': 'Leave a Review',
                
                // Form Fields
                'name': 'Name',
                'email': 'Email',
                'rating': 'Rating',
                'title': 'Title',
                'comment': 'Comment',
                'submit_review': 'Submit Review',
                
                // Rating Options
                'select': 'Select',
                'poor': '1 - Poor',
                'fair': '2 - Fair',
                'good': '3 - Good',
                'very_good': '4 - Very Good',
                'excellent': '5 - Excellent',
                
                // Tutorial Links
                'binance_guide': 'Binance Guide',
                'crypto_trading': 'Crypto Trading',
                'crypto_basics': 'Crypto Basics',
                'trading_strategy': 'Trading Strategy',
                'learn_center': 'Learn Center',
                'chart_analysis': 'Chart Analysis',
                
                // Common Words
                'platform': 'Platform',
                
                // Social Media & Additional Menu Items
                'twitter': 'Twitter',
                'twitter_account': 'Twitter Account',
                'telegram': 'Telegram',
                'telegram_account': 'Telegram Account',
                'trading_pair': 'Trading Pair',
                
                // Button Text
                'update_all_data': 'Update All Data',
                
                // DataTable Buttons
                'copy': 'Copy',
                'csv': 'CSV',
                'excel': 'Excel',
                'pdf': 'PDF',
                'print': 'Print',
                'columns': 'Columns',
            },
            ru: {
                // Main Navigation
                'dashboard': 'Панель управления',
                'about': 'О нас',
                'language': 'Язык',
                'trading_tutorials': 'Учебники по торговле',
                
                // Dashboard Submenu
                'live_coin_watch': 'Live Coin Watch',
                'coingecko': 'Coingecko',
                'coin_market_cal': 'Coin Market Cal',
                
                // Page Titles
                'livecoin_history': 'История Livecoin',
                'exchanges': 'Биржи',
                'fiats': 'Фиатные валюты',
                
                // Action Buttons
                'refresh': 'Обновить',
                'fullscreen': 'Полноэкранный режим',
                'dark_mode': 'Темный режим',
                
                // Table Headers
                'coin': 'Монета',
                'logo': 'Логотип',
                'rate': 'Курс',
                'age': 'Возраст',
                'pairs': 'Пары',
                'volume_24h': 'Объем (24ч)',
                'market_cap': 'Рыночная капитализация',
                'rank': 'Ранг',
                'markets': 'Рынки',
                'total_supply': 'Общее предложение',
                'max_supply': 'Максимальное предложение',
                'circulating_supply': 'Обращающееся предложение',
                'all_time_high': 'Исторический максимум',
                'categories': 'Категории',
                
                // Content Sections
                'about_live_coin_watch': 'О Live Coin Watch',
                'visit_live_coin_watch': 'Посетить Live Coin Watch',
                'user_reviews': 'Отзывы пользователей',
                'leave_a_review': 'Оставить отзыв',
                
                // Form Fields
                'name': 'Имя',
                'email': 'Email',
                'rating': 'Оценка',
                'title': 'Заголовок',
                'comment': 'Комментарий',
                'submit_review': 'Отправить отзыв',
                
                // Rating Options
                'select': 'Выбрать',
                'poor': '1 - Плохо',
                'fair': '2 - Удовлетворительно',
                'good': '3 - Хорошо',
                'very_good': '4 - Очень хорошо',
                'excellent': '5 - Отлично',
                
                // Tutorial Links
                'binance_guide': 'Руководство Binance',
                'crypto_trading': 'Торговля криптовалютой',
                'crypto_basics': 'Основы криптовалюты',
                'trading_strategy': 'Торговая стратегия',
                'learn_center': 'Центр обучения',
                'chart_analysis': 'Анализ графиков',
                
                // Common Words
                'platform': 'Платформа',
                
                // Social Media & Additional Menu Items
                'twitter': 'Twitter',
                'twitter_account': 'Аккаунт Twitter',
                'telegram': 'Telegram',
                'telegram_account': 'Аккаунт Telegram',
                'trading_pair': 'Торговая пара',
                
                // Button Text
                'update_all_data': 'Обновить все данные',
                
                // DataTable Buttons
                'copy': 'Копировать',
                'csv': 'CSV',
                'excel': 'Excel',
                'pdf': 'PDF',
                'print': 'Печать',
                'columns': 'Колонки',
            },
            hy: {
                // Main Navigation
                'dashboard': 'Վահանակ',
                'about': 'Մեր մասին',
                'language': 'Լեզու',
                'trading_tutorials': 'Առևտրի ուսուցումներ',
                
                // Dashboard Submenu
                'live_coin_watch': 'Live Coin Watch',
                'coingecko': 'Coingecko',
                'coin_market_cal': 'Coin Market Cal',
                
                // Page Titles
                'livecoin_history': 'Livecoin պատմություն',
                'exchanges': 'Բորսաներ',
                'fiats': 'Ֆիատային արժույթներ',
                
                // Action Buttons
                'refresh': 'Թարմացնել',
                'fullscreen': 'Ամբողջ էկրան',
                'dark_mode': 'Մուգ ռեժիմ',
                
                // Table Headers
                'coin': 'Մետաղադրամ',
                'logo': 'Լոգո',
                'rate': 'Կուրս',
                'age': 'Տարիք',
                'pairs': 'Զույգեր',
                'volume_24h': 'Ծավալ (24ժ)',
                'market_cap': 'Շուկայական կապիտալիզացիա',
                'rank': 'Դիրք',
                'markets': 'Շուկաներ',
                'total_supply': 'Ընդհանուր առաջարկ',
                'max_supply': 'Առավելագույն առաջարկ',
                'circulating_supply': 'Շրջանառվող առաջարկ',
                'all_time_high': 'Բոլոր ժամանակների բարձրագույն',
                'categories': 'Կատեգորիաներ',
                
                // Content Sections
                'about_live_coin_watch': 'Live Coin Watch-ի մասին',
                'visit_live_coin_watch': 'Այցելել Live Coin Watch',
                'user_reviews': 'Օգտատերերի ակնարկներ',
                'leave_a_review': 'Թողնել ակնարկ',
                
                // Form Fields
                'name': 'Անուն',
                'email': 'Էլ. փոստ',
                'rating': 'Գնահատական',
                'title': 'Կոչում',
                'comment': 'Մեկնաբանություն',
                'submit_review': 'Ներկայացնել ակնարկ',
                
                // Rating Options
                'select': 'Ընտրել',
                'poor': '1 - Վատ',
                'fair': '2 - Բավարար',
                'good': '3 - Լավ',
                'very_good': '4 - Շատ լավ',
                'excellent': '5 - Գերազանց',
                
                // Tutorial Links
                'binance_guide': 'Binance ուղեցույց',
                'crypto_trading': 'Կրիպտո առևտուր',
                'crypto_basics': 'Կրիպտո հիմունքներ',
                'trading_strategy': 'Առևտրային ռազմավարություն',
                'learn_center': 'Ուսուցման կենտրոն',
                'chart_analysis': 'Գրաֆիկների վերլուծություն',
                
                // Common Words
                'platform': 'Հարթակ',
                
                // Social Media & Additional Menu Items
                'twitter': 'Twitter',
                'twitter_account': 'Twitter հաշիվ',
                'telegram': 'Telegram',
                'telegram_account': 'Telegram հաշիվ',
                'trading_pair': 'Առևտրային զույգ',
                
                // Button Text
                'update_all_data': 'Թարմացնել բոլոր տվյալները',
                
                // DataTable Buttons
                'copy': 'Պատճենել',
                'csv': 'CSV',
                'excel': 'Excel',
                'pdf': 'PDF',
                'print': 'Տպել',
                'columns': 'Սյուներ',
            },
            fi: {
                // Main Navigation
                'dashboard': 'Kojelauta',
                'about': 'Tietoja',
                'language': 'Kieli',
                'trading_tutorials': 'Kauppaopetus',
                
                // Dashboard Submenu
                'live_coin_watch': 'Live Coin Watch',
                'coingecko': 'Coingecko',
                'coin_market_cal': 'Coin Market Cal',
                
                // Page Titles
                'livecoin_history': 'Livecoin historia',
                'exchanges': 'Pörssit',
                'fiats': 'Fiat-valuutat',
                
                // Action Buttons
                'refresh': 'Päivitä',
                'fullscreen': 'Koko näyttö',
                'dark_mode': 'Tumma tila',
                
                // Table Headers
                'coin': 'Kolikko',
                'logo': 'Logo',
                'rate': 'Kurssi',
                'age': 'Ikä',
                'pairs': 'Parit',
                'volume_24h': 'Volyymi (24h)',
                'market_cap': 'Markkina-arvo',
                'rank': 'Sijoitus',
                'markets': 'Markkinat',
                'total_supply': 'Kokonaistarjonta',
                'max_supply': 'Maksimitarjonta',
                'circulating_supply': 'Liikkeessä oleva tarjonta',
                'all_time_high': 'Kaikkien aikojen korkein',
                'categories': 'Kategoriat',
                
                // Content Sections
                'about_live_coin_watch': 'Tietoja Live Coin Watchista',
                'visit_live_coin_watch': 'Vieraile Live Coin Watchissa',
                'user_reviews': 'Käyttäjäarvostelut',
                'leave_a_review': 'Jätä arvostelu',
                
                // Form Fields
                'name': 'Nimi',
                'email': 'Sähköposti',
                'rating': 'Arvostelu',
                'title': 'Otsikko',
                'comment': 'Kommentti',
                'submit_review': 'Lähetä arvostelu',
                
                // Rating Options
                'select': 'Valitse',
                'poor': '1 - Huono',
                'fair': '2 - Tyydyttävä',
                'good': '3 - Hyvä',
                'very_good': '4 - Erittäin hyvä',
                'excellent': '5 - Erinomainen',
                
                // Tutorial Links
                'binance_guide': 'Binance-opas',
                'crypto_trading': 'Kryptokauppa',
                'crypto_basics': 'Kryptoperusteet',
                'trading_strategy': 'Kauppastrategia',
                'learn_center': 'Oppimiskeskus',
                'chart_analysis': 'Kaavioanalyysi',
                
                // Common Words
                'platform': 'Alusta',
                
                // Social Media & Additional Menu Items
                'twitter': 'Twitter',
                'twitter_account': 'Twitter-tili',
                'telegram': 'Telegram',
                'telegram_account': 'Telegram-tili',
                'trading_pair': 'Kauppapari',
                
                // Button Text
                'update_all_data': 'Päivitä kaikki tiedot',
                
                // DataTable Buttons
                'copy': 'Kopioi',
                'csv': 'CSV',
                'excel': 'Excel',
                'pdf': 'PDF',
                'print': 'Tulosta',
                'columns': 'Sarakkeet',
            }
        };
        
        this.init();
    }
    
    init() {
        // Get current language from localStorage or default to 'en'
        this.currentLanguage = localStorage.getItem('selectedLanguage') || 'en';
        
        // Apply translations on page load
        this.applyTranslations();
        
        // Listen for language change events
        document.addEventListener('languageChanged', (event) => {
            this.currentLanguage = event.detail.language;
            this.applyTranslations();
        });
    }
    
    translate(key) {
        const lang = this.translations[this.currentLanguage];
        return lang && lang[key] ? lang[key] : key;
    }
    
    applyTranslations() {
        // Update all elements with data-lang-key attribute
        const elements = document.querySelectorAll('[data-lang-key]');
        elements.forEach(element => {
            const key = element.getAttribute('data-lang-key');
            const translation = this.translate(key);
            
            if (element.tagName === 'INPUT' && element.type === 'placeholder') {
                element.placeholder = translation;
            } else if (element.tagName === 'OPTION') {
                element.textContent = translation;
            } else {
                element.textContent = translation;
            }
        });
        
        // Update page title
        this.updatePageTitle();
        
        // Update DataTable buttons
        this.updateDataTableButtons();
        
        // Update meta descriptions if they have translations
        const metaDescription = document.querySelector('meta[name="description"]');
        if (metaDescription && metaDescription.getAttribute('data-lang-key')) {
            const descKey = metaDescription.getAttribute('data-lang-key');
            metaDescription.setAttribute('content', this.translate(descKey));
        }
        
        // Update DataTable headers if DataTable is initialized
        if (typeof $.fn.DataTable !== 'undefined') {
            const tables = $('.dataTable').DataTable();
            if (tables.length > 0) {
                tables.forEach(table => {
                    if (table.settings().init().language) {
                        table.settings().init().language = this.getDataTableLanguage();
                        table.draw();
                    }
                });
            }
        }
    }
    
    updatePageTitle() {
        const titleElement = document.querySelector('title');
        if (!titleElement) return;
        
        const currentTitle = titleElement.textContent;
        console.log('Current page title:', currentTitle);
        
        // Define title patterns for different pages
        const titlePatterns = {
            'Livecoin History': 'livecoin_history',
            'Exchanges': 'exchanges',
            'Fiats': 'fiats',
            'Dashboard': 'dashboard',
            'About': 'about',
            'Crypto Trading': 'crypto_trading'
        };
        
        let newTitle = currentTitle;
        let titleChanged = false;
        
        // Check each pattern and replace if found
        for (const [pattern, key] of Object.entries(titlePatterns)) {
            if (currentTitle.includes(pattern)) {
                const translation = this.translate(key);
                console.log(`Translating "${pattern}" to "${translation}"`);
                newTitle = newTitle.replace(pattern, translation);
                titleChanged = true;
            }
        }
        
        // If no specific pattern found, try to translate common words
        if (!titleChanged) {
            // Common words that might appear in titles
            const commonWords = {
                'History': 'livecoin_history',
                'Trading': 'crypto_trading',
                'Platform': 'platform'
            };
            
            for (const [word, key] of Object.entries(commonWords)) {
                if (currentTitle.includes(word)) {
                    const translation = this.translate(key);
                    console.log(`Translating common word "${word}" to "${translation}"`);
                    newTitle = newTitle.replace(word, translation);
                    titleChanged = true;
                }
            }
        }
        
        // Update the title if changes were made
        if (titleChanged) {
            console.log('Updating page title from:', currentTitle, 'to:', newTitle);
            titleElement.textContent = newTitle;
        } else {
            console.log('No title changes needed');
        }
    }
    
    updateDataTableButtons() {
        // Update DataTable button text for all DataTables on the page
        if (typeof $.fn.DataTable !== 'undefined') {
            $('.dataTable').each(function() {
                const table = $(this).DataTable();
                if (table && table.buttons) {
                    // Update each button text
                    const buttonKeys = ['copy', 'csv', 'excel', 'pdf', 'print', 'columns'];
                    buttonKeys.forEach(key => {
                        const button = table.button(`.buttons-${key}`);
                        if (button && button.node()) {
                            const $button = $(button.node());
                            const $textSpan = $button.find(`[data-lang-key="${key}"]`);
                            if ($textSpan.length > 0) {
                                $textSpan.text(this.translate(key));
                            }
                        }
                    });
                }
            }.bind(this));
        }
    }
    
    getDataTableLanguage() {
        const languages = {
            en: {
                "sProcessing": "Processing...",
                "sLengthMenu": "Show _MENU_ entries",
                "sZeroRecords": "No matching records found",
                "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                "sInfoEmpty": "Showing 0 to 0 of 0 entries",
                "sInfoFiltered": "(filtered from _MAX_ total entries)",
                "sInfoPostFix": "",
                "sSearch": "Search:",
                "sUrl": "",
                "sEmptyTable": "No data available in table",
                "sLoadingRecords": "Loading...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "First",
                    "sPrevious": "Previous",
                    "sNext": "Next",
                    "sLast": "Last"
                }
            },
            ru: {
                "sProcessing": "Обработка...",
                "sLengthMenu": "Показать _MENU_ записей",
                "sZeroRecords": "Не найдено записей",
                "sInfo": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "sInfoEmpty": "Записи с 0 до 0 из 0 записей",
                "sInfoFiltered": "(отфильтровано из _MAX_ записей)",
                "sInfoPostFix": "",
                "sSearch": "Поиск:",
                "sUrl": "",
                "sEmptyTable": "В таблице нет данных",
                "sLoadingRecords": "Загрузка...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "Первая",
                    "sPrevious": "Предыдущая",
                    "sNext": "Следующая",
                    "sLast": "Последняя"
                }
            },
            hy: {
                "sProcessing": "Մշակում...",
                "sLengthMenu": "Ցույց տալ _MENU_ գրառում",
                "sZeroRecords": "Գրառումներ չեն գտնվել",
                "sInfo": "Ցույց է տրվում _START_-ից _END_-ը _TOTAL_ գրառումից",
                "sInfoEmpty": "Ցույց է տրվում 0-ից 0-ը 0 գրառումից",
                "sInfoFiltered": "(ֆիլտրված _MAX_ գրառումից)",
                "sInfoPostFix": "",
                "sSearch": "Որոնում:",
                "sUrl": "",
                "sEmptyTable": "Աղյուսակում տվյալներ չկան",
                "sLoadingRecords": "Բեռնում...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "Առաջին",
                    "sPrevious": "Նախորդ",
                    "sNext": "Հաջորդ",
                    "sLast": "Վերջին"
                }
            },
            fi: {
                "sProcessing": "Käsitellään...",
                "sLengthMenu": "Näytä _MENU_ merkintää",
                "sZeroRecords": "Ei vastaavia merkintöjä",
                "sInfo": "Näytetään _START_ - _END_ / _TOTAL_ merkintää",
                "sInfoEmpty": "Näytetään 0 - 0 / 0 merkintää",
                "sInfoFiltered": "(suodatettu _MAX_ merkinnästä)",
                "sInfoPostFix": "",
                "sSearch": "Etsi:",
                "sUrl": "",
                "sEmptyTable": "Taulukossa ei ole tietoja",
                "sLoadingRecords": "Ladataan...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "Ensimmäinen",
                    "sPrevious": "Edellinen",
                    "sNext": "Seuraava",
                    "sLast": "Viimeinen"
                }
            }
        };
        
        return languages[this.currentLanguage] || languages.en;
    }
    
    setLanguage(lang) {
        this.currentLanguage = lang;
        localStorage.setItem('selectedLanguage', lang);
        this.applyTranslations();
        
        // Dispatch custom event for other components
        const event = new CustomEvent('languageChanged', {
            detail: { language: lang }
        });
        document.dispatchEvent(event);
    }
}

// Initialize translation helper when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.translationHelper = new TranslationHelper();
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = TranslationHelper;
} 