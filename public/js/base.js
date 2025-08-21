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

// Global error handler to prevent language switcher from breaking the page
window.addEventListener('error', function(e) {
    console.error('Global error caught:', e.error);
    // If the error is related to language switcher, disable it
    if (e.error && e.error.message && e.error.message.includes('language')) {
        console.log('Disabling language switcher due to error');
        const languageSwitcher = document.getElementById('languageSwitcher');
        if (languageSwitcher) {
            languageSwitcher.style.display = 'none';
        }
    }
});

// --- Language Switcher Functionality ---
function initLanguageSwitcher() {
    const languageSwitcher = document.getElementById('languageSwitcher');
    const currentLanguageBtn = document.getElementById('currentLanguageBtn');
    const languageDropdown = document.getElementById('languageDropdown');
    const languageOptions = document.querySelectorAll('.language-option');
    
    // Only initialize if the language switcher exists
    if (!languageSwitcher || !currentLanguageBtn || !languageDropdown) {
        console.log('Language switcher elements not found, skipping initialization');
        return;
    }
    
    // Get saved language or default to English
    const savedLanguage = localStorage.getItem('selectedLanguage') || 'en';
    
    // Initialize with saved language
    setCurrentLanguage(savedLanguage);
    
    // Apply saved language to page content only if we're on a page that supports it
    if (document.querySelector('[data-lang-key]') || document.querySelector('.m-portlet__head-text')) {
        applyLanguageToPage(savedLanguage);
    }
    
    // Toggle dropdown
    currentLanguageBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        languageSwitcher.classList.toggle('active');
        
        if (languageSwitcher.classList.contains('active')) {
            languageDropdown.classList.add('show');
        } else {
            languageDropdown.classList.remove('show');
        }
    });
    
    // Handle language selection
    languageOptions.forEach(option => {
        option.addEventListener('click', function() {
            const lang = this.dataset.lang;
            const flag = this.dataset.flag;
            
            setCurrentLanguage(lang, flag);
            languageSwitcher.classList.remove('active');
            languageDropdown.classList.remove('show');
            
            // Save to localStorage
            localStorage.setItem('selectedLanguage', lang);
            
            // Apply language to page content only if we're on a page that supports it
            if (document.querySelector('[data-lang-key]') || document.querySelector('.m-portlet__head-text')) {
                applyLanguageToPage(lang);
            }
            
            // Dispatch custom event for language change
            document.dispatchEvent(new CustomEvent('languageChanged', {
                detail: { language: lang }
            }));
            
            // Show success message
            showLanguageChangeMessage(lang);
        });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!languageSwitcher.contains(e.target)) {
            languageSwitcher.classList.remove('active');
            languageDropdown.classList.remove('show');
        }
    });
    
    // Keyboard navigation
    currentLanguageBtn.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            currentLanguageBtn.click();
        }
    });
    
    languageOptions.forEach(option => {
        option.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                option.click();
            }
        });
    });
}

// Language-specific text mappings
const languageTexts = {
    en: {
        // Page titles and headers
        'Coin Events': 'Coin Events',
        'TradingView Chart': 'TradingView Chart',
        'Technical Analysis': 'Technical Analysis',
        'Market Cap & Volume': 'Market Cap & Volume',
        'Mini Price Chart': 'Mini Price Chart',
        'About': 'About',
        'Tokenomics': 'Tokenomics',
        'News': 'News',
        'Price': 'Price',
        'Market Cap': 'Market Cap',
        'Rank': 'Rank',
        'Supply': 'Supply',
        'Volume': 'Volume',
        'Change 24h': 'Change 24h',
        'Loading...': 'Loading...',
        'Updating Data ...': 'Updating Data ...',
        'Update All Data': 'Update All Data',
        'Error loading data': 'Error loading data',
        'No data available': 'No data available',
        'Language changed to': 'Language changed to',
        'Full Screen': 'Full Screen',
        'Exit Full Screen': 'Exit Full Screen',
        'Coin Details': 'Coin Details',
        'Cryptocurrency Trading': 'Cryptocurrency Trading',
        'Bitcoin': 'Bitcoin',
        'Ethereum': 'Ethereum',
        'Litecoin': 'Litecoin',
        'Market Data': 'Market Data',
        'Trading Pairs': 'Trading Pairs',
        'Social Media': 'Social Media',
        'Telegram messages': 'Telegram messages',
        'Twitter messages': 'Twitter messages',
        'News updates': 'News updates',
        'You can also add TradingView Pair here': 'You can also add TradingView Pair here',
        'You can also relate a Twitter Account Here': 'You can also relate a Twitter Account Here',
        'You can also relate a Telegram Account Here': 'You can also relate a Telegram Account Here',
        // Calendar translations
        'January': 'January',
        'February': 'February',
        'March': 'March',
        'April': 'April',
        'May': 'May',
        'June': 'June',
        'July': 'July',
        'August': 'August',
        'September': 'September',
        'October': 'October',
        'November': 'November',
        'December': 'December',
        'Sun': 'Sun',
        'Mon': 'Mon',
        'Tue': 'Tue',
        'Wed': 'Wed',
        'Thu': 'Thu',
        'Fri': 'Fri',
        'Sat': 'Sat',
        'Sunday': 'Sunday',
        'Monday': 'Monday',
        'Tuesday': 'Tuesday',
        'Wednesday': 'Wednesday',
        'Thursday': 'Thursday',
        'Friday': 'Friday',
        'Saturday': 'Saturday',
        'Today': 'Today',
        'Month': 'Month',
        'Week': 'Week',
        'Day': 'Day',
        'List': 'List',
        'All Day': 'All Day',
        'No events': 'No events',
        'More': 'More',
        'Prev': 'Prev',
        'Next': 'Next',
        'Livecoin History': 'Livecoin History',
        'Dark Mode': 'Dark Mode',
        'History': 'History',
        'Exchanges': 'Exchanges',
        'Fiats': 'Fiats',
        'Refresh': 'Refresh',
        'Fullscreen': 'Fullscreen',
        'Coin': 'Coin',
        'Logo': 'Logo',
        'Rate': 'Rate',
        'Age': 'Age',
        'Pairs': 'Pairs',
        'Volume (24h)': 'Volume (24h)',
        'Market Cap': 'Market Cap',
        'Rank': 'Rank',
        'Markets': 'Markets',
        'Total Supply': 'Total Supply',
        'Max Supply': 'Max Supply',
        'Circulating Supply': 'Circulating Supply',
        'All-Time High': 'All-Time High',
        'Categories': 'Categories',
        'About Live Coin Watch': 'About Live Coin Watch',
        'Visit Live Coin Watch': 'Visit Live Coin Watch',
        'User Reviews': 'User Reviews',
        'Leave a Review': 'Leave a Review',
        'Name': 'Name',
        'Email': 'Email',
        'Rating': 'Rating',
        'Select': 'Select',
        '1 - Poor': '1 - Poor',
        '2 - Fair': '2 - Fair',
        '3 - Good': '3 - Good',
        '4 - Very Good': '4 - Very Good',
        '5 - Excellent': '5 - Excellent',
        'Title': 'Title',
        'Comment': 'Comment',
        'Submit Review': 'Submit Review',
        'LCW Info Card Intro': 'Live Coin Watch is a real-time cryptocurrency market tracking platform, offering a clean and convenient interface for monitoring prices, market capitalizations, trading volumes, and rankings of hundreds of digital assets. Unlike many competitors, Live Coin Watch updates information in real time, making it ideal for users who want to see price changes as they happen.',
        'LCW Info Card Change History': 'Change History: The table above provides a comprehensive record of historical changes for various cryptocurrencies as tracked by Live Coin Watch. Each entry reflects updates in price, market capitalization, trading volume, and other key metrics over time. This change history enables users to analyze trends, monitor market movements, and make informed decisions based on past performance and data transparency. The regularly updated datatable ensures that users always have access to the latest and most accurate historical information available.',
        'platforms_comparison_title': 'Compare Data from LiveCoinWatch, CoinGecko, CoinMarketCal, CryptoCompare, CoinPaprika and Cryptics.tech',
        
        // Breadcrumb menu items
        'dashboard': 'Dashboard',
        'markets_comparison': 'Markets Comparison',
        'live_coin_watch': 'Live Coin Watch',
        'coingecko': 'Coingecko',
        'coin_market_cal': 'Coin Market Cal',
        'crypto_compare': 'Crypto Compare',
        'coin_predictions': 'Coin Predictions',
        // Main page loading UI
        'loading_title': 'Loading CryptoTrading Data',
        'loading_subtitle': 'Fetching comprehensive market data from multiple sources...',
        'initializing': 'Initializing...',
        'waiting': 'Waiting...',
        'LiveCoinWatch': 'LiveCoinWatch',
        'CoinGecko': 'CoinGecko',
        'CoinMarketCal': 'CoinMarketCal',
        'cryptocompare': 'CryptoCompare',
        'coinpaprika': 'CoinPaprika',
        'Cryptics.tech': 'Cryptics.tech',
        'tip_data_fetch': 'Data is being fetched from multiple cryptocurrency platforms',
        'tip_comprehensive': 'This ensures you get the most comprehensive market overview',
        'tip_refresh': 'Data refreshes automatically every few minutes',
        'coin_event_calendar': 'Coin Event Calendar',
        'event': 'Event',
        'open_source': 'Open Source',
        'close': 'Close',
        'market_overview_charts': 'Market Overview Charts',
        'time_series_prices': 'Time Series Prices',
        'market_dominance': 'Market Dominance',
        'top_volume_markets': 'Top Volume Markets',
        'price_prediction_accuracy': 'Price Prediction Accuracy',
        'exchange_comparison_table': 'Exchange Comparison Table',
        'comprehensive_market_analysis': 'Comprehensive Market Analysis',
        'top_coins_performance_timeline': 'Top Coins Performance Timeline',
        'platform_data_coverage': 'Platform Data Coverage',
        'exchange_performance_comparison': 'Exchange Performance Comparison',
        'market_cap_vs_volume': 'Market Cap VS Volume',
        'price_correlation_matrix': 'Price Correlation Matrix',
        'market_sentiment_analysis': 'Market Sentiment Analysis',
        'platform_performance_summary': 'Platform Performance Summary',
        'price_movement_comparison': 'Price Movement Comparison',
        'coin_count_comparison': 'Coin Count Comparison',
        'volume_comparison': 'Volume Comparison',
        'market_cap_comparison': 'Market Cap Comparison',
        'platform_data_comparison': 'Platform Data Comparison',
        'cryptics_tech': 'CRYPTTECH',
        'active_coins': 'Active Coins',
        'new_coins': 'New Coins',
        'total_predictions': 'Total Predictions',
        'prediction_accuracy': 'Prediction Accuracy',
        'trending_up': 'Trending Up',
        'trend_direction': 'Trend Direction',
        'confidence_level': 'Confidence Level',
        'prediction_date': 'Prediction Date',
        'actual_price': 'Actual Price',
        'predicted_price': 'Predicted Price',
        'coin_pair': 'Coin Pair',
        'trading_pairs': 'Trading Pairs',
        'exchange_type': 'Exchange Type',
        'country': 'Country',
        'year_established': 'Year Established',
        'volume_24h_btc': 'Volume 24h btc',
        'trust_score': 'Trust Score',
        'exchange_name': 'Exchange Name',
        'sentiment_score': 'Sentiment Score',
        'platforms_available': 'Platforms Available',
        'price_change_24h': 'Price Change 24h',
        'current_price': 'Current Price',
        'symbol': 'Symbol',
        'gaining_coins': 'gaining coins',
        'losing_coins': 'losing coins',
        // Interactive Table Navigation
        'interactive_table_navigation_title': '💡 Interactive Table Navigation',
        'interactive_table_navigation_click_on_any_row': 'Click on any row',
        'interactive_table_navigation_desc_tail': 'in the table below to explore detailed information about that cryptocurrency.',
        'interactive_table_navigation_youll_be_taken': "You'll be taken to a comprehensive details page featuring:",
        'interactive_feature_tradingview_charts': 'TradingView Charts',
        'interactive_feature_events_calendar': 'Events Calendar',
        'interactive_feature_telegram_messages': 'Telegram Messages',
        'interactive_feature_twitter_sentiment': 'Twitter Sentiment',
        'interactive_feature_market_analysis': 'Market Analysis',
        'interactive_feature_technical_indicators': 'Technical Indicators',
        'interactive_pro_tip': 'Pro tip: Use the search and filter options above to find specific cryptocurrencies quickly!',
        // Duplicate keys used by data-lang-key in markup
        'about_live_coin_watch': 'About Live Coin Watch',
        'visit_live_coin_watch': 'Visit Live Coin Watch',
    },
    ru: {
        // Page titles and headers
        'Coin Events': 'События монет',
        'TradingView Chart': 'График TradingView',
        'Technical Analysis': 'Технический анализ',
        'Market Cap & Volume': 'Рыночная капитализация и объем',
        'Mini Price Chart': 'Мини график цены',
        'About': 'О проекте',
        'Tokenomics': 'Токеномика',
        'News': 'Новости',
        'Price': 'Цена',
        'Supply': 'Предложение',
        'Volume': 'Объем',
        'Change 24h': 'Изменение за 24ч',
        'Loading...': 'Загрузка...',
        'Updating Data ...': 'Обновление данных...',
        'Update All Data': 'Обновить все данные',
        'Error loading data': 'Ошибка загрузки данных',
        'No data available': 'Данные недоступны',
        'Language changed to': 'Язык изменен на',
        'Full Screen': 'Полный экран',
        'Exit Full Screen': 'Выйти из полноэкранного режима',
        'Coin Details': 'Детали монеты',
        'Cryptocurrency Trading': 'Торговля криптовалютами',
        'Bitcoin': 'Биткоин',
        'Ethereum': 'Эфириум',
        'Litecoin': 'Лайткоин',
        'Market Data': 'Рыночные данные',
        'Trading Pairs': 'Торговые пары',
        'Social Media': 'Социальные сети',
        'Telegram messages': 'Сообщения Telegram',
        'Twitter messages': 'Сообщения Twitter',
        'News updates': 'Обновления новостей',
        'You can also add TradingView Pair here': 'Вы также можете добавить торговую пару TradingView здесь',
        'You can also relate a Twitter Account Here': 'Вы также можете связать аккаунт Twitter здесь',
        'You can also relate a Telegram Account Here': 'Вы также можете связать аккаунт Telegram здесь',
        // Calendar translations
        'January': 'Январь',
        'February': 'Февраль',
        'March': 'Март',
        'April': 'Апрель',
        'May': 'Май',
        'June': 'Июнь',
        'July': 'Июль',
        'August': 'Август',
        'September': 'Сентябрь',
        'October': 'Октябрь',
        'November': 'Ноябрь',
        'December': 'Декабрь',
        'Sun': 'Вс',
        'Mon': 'Пн',
        'Tue': 'Вт',
        'Wed': 'Ср',
        'Thu': 'Чт',
        'Fri': 'Пт',
        'Sat': 'Сб',
        'Sunday': 'Воскресенье',
        'Monday': 'Понедельник',
        'Tuesday': 'Вторник',
        'Wednesday': 'Среда',
        'Thursday': 'Четверг',
        'Friday': 'Пятница',
        'Saturday': 'Суббота',
        'Today': 'Сегодня',
        'Month': 'Месяц',
        'Week': 'Неделя',
        'Day': 'День',
        'List': 'Список',
        'All Day': 'Весь день',
        'No events': 'Нет событий',
        'More': 'Еще',
        'Prev': 'Пред',
        'Next': 'След',
        'Livecoin History': 'История Livecoin',
        'Dark Mode': 'Тёмный режим',
        'History': 'История',
        'Exchanges': 'Биржи',
        'Fiats': 'Фиаты',
        'Refresh': 'Обновить',
        'Fullscreen': 'На весь экран',
        'Coin': 'Монета',
        'Logo': 'Логотип',
        'Rate': 'Курс',
        'Age': 'Возраст',
        'Pairs': 'Пары',
        'Volume (24h)': 'Объем (24ч)',
        'market_cap_distribution': 'Распределение рыночной капитализации',
        'price_movement_trends': 'Тренды движения цен за 24ч',
        'volume_distribution': 'Распределение объема',
        'platform_coverage': 'Покрытие платформ',
        'top_10_coins_by_market_cap': 'Топ-10 монет по рыночной капитализации',
        'market_trends_summary': 'Сводка рыночных трендов',
        'gaining': 'Растущие',
        'losing': 'Падающие',
        'stable': 'Стабильные',
        'search_for_coin': 'Поиск монеты (например, bitcoin, ethereum)',
        'search': 'Поиск',
        'analysis_for': 'Анализ для',
        'price': 'Цена',
        'market_cap': 'Рыночная капитализация',
        'volume': 'Объем',
        'last_updated': 'Последнее обновление',
        'rank': 'Ранг',
        '24h_change': 'Изменение за 24ч',
        'circulating_supply': 'Обращающееся предложение',
        'max_supply': 'Максимальное предложение',
        'ath': 'Исторический максимум',
        'hot_index': 'Индекс популярности',
        'trending_index': 'Индекс тренда',
        'significant_index': 'Индекс значимости',
        'mega_cap': 'Мега-капитализация (>$10 млрд)',
        'large_cap': 'Большая капитализация ($1-10 млрд)',
        'mid_cap': 'Средняя капитализация ($100 млн-1 млрд)',
        'small_cap': 'Малая капитализация ($10-100 млн)',
        'micro_cap': 'Микро-капитализация (<$10 млн)',
        'high_volume': 'Высокий объем (>$1 млрд)',
        'medium_volume': 'Средний объем ($100 млн-1 млрд)',
        'low_volume': 'Низкий объем (<$100 млн)',
        'livecoinwatch_only': 'Только LiveCoinWatch',
        'coingecko_only': 'Только CoinGecko',
        'both_platforms': 'Обе платформы',
        'please_enter_coin_symbol': 'Пожалуйста, введите символ монеты',
        'no_data_found_for': 'Данные не найдены для',
        'error_searching_for': 'Ошибка поиска для',
        'searching_for_coin_data': 'Поиск данных о монете...',
        'platforms_comparison_title': 'Сравнение данных LiveCoinWatch, CoinGecko, CoinMarketCal, CryptoCompare, CoinPaprika и Cryptics.tech',
        // Main page loading UI
        'loading_title': 'Загрузка данных CryptoTrading',
        'loading_subtitle': 'Получение комплексных рыночных данных из нескольких источников...',
        'initializing': 'Инициализация...',
        'waiting': 'Ожидание...',
        'LiveCoinWatch': 'LiveCoinWatch',
        'CoinGecko': 'CoinGecko',
        'CoinMarketCal': 'CoinMarketCal',
        'crypto_compare': 'CryptoCompare',
        'CoinPaprika': 'CoinPaprika',
        'coin_predictions': 'Coin Predictions',
        'markets_comparison': 'сравнение рынков',
        'Cryptics.tech': 'Cryptics.tech',
        'tip_data_fetch': 'Данные получаютcя из нескольких криптоплатформ',
        'tip_comprehensive': 'Это обеспечивает наиболее полный обзор рынка',
        'tip_refresh': 'Данные обновляются автоматически каждые несколько минут',
        'coin_event_calendar': 'Календарь событий монет',
        'event': 'Событие',
        'open_source': 'Открыть источник',
        'close': 'Закрыть',
        'market_overview_charts': 'Обзорные графики рынка',
        'time_series_prices': 'Временные ряды цен',
        'market_dominance': 'Доминирование на рынке',
        'top_volume_markets': 'Маркетпары с наибольшим объёмом',
        'price_prediction_accuracy': 'Точность прогнозирования цен',
        'exchange_comparison_table': 'Сравнительная таблица бирж',
        'comprehensive_market_analysis': 'Комплексный анализ рынка',
        'top_coins_performance_timeline': 'Хронология лучших монет',
        'platform_data_coverage': 'Охват данных платформы',
        'exchange_performance_comparison': 'Сравнение производительности бирж:',
        'market_cap_vs_volume': 'Рыночная капитализация против объема',
        'price_correlation_matrix': 'Матрица корреляции цен:',
        'market_sentiment_analysis': 'Анализ настроений рынка',
        'platform_performance_summary': 'Сводная информация о производительности платформы:',
        'price_movement_comparison': 'Сравнение движения цен',
        'coin_count_comparison': 'Сравнение количества монет',
        'volume_comparison': 'Сравнение объемов',
        'market_cap_comparison': 'Сравнение рыночной капитализации',
        'platform_data_comparison': 'Сравнение данных платформы',
        'cryptics_tech': 'CRYPTTECH',
        'active_coins': 'Активные монеты',
        'new_coins': 'Новые монеты',
        'total_predictions': 'Всего прогнозов',
        'prediction_accuracy': 'Точность прогноза',
        'trending_up': 'Тенденция роста',
        'trend_direction': 'Направление тренда',
        'confidence_level': 'Уровень уверенности',
        'prediction_date': 'Дата прогноза',
        'actual_price': 'Текущая цена',
        'predicted_price': 'Прогнозируемая цена',
        'coin_pair': 'Пара монет',
        'trading_pairs': 'Торговые пары',
        'exchange_type': 'Тип обмена',
        'country': 'Страна',
        'year_established': 'Год основания',
        'volume_24h_btc': 'Объем 24 ч. BTC',
        'trust_score': 'Точки доверия',
        'exchange_name': 'Имя обмена',
        'sentiment_score': 'Оценка настроений',
        'platforms_available': 'Доступные платформы',
        'price_change_24h': 'Изменение цены за 24 часа',
        'current_price': 'Текущая цена',
        'symbol': 'символ',
        'gaining_coins': 'Дорожающие монеты',
        'losing_coins': 'Дешевеющие монеты',
        // Interactive Table Navigation
        'interactive_table_navigation_title': '💡 Интерактивная навигация по таблице',
        'interactive_table_navigation_click_on_any_row': 'Нажмите на любую строку',
        'interactive_table_navigation_desc_tail': 'в таблице ниже, чтобы просмотреть подробную информацию об этой криптовалюте.',
        'interactive_table_navigation_youll_be_taken': 'Вы попадете на подробную страницу, где представлены:',
        'interactive_feature_tradingview_charts': 'Графики TradingView',
        'interactive_feature_events_calendar': 'Календарь событий',
        'interactive_feature_telegram_messages': 'Сообщения Telegram',
        'interactive_feature_twitter_sentiment': 'Анализ настроений в Twitter',
        'interactive_feature_market_analysis': 'Рыночный анализ',
        'interactive_feature_technical_indicators': 'Технические индикаторы',
        'interactive_pro_tip': 'Совет: используйте поиск и фильтры выше, чтобы быстро найти нужные криптовалюты!',
        // Duplicate keys used by data-lang-key in markup
        'about_live_coin_watch': 'О Live Coin Watch',
        'visit_live_coin_watch': 'Посетить Live Coin Watch',
    },
    hy: {
        'Language changed to': 'Լեզուն փոխվել է',
        'Dark Mode': 'Մութ ռեժիմ',
        'History': 'Պատմություն',
        'Exchanges': 'Փոխանակումներ',
        'Fiats': 'Fiats',
        'Refresh': 'Թարմացնել',
        'Fullscreen': 'Ամբողջ էկրանով',
        'Coin': 'Մետաղադրամ',
        'Logo': 'Լոգոն',
        'Rate': 'Վարկանիշ',
        'Age': 'Տարիքը',
        'Pairs': 'Զույգեր',
        'Volume (24h)': 'Ծավալ (24 ժամ)',
        'Cryptocurrency Trading': 'կրիպտոարժույթի առևտուր',
        'You can also add TradingView Pair here': 'Կարող եք նաև այստեղ ավելացնել TradingView զույգը',
        'You can also relate a Twitter Account Here': 'Կարող եք նաև կապվել Twitter-ի հաշվի հետ այստեղ',
        'You can also relate a Telegram Account Here': 'Կարող եք նաև Telegram հաշիվ ստեղծել այստեղ',
        'Supply': 'Մատակարարում',
        // Page titles and headers
        'Coin Events': 'Մետաղադրամի իրադարձություններ',
        'TradingView Chart': 'TradingView գրաֆիկ',
        'Technical Analysis': 'Տեխնիկական վերլուծություն',
        'Market Cap & Volume': 'Շուկայական կապիտալիզացիա և ծավալ',
        'Mini Price Chart': 'Մինի գնային գրաֆիկ',
        'About': 'Նախագծի մասին',
        'Tokenomics': 'Տոկենոմիկա',
        'News': 'Նորություններ',
        'Price': 'Գին',
        'Market Cap': 'Շուկայական կապիտալիզացիա',
        'Rank': 'Դիրք',
        'Markets': 'Շուկաներ',
        'Total Supply': 'Ընդհանուր առաջարկ',
        'Max Supply': 'Առավելագույն առաջարկ',
        'Circulating Supply': 'Շրջանառվող առաջարկ',
        'All-Time High': 'Պատմական առավելագույն',
        'Categories': 'Կատեգորիաներ',
        'About Live Coin Watch': 'Live Coin Watch-ի մասին',
        'Visit Live Coin Watch': 'Այցելել Live Coin Watch',
        // Duplicate keys used by data-lang-key in markup
        'about_live_coin_watch': 'Live Coin Watch-ի մասին',
        'visit_live_coin_watch': 'Այցելել Live Coin Watch',
        // Interactive Table Navigation
        'interactive_table_navigation_title': '💡 Ինտերակտիվ նավիգացիա աղյուսակում',
        'interactive_table_navigation_click_on_any_row': 'Սեղմեք ցանկացած տողի վրա',
        'interactive_table_navigation_desc_tail': 'ներքևի աղյուսակում՝ տվյալ կրիպտոարժույթի մանրամասն տեղեկությունները տեսնելու համար։',
        'interactive_table_navigation_youll_be_taken': 'Դուք կանցնեք մանրամասն էջ, որտեղ հասանելի է հետևյալը.',
        'interactive_feature_tradingview_charts': 'TradingView գրաֆիկներ',
        'interactive_feature_events_calendar': 'Իրադարձությունների օրացույց',
        'interactive_feature_telegram_messages': 'Telegram հաղորդագրություններ',
        'interactive_feature_twitter_sentiment': 'Twitter-ի տրամադրությունների վերլուծություն',
        'interactive_feature_market_analysis': 'Շուկայի վերլուծություն',
        'interactive_feature_technical_indicators': 'Տեխնիկական ցուցանիշներ',
        'interactive_pro_tip': 'Խորհուրդ. Օգտագործեք վերևի որոնումն ու ֆիլտրերը՝ արագ գտնելու համար ձեզ անհրաժեշտ կրիպտոարժույթները։',
        'User Reviews': 'Օգտատերերի կարծիքներ',
        'Leave a Review': 'Թողնել կարծիք',
        'Name': 'Անուն',
        'Email': 'Էլ. փոստ',
        'Rating': 'Վարկանիշ',
        'Select': 'Ընտրել',
        '1 - Poor': '1 - Վատ',
        '2 - Fair': '2 - Բավարար',
        '3 - Good': '3 - Լավ',
        '4 - Very Good': '4 - Շատ լավ',
        '5 - Excellent': '5 - Գերազանց',
        'Title': 'Վերնագիր',
        'Comment': 'Մեկնաբանություն',
        'Submit Review': 'Ուղարկել կարծիքը',
        'LCW Info Card Intro': 'Live Coin Watch-ը իրական ժամանակում կրիպտոարժույթների շուկայի հետևման հարթակ է, որն առաջարկում է մաքուր և հարմար ինտերֆեյս՝ գների, շուկայական կապիտալիզացիայի, առևտրի ծավալների և հարյուրավոր թվային ակտիվների դասակարգման մոնիտորինգի համար: Ի տարբերություն շատ մրցակիցների, Live Coin Watch-ը թարմացնում է տվյալները իրական ժամանակում, ինչը իդեալական է այն օգտատերերի համար, ովքեր ցանկանում են տեսնել գների փոփոխությունները անմիջապես:',
        'LCW Info Card Change History': 'Փոփոխությունների պատմություն. Վերևի աղյուսակը տրամադրում է տարբեր կրիպտոարժույթների պատմական փոփոխությունների համապարփակ գրանցում, որոնք հետևում է Live Coin Watch-ը: Յուրաքանչյուր գրառում արտացոլում է գնի, շուկայական կապիտալիզացիայի, առևտրի ծավալի և այլ հիմնական ցուցանիշների փոփոխությունները ժամանակի ընթացքում: Այս փոփոխությունների պատմությունը օգտատերերին հնարավորություն է տալիս վերլուծել միտումները, հետևել շուկայի շարժերին և կայացնել տեղեկացված որոշումներ՝ հիմնվելով անցյալի տվյալների և թափանցիկության վրա: Պարբերաբար թարմացվող աղյուսակը ապահովում է, որ օգտատերերը միշտ ունենան ամենավերջին և ճշգրիտ պատմական տեղեկատվությունը:',
        'platforms_comparison_title': 'LiveCoinWatch, CoinGecko, CoinMarketCal, CryptoCompare, CoinPaprika և Cryptics.tech տվյալների համեմատություն',

        // Breadcrumb menu items
        'dashboard': 'Վահանակ',
        'markets_comparison': 'Շուկաների համեմատություն',
        'live_coin_watch': 'Live Coin Watch',
        'coingecko': 'Coingecko',
        'coin_market_cal': 'Coin Market Cal',
        'crypto_compare': 'Crypto Compare',
        'coin_predictions': 'Մետաղադրամների կանխատեսումներ',
        // Main page loading UI
        'loading_title': 'CryptoTrading տվյալների բեռնում',
        'loading_subtitle': 'Տվյալների հավաքում տարբեր հարթակներից...',
        'initializing': 'Սկզբնավորում...',
        'waiting': 'Սպասում...',
        'LiveCoinWatch': 'LiveCoinWatch',
        'CoinGecko': 'CoinGecko',
        'CoinMarketCal': 'CoinMarketCal',
        'cryptocompare': 'CryptoCompare',
        'coinpaprika': 'CoinPaprika',
        'Cryptics.tech': 'Cryptics.tech',
        'tip_data_fetch': 'Տվյալները ստացվում են բազմակի կրիպտոհարթակներից',
        'tip_comprehensive': 'Սա ապահովում է համապարփակ շուկայի պատկեր',
        'tip_refresh': 'Տվյալները թարմացվում են ամեն մի քանի րոպեում',
        'coin_event_calendar': 'Մետաղադրամների իրադարձությունների օրացույց',
        'event': 'Իրադարձություն',
        'open_source': 'Բացել աղբյուրը',
        'close': 'Պատրաստ',
        'market_overview_charts': 'Շուկայի ակնարկային գծապատկերներ',
        'time_series_prices': 'Գների ժամանակային շարք',
        'market_dominance': 'Շուկայի դոմինանտություն',
        'top_volume_markets': 'Ամենաբարձր ծավալով շուկաներ',
        'price_prediction_accuracy': 'Գների կանխատեսման ճշգրտություն',
        'exchange_comparison_table': 'Փոխանակման համեմատական աղյուսակ.',
        'comprehensive_market_analysis': 'Համապարփակ շուկայի վերլուծություն',
        'top_coins_performance_timeline': 'Առաջատար մետաղադրամների կատարողականի ժամանակագրություն',
        'platform_data_coverage': 'Պլատֆորմի տվյալների ծածկույթ',
        'exchange_performance_comparison': 'Փոխանակման կատարողականի համեմատություն.',
        'market_cap_vs_volume': 'Շուկայական կապիտալիզացիան ընդդեմ ծավալի',
        'price_correlation_matrix': 'Գնային համակցման մատրից',
        'market_sentiment_analysis': 'Շուկայի տրամադրության վերլուծություն',
        'platform_performance_summary': 'Պլատֆորմի կատարողականի ամփոփում',
        'price_movement_comparison': 'Գների շարժման համեմատություն',
        'coin_count_comparison': 'Մետաղադրամների հաշվարկի համեմատություն',
        'volume_comparison': 'Ծավալի համեմատություն',
        'market_cap_comparison': 'Շուկայական կապիտալի համեմատություն',
        'platform_data_comparison': 'Պլատֆորմի տվյալների համեմատություն',
        'cryptics_tech': 'CRYPTTECH',
        'active_coins': 'Ակտիվ մետաղադրամներ',
        'new_coins': 'Նոր մետաղադրամներ',
        'total_predictions': 'Ընդհանուր կանխատեսումներ',
        'prediction_accuracy': 'Կանխատեսման ճշգրտություն',
        'trending_up': 'Աճի միտում',
        'trend_direction': 'Միտման ուղղությունը',
        'confidence_level': 'Վստահության մակարդակ',
        'prediction_date': 'Կանխատեսման ամսաթիվը',
        'actual_price': 'Ընթացիկ գինը',
        'predicted_price': 'Կանխատեսված գին',
        'coin_pair': 'Զույգ մետաղադրամներ',
        'trading_pairs': 'Առևտրային զույգեր',
        'exchange_type': 'Փոխանակման տեսակը',
        'country': 'Երկիր',
        'year_established': 'Հիմնադրման տարին',
        'volume_24h_btc': '24 ժամյա BTC ծավալ',
        'trust_score': 'Վստահության միավորներ',
        'exchange_name': 'Փոխանակման անվանումը',
        'sentiment_score': 'Զգացմունքային գնահատական',
        'platforms_available': 'Հասանելի հարթակներ',
        'price_change_24h': 'Գնի փոփոխություն 24 ժամվա ընթացքում',
        'current_price': 'Ընթացիկ գինը',
        'symbol': 'խորհրդանիշ',
        'gaining_coins': 'մետաղադրամների ստացում',
        'losing_coins': 'կորցնող մետաղադրամներ',

        // Interactive Table Navigation
        'interactive_table_navigation_title': '💡 Ինտերակտիվ նավիգացիա աղյուսակում',
        'interactive_table_navigation_click_on_any_row': 'Սեղմեք ցանկացած տողի վրա',
        'interactive_table_navigation_desc_tail': 'ներքևի աղյուսակում՝ տվյալ կրիպտոարժույթի մանրամասն տեղեկությունները տեսնելու համար։',
        'interactive_table_navigation_youll_be_taken': 'Դուք կանցնեք մանրամասն էջ, որտեղ հասանելի է հետևյալը.',
        'interactive_feature_tradingview_charts': 'TradingView գրաֆիկներ',
        'interactive_feature_events_calendar': 'Իրադարձությունների օրացույց',
        'interactive_feature_telegram_messages': 'Telegram հաղորդագրություններ',
        'interactive_feature_twitter_sentiment': 'Twitter-ի տրամադրությունների վերլուծություն',
        'interactive_feature_market_analysis': 'Շուկայի վերլուծություն',
        'interactive_feature_technical_indicators': 'Տեխնիկական ցուցանիշներ',
        'interactive_pro_tip': 'Խորհուրդ. Օգտագործեք վերևի որոնումն ու ֆիլտրերը՝ արագ գտնելու համար ձեզ անհրաժեշտ կրիպտոարժույթները։',
    },
    fi: {
        'Language changed to': 'Kieli vaihdettu',
        'Dark Mode': 'Tumma tila',
        'History': 'Historia',
        'Exchanges': 'Pörssit',
        'Fiats': 'Fiat-valuutat',
        'Refresh': 'Päivitä',
        'Fullscreen': 'Koko näyttö',
        'Coin': 'Kolikko',
        'Logo': 'Logo',
        'Rate': 'Kurssi',
        'Age': 'Ikä',
        'Pairs': 'Parit',
        'Volume (24h)': 'Volyymi (24h)',
        'Market Cap': 'Markkina-arvo',
        'Rank': 'Sijoitus',
        'Markets': 'Markkinat',
        'Total Supply': 'Kokonaismäärä',
        'Max Supply': 'Enimmäismäärä',
        'Circulating Supply': 'Kierrossa',
        'All-Time High': 'Kaikkien aikojen korkein',
        'Categories': 'Kategoriat',
        'About Live Coin Watch': 'Tietoa Live Coin Watchista',
        'Visit Live Coin Watch': 'Siirry Live Coin Watchiin',
        // Duplicate keys used by data-lang-key in markup
        'about_live_coin_watch': 'Tietoja Live Coin Watchista',
        'visit_live_coin_watch': 'Siirry Live Coin Watchiin',
        // Interactive Table Navigation
        'interactive_table_navigation_title': '💡 Interaktiivinen taulukonavigointi',
        'interactive_table_navigation_click_on_any_row': 'Napsauta mitä tahansa riviä',
        'interactive_table_navigation_desc_tail': 'alla olevassa taulukossa nähdäksesi kryptovaluutan tarkemmat tiedot.',
        'interactive_table_navigation_youll_be_taken': 'Sinut ohjataan yksityiskohtaiselle sivulle, jossa on:',
        'interactive_feature_tradingview_charts': 'TradingView-kaaviot',
        'interactive_feature_events_calendar': 'Tapahtumakalenteri',
        'interactive_feature_telegram_messages': 'Telegram-viestit',
        'interactive_feature_twitter_sentiment': 'Twitter-sentimentti',
        'interactive_feature_market_analysis': 'Markkina-analyysi',
        'interactive_feature_technical_indicators': 'Tekniset indikaattorit',
        'interactive_pro_tip': 'Vinkki: Käytä yllä olevia haku- ja suodatustoimintoja löytääksesi nopeasti haluamasi kryptovaluutat!',
        'User Reviews': 'Käyttäjäarvostelut',
        'Leave a Review': 'Jätä arvostelu',
        'Name': 'Nimi',
        'Email': 'Sähköposti',
        'Rating': 'Arvosana',
        'Select': 'Valitse',
        '1 - Poor': '1 - Huono',
        '2 - Fair': '2 - Tyydyttävä',
        '3 - Good': '3 - Hyvä',
        '4 - Very Good': '4 - Erittäin hyvä',
        '5 - Excellent': '5 - Erinomainen',
        'Title': 'Otsikko',
        'Comment': 'Kommentti',
        'Submit Review': 'Lähetä arvostelu',
        'LCW Info Card Intro': 'Live Coin Watch on reaaliaikainen kryptovaluuttamarkkinoiden seurantapalvelu, joka tarjoaa selkeän ja kätevän käyttöliittymän hintojen, markkina-arvojen, kaupankäyntivolyymien ja satojen digitaalisten omaisuuserien sijoitusten seuraamiseen. Toisin kuin monet kilpailijat, Live Coin Watch päivittää tiedot reaaliajassa, mikä tekee siitä ihanteellisen käyttäjille, jotka haluavat nähdä hintamuutokset heti niiden tapahtuessa.',
        'LCW Info Card Change History': 'Muutosten historia: Yllä oleva taulukko tarjoaa kattavan tietueen eri kryptovaluuttojen historiallisista muutoksista, joita Live Coin Watch seuraa. Jokainen merkintä heijastaa hinnan, markkina-arvon, kaupankäyntivolyymin ja muiden keskeisten mittareiden päivityksiä ajan myötä. Tämä muutoshistoria mahdollistaa käyttäjille trendien analysoinnin, markkinaliikkeiden seuraamisen ja tietoon perustuvien päätösten tekemisen aiempien tietojen ja läpinäkyvyyden perusteella. Säännöllisesti päivitettävä taulukko varmistaa, että käyttäjillä on aina pääsy uusimpaan ja tarkimpaan historialliseen tietoon.',
        'platforms_comparison_title': 'LiveCoinWatch-, CoinGecko-, CoinMarketCal-, CryptoCompare-, CoinPaprika- ja Cryptics.tech-tietojen vertailu',
        
        // Breadcrumb menu items
        'dashboard': 'Kojelauta',
        'markets_comparison': 'Markkinoiden vertailu',
        'live_coin_watch': 'Live Coin Watch',
        'coingecko': 'Coingecko',
        'coin_market_cal': 'Coin Market Cal',
        'crypto_compare': 'Crypto Compare',
        'coin_predictions': 'Kolikkoprognoosit',
        // Main page loading UI
        'loading_title': 'Ladataan CryptoTrading-tietoja',
        'loading_subtitle': 'Haetaan kattavia markkinatietoja useista lähteistä...',
        'initializing': 'Alustetaan...',
        'waiting': 'Odotetaan...',
        'LiveCoinWatch': 'LiveCoinWatch',
        'CoinGecko': 'CoinGecko',
        'CoinMarketCal': 'CoinMarketCal',
        'CryptoCompare': 'CryptoCompare',
        'CoinPaprika': 'CoinPaprika',
        'Cryptics.tech': 'Cryptics.tech',
        'tip_data_fetch': 'Tietoja haetaan useilta kryptoplatfoormeilta',
        'tip_comprehensive': 'Tämä takaa kattavan markkinakatsauksen',
        'tip_refresh': 'Tiedot päivittyvät automaattisesti muutaman minuutin välein',
        'coin_event_calendar': 'Kolikkotapahtumien kalenteri',
        'event': 'Tapahtuma',
        'open_source': 'Avaa lähde',
        'close': 'Sulje',
        'market_overview_charts': 'Markkinakatsauskaaviot',
        'time_series_prices': 'Aikasarjahinnat',
        'market_dominance': 'Markkinadominanssi',
        'top_volume_markets': 'Suurimman volyymin markkinat',
        'price_prediction_accuracy': 'Hintaennusteen tarkkuus',
        'exchange_comparison_table': 'Vaihtojen vertailutaulukko:',
        'comprehensive_market_analysis': 'Kattava markkina-analyysi',
        'top_coins_performance_timeline': 'Huippukolikoiden suorituskyvyn aikajana:',
        'platform_data_coverage': 'Alustan tietojen kattavuus',
        'exchange_performance_comparison': 'Pörssin tehokkuuden vertailu:',
        'market_cap_vs_volume': 'Markkina-arvo vs. volyymi:',
        'price_correlation_matrix': 'Hintakorrelaatiomatriisi',
        'market_sentiment_analysis': 'Markkinoiden tunnelma-analyysi:',
        'platform_performance_summary': 'Yhteenveto alustan suorituskyvystä',
        'price_movement_comparison': 'Hintamuutosten vertailu',
        'coin_count_comparison': 'Kolikoiden määrän vertailu',
        'volume_comparison': 'Volyymien vertailu',
        'market_cap_comparison': 'Markkina-arvojen vertailu',
        'platform_data_comparison': 'Alustatietojen vertailu',
        'cryptics_tech': 'CRYPTTECH',
        'active_coins': 'Aktiiviset kolikot',
        'new_coins': 'Uusia kolikoita',
        'total_predictions': 'Ennusteet yhteensä',
        'prediction_accuracy': 'Ennusteen tarkkuus',
        'trending_up': 'Kasvutrendi',
        'trend_direction': 'Trendi suunta',
        'confidence_level': 'Luottamustaso',
        'prediction_date': 'Ennuste päivämäärä',
        'actual_price': 'Nykyinen hinta',
        'predicted_price': 'Arvioitu hinta',
        'coin_pair': 'Pari kolikkoa',
        'trading_pairs': 'Kauppaparit',
        'exchange_type': 'Vaihtotyyppi',
        'country': 'Maa',
        'year_established': 'Perustamisen vuosi',
        'volume_24h_btc': '24 tunnin BTC-volyymi',
        'trust_score': 'Luottamuspisteet',
        'exchange_name': 'Vaihtonimi',
        'sentiment_score': 'Tunnepisteet',
        'platforms_available': 'Käytettävissä olevat alustat',
        'price_change_24h': 'Hintamuutos 24 tunnin sisällä',
        'current_price': 'Nykyinen hinta',
        'symbol': 'symboli',
        'gaining_coins': 'kolikoiden vastaanottaminen',
        'losing_coins': 'kolikoiden häviäminen',
    },
};

// Add translation for page title 'Livecoin History'
Object.assign(languageTexts['en'], {
    'Livecoin History': 'Livecoin History'
});
Object.assign(languageTexts['ru'], {
    'Livecoin History': 'История Livecoin'
});
Object.assign(languageTexts['hy'], {
    'Livecoin History': 'Livecoin-ի պատմություն'
});
Object.assign(languageTexts['fi'], {
    'Livecoin History': 'Livecoin-historia'
});

// Market Comparison Section Translations
Object.assign(languageTexts['en'], {
    'market_comparison': 'Market Comparison Analysis',
    'total_coins': 'Total Coins',
    'total_market_cap': 'Total Market Cap',
    'total_volume': 'Total Volume',
    'total_markets': 'Total Markets',
    'total_exchanges': 'Total Exchanges',
    'total_events': 'Total Events',
    'top_10_ranked': 'Top 10 Ranked',
    'market_cap_distribution': 'Market Cap Distribution',
    'price_movement_trends': '24h Price Movement Trends',
    'volume_distribution': 'Volume Distribution',
    'platform_coverage': 'Platform Coverage',
    'top_10_coins_by_market_cap': 'Top 10 Coins by Market Cap',
    'market_trends_summary': 'Market Trends Summary',
    'gaining': 'Gaining',
    'losing': 'Losing',
    'stable': 'Stable',
    'search_for_coin': 'Search for a coin (e.g., bitcoin, ethereum)',
    'search': 'Search',
    'analysis_for': 'Analysis for',
    'price': 'Price',
    'market_cap': 'Market Cap',
    'volume': 'Volume',
    'last_updated': 'Last Updated',
    'rank': 'Rank',
    '24h_change': '24h Change',
    'circulating_supply': 'Circulating Supply',
    'max_supply': 'Max Supply',
    'ath': 'ATH',
    'hot_index': 'Hot Index',
    'trending_index': 'Trending Index',
    'significant_index': 'Significant Index',
    'mega_cap': 'Mega Cap (>$10B)',
    'large_cap': 'Large Cap ($1B-$10B)',
    'mid_cap': 'Mid Cap ($100M-$1B)',
    'small_cap': 'Small Cap ($10M-$100M)',
    'micro_cap': 'Micro Cap (<$10M)',
    'high_volume': 'High Volume (>$1B)',
    'medium_volume': 'Medium Volume ($100M-$1B)',
    'low_volume': 'Low Volume (<$100M)',
    'livecoinwatch_only': 'LiveCoinWatch Only',
    'coingecko_only': 'CoinGecko Only',
    'both_platforms': 'Both Platforms',
    'please_enter_coin_symbol': 'Please enter a coin symbol',
    'no_data_found_for': 'No data found for',
    'error_searching_for': 'Error searching for',
    'searching_for_coin_data': 'Searching for coin data...'
});

Object.assign(languageTexts['ru'], {
    'market_comparison': 'Анализ сравнения рынков',
    'total_coins': 'Всего монет',
    'total_market_cap': 'Общая рыночная капитализация',
    'total_volume': 'Общий объем',
    'total_markets': 'Всего рынков',
    'total_exchanges': 'Всего бирж',
    'total_events': 'Всего событий',
    'top_10_ranked': 'Топ-10 по рангу',
    'market_cap_distribution': 'Распределение рыночной капитализации',
    'price_movement_trends': 'Тренды движения цен за 24ч',
    'volume_distribution': 'Распределение объема',
    'platform_coverage': 'Покрытие платформ',
    'top_10_coins_by_market_cap': 'Топ-10 монет по рыночной капитализации',
    'market_trends_summary': 'Сводка рыночных трендов',
    'gaining': 'Растущие',
    'losing': 'Падающие',
    'stable': 'Стабильные',
    'search_for_coin': 'Поиск монеты (например, bitcoin, ethereum)',
    'search': 'Поиск',
    'analysis_for': 'Анализ для',
    'price': 'Цена',
    'market_cap': 'Рыночная капитализация',
    'volume': 'Объем',
    'last_updated': 'Последнее обновление',
    'rank': 'Ранг',
    '24h_change': 'Изменение за 24ч',
    'circulating_supply': 'Обращающееся предложение',
    'max_supply': 'Максимальное предложение',
    'ath': 'Исторический максимум',
    'hot_index': 'Индекс популярности',
    'trending_index': 'Индекс тренда',
    'significant_index': 'Индекс значимости',
    'mega_cap': 'Мега-капитализация (>$10 млрд)',
    'large_cap': 'Большая капитализация ($1-10 млрд)',
    'mid_cap': 'Средняя капитализация ($100 млн-1 млрд)',
    'small_cap': 'Малая капитализация ($10-100 млн)',
    'micro_cap': 'Микро-капитализация (<$10 млн)',
    'high_volume': 'Высокий объем (>$1 млрд)',
    'medium_volume': 'Средний объем ($100 млн-1 млрд)',
    'low_volume': 'Низкий объем (<$100 млн)',
    'livecoinwatch_only': 'Только LiveCoinWatch',
    'coingecko_only': 'Только CoinGecko',
    'both_platforms': 'Обе платформы',
    'please_enter_coin_symbol': 'Пожалуйста, введите символ монеты',
    'no_data_found_for': 'Данные не найдены для',
    'error_searching_for': 'Ошибка поиска для',
    'searching_for_coin_data': 'Поиск данных о монете...',
    'platforms_comparison_title': 'Сравнение данных LiveCoinWatch, CoinGecko, CoinMarketCal, CryptoCompare, CoinPaprika и Cryptics.tech',
});

Object.assign(languageTexts['fi'], {
    'market_comparison': 'Markkinoiden vertailuanalyysi',
    'total_coins': 'Kokonaiskolikot',
    'total_market_cap': 'Kokonaismarkkina-arvo',
    'total_volume': 'Kokonaisvolyymi',
    'total_markets': 'Kokonaismarkkinat',
    'total_exchanges': 'Kokonaispörssit',
    'total_events': 'Kokonaistapahtumat',
    'top_10_ranked': 'Top 10 sijoituksessa',
    'market_cap_distribution': 'Markkina-arvon jakautuminen',
    'price_movement_trends': '24h hintaliikkeen trendit',
    'volume_distribution': 'Volyymin jakautuminen',
    'platform_coverage': 'Alustan kattavuus',
    'top_10_coins_by_market_cap': 'Top 10 kolikkoa markkina-arvon mukaan',
    'market_trends_summary': 'Markkinatrendien yhteenveto',
    'gaining': 'Nousevat',
    'losing': 'Laskevat',
    'stable': 'Vakaat',
    'search_for_coin': 'Etsi kolikkoa (esim. bitcoin, ethereum)',
    'search': 'Etsi',
    'analysis_for': 'Analyysi kohteelle',
    'price': 'Hinta',
    'market_cap': 'Markkina-arvo',
    'volume': 'Volyymi',
    'last_updated': 'Viimeksi päivitetty',
    'rank': 'Sijoitus',
    '24h_change': '24h muutos',
    'circulating_supply': 'Liikkeessä oleva tarjonta',
    'max_supply': 'Maksimitarjonta',
    'ath': 'Kaikkien aikojen korkein',
    'hot_index': 'Kuumuusindeksi',
    'trending_index': 'Trendiindeksi',
    'significant_index': 'Merkittävyysindeksi',
    'mega_cap': 'Mega-arvo (>$10 mrd)',
    'large_cap': 'Suuri arvo ($1-10 mrd)',
    'mid_cap': 'Keskisuuri arvo ($100 milj-1 mrd)',
    'small_cap': 'Pieni arvo ($10-100 milj)',
    'micro_cap': 'Mikro-arvo (<$10 milj)',
    'high_volume': 'Korkea volyymi (>$1 mrd)',
    'medium_volume': 'Keskisuuri volyymi ($100 milj-1 mrd)',
    'low_volume': 'Matala volyymi (<$100 milj)',
    'livecoinwatch_only': 'Vain LiveCoinWatch',
    'coingecko_only': 'Vain CoinGecko',
    'both_platforms': 'Molemmat alustat',
    'please_enter_coin_symbol': 'Syötä kolikon symboli',
    'no_data_found_for': 'Tietoja ei löytynyt kohteelle',
    'error_searching_for': 'Virhe etsittäessä',
    'searching_for_coin_data': 'Etsitään kolikkotietoja...',
    'platforms_comparison_title': 'LiveCoinWatch-, CoinGecko-, CoinMarketCal-, CryptoCompare-, CoinPaprika- ja Cryptics.tech-tietojen vertailu',
});

Object.assign(languageTexts['hy'], {
    'market_comparison': 'Շուկաների համեմատական վերլուծություն',
    'total_coins': 'Ընդհանուր մետաղադրամներ',
    'total_market_cap': 'Ընդհանուր շուկայական կապիտալիզացիա',
    'total_volume': 'Ընդհանուր ծավալ',
    'total_markets': 'Ընդհանուր շուկաներ',
    'total_exchanges': 'Ընդհանուր բորսաներ',
    'total_events': 'Ընդհանուր իրադարձություններ',
    'top_10_ranked': 'Թոփ 10 դիրքով',
    'market_cap_distribution': 'Շուկայական կապիտալիզացիայի բաշխում',
    'price_movement_trends': '24ժ գնային շարժումների միտումներ',
    'volume_distribution': 'Ծավալի բաշխում',
    'platform_coverage': 'Հարթակի ծածկույթ',
    'top_10_coins_by_market_cap': 'Թոփ 10 մետաղադրամներ շուկայական կապիտալիզացիայով',
    'market_trends_summary': 'Շուկայական միտումների ամփոփում',
    'gaining': 'Աճող',
    'losing': 'Նվազող',
    'stable': 'Կայուն',
    'search_for_coin': 'Որոնել մետաղադրամ (օր. bitcoin, ethereum)',
    'search': 'Որոնել',
    'analysis_for': 'Վերլուծություն համար',
    'price': 'Գին',
    'market_cap': 'Շուկայական կապիտալիզացիա',
    'volume': 'Ծավալ',
    'last_updated': 'Վերջին թարմացում',
    'rank': 'Դիրք',
    '24h_change': '24ժ փոփոխություն',
    'circulating_supply': 'Շրջանառվող առաջարկ',
    'max_supply': 'Առավելագույն առաջարկ',
    'ath': 'Բոլոր ժամանակների բարձրագույն',
    'hot_index': 'Տաք ինդեքս',
    'trending_index': 'Միտումների ինդեքս',
    'significant_index': 'Կարևորության ինդեքս',
    'mega_cap': 'Մեգա կապիտալիզացիա (>$10 մլրդ)',
    'large_cap': 'Մեծ կապիտալիզացիա ($1-10 մլրդ)',
    'mid_cap': 'Միջին կապիտալիզացիա ($100 մլն-1 մլրդ)',
    'small_cap': 'Փոքր կապիտալիզացիա ($10-100 մլն)',
    'micro_cap': 'Միկրո կապիտալիզացիա (<$10 մլն)',
    'high_volume': 'Բարձր ծավալ (>$1 մլրդ)',
    'medium_volume': 'Միջին ծավալ ($100 մլն-1 մլրդ)',
    'low_volume': 'Ցածր ծավալ (<$100 մլն)',
    'livecoinwatch_only': 'Միայն LiveCoinWatch',
    'coingecko_only': 'Միայն CoinGecko',
    'both_platforms': 'Երկու հարթակներ',
    'please_enter_coin_symbol': 'Խնդրում ենք մուտքագրել մետաղադրամի սիմվոլ',
    'no_data_found_for': 'Տվյալներ չեն գտնվել համար',
    'error_searching_for': 'Սխալ որոնելիս',
    'searching_for_coin_data': 'Որոնվում են մետաղադրամի տվյալներ...',
    'platforms_comparison_title': 'LiveCoinWatch, CoinGecko, CoinMarketCal, CryptoCompare, CoinPaprika և Cryptics.tech տվյալների համեմատություն',
    
    // Breadcrumb menu items
    'dashboard': 'Վահանակ',
    'markets_comparison': 'Շուկաների համեմատություն',
    'live_coin_watch': 'Live Coin Watch',
    'coingecko': 'Coingecko',
    'coin_market_cal': 'Coin Market Cal',
    'crypto_compare': 'Crypto Compare',
    'coin_predictions': 'Մետաղադրամների կանխատեսումներ',
    // Main page loading UI
    'loading_title': 'CryptoTrading տվյալների բեռնում',
    'loading_subtitle': 'Տվյալների հավաքում տարբեր հարթակներից...',
    'initializing': 'Սկզբնավորում...',
    'waiting': 'Սպասում...',
    'LiveCoinWatch': 'LiveCoinWatch',
    'CoinGecko': 'CoinGecko',
    'CoinMarketCal': 'CoinMarketCal',
    'CryptoCompare': 'CryptoCompare',
    'CoinPaprika': 'CoinPaprika',
    'Cryptics.tech': 'Cryptics.tech',
    'tip_data_fetch': 'Տվյալները ստացվում են բազմակի կրիպտոհարթակներից',
    'tip_comprehensive': 'Սա ապահովում է համապարփակ շուկայի պատկեր',
    'tip_refresh': 'Տվյալները թարմացվում են ամեն մի քանի րոպեում',
    'coin_event_calendar': 'Մետաղադրամների իրադարձությունների օրացույց',
    'event': 'Իրադարձություն',
    'open_source': 'Բացել աղբյուրը',
    'close': 'Պատրաստ',
    'market_overview_charts': 'Շուկայի ակնարկային գծապատկերներ',
    'time_series_prices': 'Գների ժամանակային շարք',
    'market_dominance': 'Շուկայի դոմինանտություն',
    'top_volume_markets': 'Ամենաբարձր ծավալով շուկաներ',
});

function applyLanguageToPage(lang) {
    const texts = languageTexts[lang] || languageTexts.en;
    
    try {
        // Update all text content on the page
        updateTextContent(texts);
        
        // Update API calls with localization only on coin details pages
        if (window.location.pathname.includes('/details/')) {
            updateApiCalls(lang);
        }
        
        // Update chart titles and descriptions
        updateChartContent(lang);
        
        // Update timeline content
        updateTimelineContent(lang);
        
        // Update calendar content
        updateCalendarContent(lang);
        
        // Update page title
        updatePageTitle(lang);
        
        // Update market comparison section
        updateMarketComparisonSection(lang);
    } catch (error) {
        console.error('Error applying language to page:', error);
    }
}

function updateTextContent(texts) {
    try {
        // Update specific elements with data-lang-key attributes
        const langElements = document.querySelectorAll('[data-lang-key]');
        langElements.forEach(element => {
            const langKey = element.getAttribute('data-lang-key');
            if (texts[langKey]) {
                element.textContent = texts[langKey];
            }
        });
        
        // Update page titles and headers - be more selective
        const elementsToUpdate = [
            { selector: '.m-portlet__head-text', text: 'Coin Events' },
            { selector: '.tv-title-text', text: 'TradingView Chart' },
            { selector: 'h2 a[href="/tradingPairs"]', text: 'You can also add TradingView Pair here' },
            { selector: 'h2 a[href="/twitter"]', text: 'You can also relate a Twitter Account Here' },
            { selector: 'h2 a[href="/telegram"]', text: 'You can also relate a Telegram Account Here' }
        ];
        
        elementsToUpdate.forEach(item => {
            const elements = document.querySelectorAll(item.selector);
            elements.forEach(element => {
                if (element && element.textContent && element.textContent.includes(item.text)) {
                    element.textContent = element.textContent.replace(item.text, texts[item.text]);
                }
            });
        });
        
        // Update specific elements by their content - be more careful
        updateSpecificElements(texts);
        
    } catch (error) {
        console.error('Error updating text content:', error);
    }
}

function updateSpecificElements(texts) {
    try {
        // Update Coin Events header
        const coinEventsHeader = document.querySelector('.m-portlet__head-text');
        if (coinEventsHeader && coinEventsHeader.textContent && coinEventsHeader.textContent.includes('Coin Events')) {
            coinEventsHeader.textContent = texts['Coin Events'];
        }
        
        // Update TradingView Pair link
        const tradingViewLink = document.querySelector('h2 a[href="/tradingPairs"]');
        if (tradingViewLink && tradingViewLink.textContent && tradingViewLink.textContent.includes('You can also add TradingView Pair here')) {
            tradingViewLink.textContent = texts['You can also add TradingView Pair here'];
        }
        
        // Update Twitter link
        const twitterLink = document.querySelector('h2 a[href="/twitter"]');
        if (twitterLink && twitterLink.textContent && twitterLink.textContent.includes('You can also relate a Twitter Account Here')) {
            twitterLink.textContent = texts['You can also relate a Twitter Account Here'];
        }
        
        // Update Telegram link
        const telegramLink = document.querySelector('h2 a[href="/telegram"]');
        if (telegramLink && telegramLink.textContent && telegramLink.textContent.includes('You can also relate a Telegram Account Here')) {
            telegramLink.textContent = texts['You can also relate a Telegram Account Here'];
        }
        
        // Update stats labels - be very careful with this
        const statsElements = document.querySelectorAll('.coin-meta-stats div');
        if (statsElements && statsElements.length > 0) {
            // Gather all possible translations for each label
            const allLangs = Object.keys(languageTexts);
            const labelKeys = ['Price', 'Market Cap', 'Rank', 'Supply'];
            const labelTranslations = {};
            labelKeys.forEach(key => {
                labelTranslations[key] = allLangs.map(lang => (languageTexts[lang][key] || key) + ':');
            });
            statsElements.forEach(element => {
                if (element && element.innerHTML) {
                    labelKeys.forEach(key => {
                        labelTranslations[key].forEach(translatedLabel => {
                            if (element.innerHTML.includes(translatedLabel)) {
                                element.innerHTML = element.innerHTML.replace(translatedLabel, texts[key] + ':');
                            }
                        });
                    });
                }
            });
        }
        // Update .modern-title-text
        const modernTitle = document.querySelector('.modern-title-text[data-lang-key]');
        if (modernTitle && texts[modernTitle.getAttribute('data-lang-key')]) {
            modernTitle.textContent = texts[modernTitle.getAttribute('data-lang-key')];
        }
        // Update #darkModeText
        const darkModeText = document.getElementById('darkModeText');
        if (darkModeText && darkModeText.getAttribute('data-lang-key') && texts[darkModeText.getAttribute('data-lang-key')]) {
            darkModeText.textContent = texts[darkModeText.getAttribute('data-lang-key')];
        }
        // Update .tab-label
        document.querySelectorAll('.tab-label[data-lang-key]').forEach(el => {
            if (texts[el.getAttribute('data-lang-key')]) {
                el.textContent = texts[el.getAttribute('data-lang-key')];
            }
        });
        // Update .modern-reviews-title
        const reviewsTitle = document.querySelector('.modern-reviews-title[data-lang-key]');
        if (reviewsTitle && texts[reviewsTitle.getAttribute('data-lang-key')]) {
            reviewsTitle.textContent = texts[reviewsTitle.getAttribute('data-lang-key')];
        }
        // Update .modern-review-form-title
        const reviewFormTitle = document.querySelector('.modern-review-form-title[data-lang-key]');
        if (reviewFormTitle && texts[reviewFormTitle.getAttribute('data-lang-key')]) {
            reviewFormTitle.textContent = texts[reviewFormTitle.getAttribute('data-lang-key')];
        }
        // Update .modern-form-group label
        document.querySelectorAll('.modern-form-group label[data-lang-key]').forEach(el => {
            if (texts[el.getAttribute('data-lang-key')]) {
                el.childNodes[el.childNodes.length-1].nodeValue = ' ' + texts[el.getAttribute('data-lang-key')];
            }
        });
        // Update .modern-review-form-btn
        const reviewFormBtn = document.querySelector('.modern-review-form-btn[data-lang-key]');
        if (reviewFormBtn && texts[reviewFormBtn.getAttribute('data-lang-key')]) {
            reviewFormBtn.textContent = texts[reviewFormBtn.getAttribute('data-lang-key')];
        }
        // Update .lcw-info-card h2
        const lcwInfoH2 = document.querySelector('.lcw-info-card h2[data-lang-key]');
        if (lcwInfoH2 && texts[lcwInfoH2.getAttribute('data-lang-key')]) {
            lcwInfoH2.textContent = texts[lcwInfoH2.getAttribute('data-lang-key')];
        }
        // Update .lcw-info-card a
        const lcwInfoA = document.querySelector('.lcw-info-card a[data-lang-key]');
        if (lcwInfoA && texts[lcwInfoA.getAttribute('data-lang-key')]) {
            lcwInfoA.textContent = texts[lcwInfoA.getAttribute('data-lang-key')];
        }
        // Update all <option> in the review form
        document.querySelectorAll('.modern-review-form-container option[data-lang-key]').forEach(el => {
            if (texts[el.getAttribute('data-lang-key')]) {
                el.textContent = texts[el.getAttribute('data-lang-key')];
            }
        });
        // Update all .datatable-header-text
        document.querySelectorAll('.datatable-header-text[data-lang-key]').forEach(el => {
            if (texts[el.getAttribute('data-lang-key')]) {
                el.textContent = texts[el.getAttribute('data-lang-key')];
            }
        });
        // Update .lcw-info-card p:first-child (intro)
        const lcwInfoIntro = document.querySelector('.lcw-info-card .lcw-content p');
        if (lcwInfoIntro && texts['LCW Info Card Intro']) {
            // Try to preserve <strong>Live Coin Watch</strong> at the start
            const strong = lcwInfoIntro.querySelector('strong');
            if (strong) {
                strong.textContent = 'Live Coin Watch';
                lcwInfoIntro.innerHTML = lcwInfoIntro.innerHTML.replace(/^<strong>.*?<\/strong>\s*/, '<strong>Live Coin Watch</strong> ');
                lcwInfoIntro.innerHTML = '<strong>Live Coin Watch</strong> ' + texts['LCW Info Card Intro'].replace(/^Live Coin Watch/, '').trim();
            } else {
                lcwInfoIntro.textContent = texts['LCW Info Card Intro'];
            }
        }
        // Update .lcw-info-card p:nth-child(2) (change history)
        const lcwInfoChange = document.querySelector('.lcw-info-card .lcw-content p:nth-of-type(2)');
        if (lcwInfoChange && texts['LCW Info Card Change History']) {
            // Try to preserve <strong>Change History:</strong> at the start
            const strong = lcwInfoChange.querySelector('strong');
            if (strong) {
                strong.textContent = 'Change History:';
                lcwInfoChange.innerHTML = lcwInfoChange.innerHTML.replace(/^<strong>.*?<\/strong>\s*/, '<strong>Change History:</strong> ');
                lcwInfoChange.innerHTML = '<strong>Change History:</strong> ' + texts['LCW Info Card Change History'].replace(/^Change History:/, '').trim();
            } else {
                lcwInfoChange.textContent = texts['LCW Info Card Change History'];
            }
        }
    } catch (error) {
        console.error('Error updating specific elements:', error);
    }
}

function updateApiCalls(lang) {
    // Only update API calls if we're on a coin details page
    const coinTitle = document.getElementById('coinTitle');
    if (!coinTitle) {
        return; // Not on a coin details page
    }
    
    // Update CoinGecko API calls to include localization
    const coinId = getCoinIdFromUrl();
    if (coinId) {
        // Map common coin symbols to their full CoinGecko IDs
        const coinIdMapping = {
            'btc': 'bitcoin',
            'eth': 'ethereum',
            'bnb': 'binancecoin',
            'sol': 'solana',
            'ada': 'cardano',
            'xrp': 'ripple',
            'doge': 'dogecoin',
            'ton': 'the-open-network',
            'avax': 'avalanche-2',
            'shib': 'shiba-inu',
            'dot': 'polkadot',
            'trx': 'tron',
            'link': 'chainlink',
            'matic': 'matic-network',
            'bch': 'bitcoin-cash',
            'ltc': 'litecoin',
            'uni': 'uniswap',
            'atom': 'cosmos',
            'etc': 'ethereum-classic',
            'fil': 'filecoin',
            'icp': 'internet-computer',
            'near': 'near',
            'apt': 'aptos'
        };
        
        // Use mapped ID or fallback to the original coinId
        const mappedCoinId = coinIdMapping[coinId.toLowerCase()] || coinId;
        const apiUrl = `https://api.coingecko.com/api/v3/coins/${mappedCoinId}?localization=true&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false`;
        
        // Fetch updated data with localization
        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                updateCoinData(data, lang);
            })
            .catch(error => {
                console.error('Error fetching localized data:', error);
                // If the mapped ID fails, try with the original coinId as fallback
                if (mappedCoinId !== coinId) {
                    const fallbackUrl = `https://api.coingecko.com/api/v3/coins/${coinId}?localization=true&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false`;
                    return fetch(fallbackUrl)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            updateCoinData(data, lang);
                        })
                        .catch(fallbackError => {
                            console.error('Fallback API call also failed:', fallbackError);
                        });
                }
            });
    }
}

function getCoinIdFromUrl() {
    const path = window.location.pathname;
    const match = path.match(/\/details\/([^\/]+)/);
    return match ? match[1] : null;
}

function updateCoinData(data, lang) {
    // Only update coin data if we're on a coin details page
    const coinTitle = document.getElementById('coinTitle');
    if (!coinTitle) {
        return; // Not on a coin details page
    }
    
    // Update coin name and description based on language
    const localizedData = data.localization && data.localization[lang] ? data.localization[lang] : data.localization?.en || {};
    
    // Update coin title
    if (localizedData.name) {
        coinTitle.textContent = localizedData.name;
    }
    
    // Update coin description
    const coinDesc = document.getElementById('coinDesc');
    if (coinDesc && localizedData.description) {
        coinDesc.textContent = localizedData.description;
    }
    
    // Update page title
    if (localizedData.name) {
        document.title = `${localizedData.name} - Crypto Trading`;
    }
    
    // Update coin logo if it exists
    const coinLogo = document.getElementById('coinLogo');
    if (coinLogo && data.image && (data.image.large || data.image.small)) {
        coinLogo.src = data.image.large || data.image.small;
        coinLogo.alt = (localizedData.name || data.name) + ' logo';
    }
    
    // Update coin symbol if it exists
    const coinSymbol = document.getElementById('coinSymbol');
    if (coinSymbol && data.symbol) {
        coinSymbol.textContent = data.symbol.toUpperCase();
    }
    
    // Update coin price if it exists
    const coinPrice = document.getElementById('coinPrice');
    if (coinPrice && data.market_data && data.market_data.current_price && data.market_data.current_price.usd) {
        coinPrice.textContent = '$' + data.market_data.current_price.usd.toLocaleString('en-US', {maximumFractionDigits: 6});
    }
    
    // Update market cap if it exists
    const coinMarketCap = document.getElementById('coinMarketCap');
    if (coinMarketCap && data.market_data && data.market_data.market_cap && data.market_data.market_cap.usd) {
        coinMarketCap.textContent = '$' + data.market_data.market_cap.usd.toLocaleString('en-US', {maximumFractionDigits: 2});
    }
    
    // Update rank if it exists
    const coinRank = document.getElementById('coinRank');
    if (coinRank && data.market_cap_rank) {
        coinRank.textContent = '#' + data.market_cap_rank;
    }
    
    // Update supply if it exists
    const coinSupply = document.getElementById('coinSupply');
    if (coinSupply && data.market_data) {
        const circulating = data.market_data.circulating_supply;
        const max = data.market_data.max_supply;
        if (circulating !== null && circulating !== undefined) {
            const supplyText = circulating.toLocaleString('en-US', {maximumFractionDigits: 2});
            if (max !== null && max !== undefined) {
                coinSupply.textContent = supplyText + ' / ' + max.toLocaleString('en-US', {maximumFractionDigits: 2});
            } else {
                coinSupply.textContent = supplyText;
            }
        }
    }
}

function updateChartContent(lang) {
    try {
        const texts = languageTexts[lang] || languageTexts.en;
        
        // Update TradingView chart titles
        const chartTitles = document.querySelectorAll('.tv-title-text, .tv-title-subtitle');
        if (chartTitles && chartTitles.length > 0) {
            chartTitles.forEach(title => {
                if (title && title.textContent) {
                    if (title.textContent.includes('TradingView Chart')) {
                        title.textContent = title.textContent.replace('TradingView Chart', texts['TradingView Chart']);
                    }
                    if (title.textContent.includes('Technical Analysis')) {
                        title.textContent = title.textContent.replace('Technical Analysis', texts['Technical Analysis']);
                    }
                    if (title.textContent.includes('Market Cap & Volume')) {
                        title.textContent = title.textContent.replace('Market Cap & Volume', texts['Market Cap & Volume']);
                    }
                }
            });
        }
        
        // Update chart descriptions and labels
        const chartLabels = document.querySelectorAll('.tv-stat-label');
        if (chartLabels && chartLabels.length > 0) {
            chartLabels.forEach(label => {
                if (label && label.textContent) {
                    if (label.textContent.includes('Price')) {
                        label.textContent = label.textContent.replace('Price', texts['Price']);
                    }
                    if (label.textContent.includes('Volume')) {
                        label.textContent = label.textContent.replace('Volume', texts['Volume']);
                    }
                    if (label.textContent.includes('Change 24h')) {
                        label.textContent = label.textContent.replace('Change 24h', texts['Change 24h']);
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error updating chart content:', error);
    }
}

function updateTimelineContent(lang) {
    try {
        const texts = languageTexts[lang] || languageTexts.en;
        
        // Update timeline section titles
        const timelineTitles = document.querySelectorAll('.m-timeline-2 h3, .m-timeline-2 h4');
        if (timelineTitles && timelineTitles.length > 0) {
            timelineTitles.forEach(title => {
                if (title && title.textContent) {
                    if (title.textContent.includes('Telegram messages')) {
                        title.textContent = title.textContent.replace('Telegram messages', texts['Telegram messages']);
                    }
                    if (title.textContent.includes('Twitter messages')) {
                        title.textContent = title.textContent.replace('Twitter messages', texts['Twitter messages']);
                    }
                    if (title.textContent.includes('News updates')) {
                        title.textContent = title.textContent.replace('News updates', texts['News updates']);
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error updating timeline content:', error);
    }
}

function updateCalendarContent(lang) {
    try {
        const texts = languageTexts[lang] || languageTexts.en;
        
        // Update calendar month/year title
        const calendarTitle = document.querySelector('.fc-center h2');
        if (calendarTitle && calendarTitle.textContent) {
            // Extract month and year from the title
            const titleText = calendarTitle.textContent;
            const monthMatch = titleText.match(/^(\w+)\s+(\d{4})$/);
            if (monthMatch) {
                const month = monthMatch[1];
                const year = monthMatch[2];
                const translatedMonth = texts[month] || month;
                calendarTitle.textContent = `${translatedMonth} ${year}`;
            }
        }
        
        // Update day headers (Sun, Mon, Tue, etc.)
        const dayHeaders = document.querySelectorAll('.fc-day-header');
        dayHeaders.forEach(header => {
            if (header && header.textContent) {
                const dayText = header.textContent.trim();
                const translatedDay = texts[dayText] || dayText;
                header.textContent = translatedDay;
            }
        });
        
        // Update calendar buttons
        const buttons = document.querySelectorAll('.fc-button');
        buttons.forEach(button => {
            if (button && button.textContent) {
                const buttonText = button.textContent.trim();
                const translatedButton = texts[buttonText] || buttonText;
                button.textContent = translatedButton;
            }
        });
        
        // Update "Today" button
        const todayButton = document.querySelector('.fc-today-button');
        if (todayButton && todayButton.textContent) {
            todayButton.textContent = texts['Today'] || 'Today';
        }
        
        // Update "More" links
        const moreLinks = document.querySelectorAll('.fc-more');
        moreLinks.forEach(link => {
            if (link && link.textContent) {
                link.textContent = texts['More'] || 'More';
            }
        });
        
        // Update "No events" text
        const noEvents = document.querySelectorAll('.fc-no-events');
        noEvents.forEach(element => {
            if (element && element.textContent) {
                element.textContent = texts['No events'] || 'No events';
            }
        });
        
        // Update "All Day" text
        const allDayElements = document.querySelectorAll('.fc-all-day');
        allDayElements.forEach(element => {
            if (element && element.textContent) {
                element.textContent = texts['All Day'] || 'All Day';
            }
        });
        
        // Update list view headers
        const listHeaders = document.querySelectorAll('.fc-list-heading');
        listHeaders.forEach(header => {
            if (header && header.textContent) {
                const headerText = header.textContent.trim();
                // Handle different list view headers
                if (headerText.includes('All Day')) {
                    header.textContent = headerText.replace('All Day', texts['All Day'] || 'All Day');
                }
            }
        });
        
        // Update time grid headers
        const timeHeaders = document.querySelectorAll('.fc-time-grid .fc-day-header');
        timeHeaders.forEach(header => {
            if (header && header.textContent) {
                const dayText = header.textContent.trim();
                const translatedDay = texts[dayText] || dayText;
                header.textContent = translatedDay;
            }
        });
        
        // Update agenda view elements
        const agendaElements = document.querySelectorAll('.fc-agenda-view .fc-day-header');
        agendaElements.forEach(element => {
            if (element && element.textContent) {
                const dayText = element.textContent.trim();
                const translatedDay = texts[dayText] || dayText;
                element.textContent = translatedDay;
            }
        });
        
        // Update week view elements
        const weekElements = document.querySelectorAll('.fc-week-view .fc-day-header');
        weekElements.forEach(element => {
            if (element && element.textContent) {
                const dayText = element.textContent.trim();
                const translatedDay = texts[dayText] || dayText;
                element.textContent = translatedDay;
            }
        });
        
        // Update month view elements
        const monthElements = document.querySelectorAll('.fc-month-view .fc-day-header');
        monthElements.forEach(element => {
            if (element && element.textContent) {
                const dayText = element.textContent.trim();
                const translatedDay = texts[dayText] || dayText;
                element.textContent = translatedDay;
            }
        });
        
        // Update day view elements
        const dayElements = document.querySelectorAll('.fc-day-view .fc-day-header');
        dayElements.forEach(element => {
            if (element && element.textContent) {
                const dayText = element.textContent.trim();
                const translatedDay = texts[dayText] || dayText;
                element.textContent = translatedDay;
            }
        });
        
    } catch (error) {
        console.error('Error updating calendar content:', error);
    }
}

function updatePageTitle(lang) {
    try {
        const texts = languageTexts[lang] || languageTexts.en;
        const currentTitle = document.title;
        
        if (currentTitle) {
            // Update common title patterns
            if (currentTitle.includes('Crypto Trading')) {
                document.title = currentTitle.replace('Crypto Trading', texts['Cryptocurrency Trading']);
            }
            
            if (currentTitle.includes('Coin Details')) {
                document.title = currentTitle.replace('Coin Details', texts['Coin Details']);
            }
            if (currentTitle.includes('Livecoin History')) {
                document.title = currentTitle.replace('Livecoin History', texts['Livecoin History']);
            }
        }
    } catch (error) {
        console.error('Error updating page title:', error);
    }
}

function setCurrentLanguage(lang, flag) {
    try {
        const currentLanguage = document.getElementById('currentLanguage');
        const currentFlag = document.getElementById('currentFlag');
        const languageOptions = document.querySelectorAll('.language-option');
        
        // Language names mapping
        const languageNames = {
            'en': 'English',
            'ru': 'Русский',
            'hy': 'Հայերեն',
            'fi': 'Suomi'
        };
        
        // Flag SVGs mapping
        const flagSvgs = {
            'us': '<svg width="20" height="15" viewBox="0 0 20 15" fill="none"><rect width="20" height="15" fill="#1E40AF"/><rect width="20" height="3" fill="#FFFFFF"/><rect y="6" width="20" height="3" fill="#FFFFFF"/><rect y="12" width="20" height="3" fill="#FFFFFF"/><rect width="10" height="8" fill="#DC2626"/><g fill="#FFFFFF"><polygon points="2,1 2.5,2.5 4,2 3.5,3.5 5,4 3.5,4.5 4,6 2.5,5.5 2,7 1.5,5.5 0,6 0.5,4.5 -1,4 0.5,3.5"/></g></svg>',
            'ru': '<svg width="20" height="15" viewBox="0 0 20 15" fill="none"><rect width="20" height="15" fill="#FFFFFF"/><rect y="5" width="20" height="5" fill="#0052CC"/><rect y="10" width="20" height="5" fill="#DC2626"/></svg>',
            'am': '<svg width="20" height="15" viewBox="0 0 20 15" fill="none"><rect width="20" height="5" fill="#0052CC"/><rect y="5" width="20" height="5" fill="#FFD700"/><rect y="10" width="20" height="5" fill="#DC2626"/></svg>',
            'fi': '<svg width="20" height="15" viewBox="0 0 20 15" fill="none"><rect width="20" height="15" fill="#FFFFFF"/><rect width="3" height="15" fill="#0052CC"/><rect y="5" width="20" height="3" fill="#0052CC"/></svg>'
        };
        
        // Update current language display
        if (currentLanguage) {
            currentLanguage.textContent = languageNames[lang] || 'English';
        }
        
        // Update current flag
        if (currentFlag) {
            currentFlag.innerHTML = flagSvgs[flag] || flagSvgs['us'];
        }
        
        // Update selected state in dropdown
        if (languageOptions && languageOptions.length > 0) {
            languageOptions.forEach(option => {
                if (option) {
                    option.classList.remove('selected');
                    if (option.dataset.lang === lang) {
                        option.classList.add('selected');
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error setting current language:', error);
    }
}

function showLanguageChangeMessage(lang) {
    try {
        // Create a temporary notification
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            font-size: 14px;
            font-weight: 500;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        const languageNames = {
            'en': 'English',
            'ru': 'Русский',
            'hy': 'Հայերեն',
            'fi': 'Suomi'
        };
        
        const texts = languageTexts[lang] || languageTexts.en;
        notification.textContent = `${texts['Language changed to']} ${languageNames[lang] || 'English'}`;
        
        if (document.body) {
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                if (notification && notification.style) {
                    notification.style.transform = 'translateX(0)';
                }
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                if (notification && notification.style) {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        if (document.body && notification.parentNode) {
                            document.body.removeChild(notification);
                        }
                    }, 300);
                }
            }, 3000);
        }
    } catch (error) {
        console.error('Error showing language change message:', error);
    }
}

function updateMarketComparisonSection(lang) {
    const texts = languageTexts[lang] || languageTexts.en;
    
    try {
        // Update main title
        const mainTitle = document.querySelector('[data-lang-key="market_comparison"]');
        if (mainTitle && texts['market_comparison']) {
            mainTitle.textContent = texts['market_comparison'];
        }
        
        // Update platform overview cards
        const statLabels = document.querySelectorAll('.stat-label');
        statLabels.forEach(label => {
            const text = label.textContent.trim();
            if (texts[text]) {
                label.textContent = texts[text];
            }
        });
        
        // Update chart titles
        const chartTitles = document.querySelectorAll('.chart-card h4');
        chartTitles.forEach(title => {
            const text = title.textContent.trim();
            if (texts[text]) {
                title.textContent = texts[text];
            }
        });
        
        // Update table headers
        const tableHeaders = document.querySelectorAll('#topPerformersTable th');
        tableHeaders.forEach(header => {
            const text = header.textContent.trim();
            if (texts[text]) {
                header.textContent = texts[text];
            }
        });
        
        // Update trends summary labels
        const trendLabels = document.querySelectorAll('.trend-label');
        trendLabels.forEach(label => {
            const text = label.textContent.trim();
            if (texts[text]) {
                label.textContent = texts[text];
            }
        });
        
        // Update search placeholder and button
        const searchInput = document.getElementById('coinSearchInput');
        if (searchInput && texts['search_for_coin']) {
            searchInput.placeholder = texts['search_for_coin'];
        }
        
        const searchBtn = document.getElementById('searchCoinBtn');
        if (searchBtn && texts['search']) {
            searchBtn.textContent = texts['search'];
        }
        
        // Update elements with data-lang-key attributes
        const langElements = document.querySelectorAll('[data-lang-key]');
        langElements.forEach(element => {
            const langKey = element.getAttribute('data-lang-key');
            if (texts[langKey]) {
                // Special handling for input placeholders
                if (element.tagName === 'INPUT' && element.placeholder) {
                    element.placeholder = texts[langKey];
                } else {
                    element.textContent = texts[langKey];
                }
            }
        });
        
        // Update chart labels if charts exist
        updateMarketComparisonCharts(lang);
    } catch (error) {
        console.error('Error updating market comparison section:', error);
    }
}

function updateMarketComparisonCharts(lang) {
    const texts = languageTexts[lang] || languageTexts.en;
    
    try {
        // Update market cap distribution chart
        if (window.comparisonCharts && window.comparisonCharts.marketCap) {
            const chart = window.comparisonCharts.marketCap;
            chart.data.labels = [
                texts['mega_cap'] || 'Mega Cap (>$10B)',
                texts['large_cap'] || 'Large Cap ($1B-$10B)',
                texts['mid_cap'] || 'Mid Cap ($100M-$1B)',
                texts['small_cap'] || 'Small Cap ($10M-$100M)',
                texts['micro_cap'] || 'Micro Cap (<$10M)'
            ];
            chart.update();
        }
        
        // Update price trends chart
        if (window.comparisonCharts && window.comparisonCharts.priceTrends) {
            const chart = window.comparisonCharts.priceTrends;
            chart.data.labels = [
                texts['gaining'] || 'Gaining',
                texts['losing'] || 'Losing',
                texts['stable'] || 'Stable'
            ];
            chart.update();
        }
        
        // Update volume chart
        if (window.comparisonCharts && window.comparisonCharts.volume) {
            const chart = window.comparisonCharts.volume;
            chart.data.labels = [
                texts['high_volume'] || 'High Volume (>$1B)',
                texts['medium_volume'] || 'Medium Volume ($100M-$1B)',
                texts['low_volume'] || 'Low Volume (<$100M)'
            ];
            chart.update();
        }
        
        // Update platform chart
        if (window.comparisonCharts && window.comparisonCharts.platform) {
            const chart = window.comparisonCharts.platform;
            chart.data.labels = [
                texts['livecoinwatch_only'] || 'LiveCoinWatch Only',
                texts['coingecko_only'] || 'CoinGecko Only',
                texts['both_platforms'] || 'Both Platforms'
            ];
            chart.update();
        }
        
    } catch (error) {
        console.error('Error updating market comparison charts:', error);
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
    
    // Initialize language switcher only if we're on a page that supports it
    // or if we're on the main pages (not admin or other special pages)
    const currentPath = window.location.pathname;
    const isMainPage = !currentPath.includes('/admin') && 
                      !currentPath.includes('/api') && 
                      !currentPath.includes('/vendor') &&
                      !currentPath.includes('/storage');
    
    if (isMainPage) {
        // Add a small delay to ensure DOM is fully loaded
        setTimeout(() => {
            try {
                initLanguageSwitcher();
                
                // Listen for language changes to update calendar
                document.addEventListener('languageChanged', function(e) {
                    setTimeout(() => {
                        updateCalendarContent(e.detail.language);
                    }, 200);
                });
            } catch (error) {
                console.error('Language switcher initialization failed:', error);
                // Hide the language switcher if it fails
                const languageSwitcher = document.getElementById('languageSwitcher');
                if (languageSwitcher) {
                    languageSwitcher.style.display = 'none';
                }
            }
        }, 100);
    }
    
    // Run after any dynamic content is loaded
    setTimeout(convertUrlsToLinks, 1000);
});