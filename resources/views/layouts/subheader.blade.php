<!-- BEGIN: Subheader -->
<div class="m-subheader">
    <div class="subheader-container">
        <div class="subheader-left">
            <h3 class="m-subheader__title" data-lang-key="dashboard">
                Dashboard
            </h3>
            <ul class="mt-5 m-subheader__breadcrumbs m-nav m-nav--inline enhanced-breadcrumbs modern-breadcrumbs">
                <li class="breadcrumb-item">
                    <a href="/" class="breadcrumb-link" aria-label="Navigate to Markets Comparison">
                        <svg class="breadcrumb-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9,22 9,12 15,12 15,22"/>
                        </svg>
                        <span class="breadcrumb-text">Markets Comparison</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/history" class="breadcrumb-link" aria-label="Navigate to Live Coin Watch">
                        <svg class="breadcrumb-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12,6 12,12 16,14"/>
                        </svg>
                        <span class="breadcrumb-text">Live Coin Watch</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/coingeckomarketsindex" class="breadcrumb-link" aria-label="Navigate to Coingecko">
                        <svg class="breadcrumb-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span class="breadcrumb-text">Coingecko</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/coinmarketcalindex" class="breadcrumb-link" aria-label="Navigate to Coin Market Cal">
                        <svg class="breadcrumb-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <span class="breadcrumb-text">Coin Market Cal</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/cryptocomparecoinsindex" class="breadcrumb-link" aria-label="Navigate to Coingecko">
                        <svg class="breadcrumb-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span class="breadcrumb-text">Crypto Compare</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/coinmpredictions" class="breadcrumb-link special-highlight" aria-label="Navigate to Coin Predictions">
                        <svg class="breadcrumb-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4"/>
                            <path d="M21 12c-1 0-2-1-2-2s1-2 2-2 2 1 2 2-1 2-2 2z"/>
                            <path d="M3 12c1 0 2-1 2-2s-1-2-2-2-2 1-2 2 1 2 2 2z"/>
                            <path d="M12 3c0 1-1 2-2 2s-2-1-2-2 1-2 2-2 2 1 2 2z"/>
                            <path d="M12 21c0-1 1-2 2-2s2 1 2 2-1 2-2 2-2-1-2-2z"/>
                        </svg>
                        <span class="breadcrumb-text">Coin Predictions</span>
                        <span class="highlight-badge">New</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="subheader-right">
            <button type="button" id="updateAllData" class="modern-update-btn modern-update-btn-fancy" aria-live="polite" aria-busy="false">
                <span class="confetti"></span>
                <span class="btn-icon" id="updateAllDataSpinner">
                    <svg width="20" height="20" viewBox="0 0 50 50" class="spinner" aria-hidden="true">
                        <circle cx="25" cy="25" r="20" fill="none" stroke="#fff" stroke-width="5" stroke-linecap="round" stroke-dasharray="31.415, 31.415" transform="rotate(0 25 25)">
                            <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/>
                        </circle>
                    </svg>
                </span>
                <span class="btn-content">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="12" r="5" fill="#ffd200"/>
                    </svg>
                    <span id="updateAllDataText" data-lang-key="update_all_data">Update All Data</span>
                </span>
            </button>
        </div>
    </div>
</div>
<!-- END: Subheader -->

<style>
    /* Subheader Container Layout */
    .subheader-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        gap: 20px;
    }

    .subheader-left {
        display: flex;
        align-items: center;
        flex: 1;
        min-width: 0;
        gap: 20px;
    }

    .subheader-right {
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }

    /* Dashboard Title */
    .m-subheader__title {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
        color: #374151;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* Modern Breadcrumb Navigation - Horizontal Layout */
    .modern-breadcrumbs {
        display: flex;
        align-items: center;
        gap: 0;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-wrap: nowrap;
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: #d1d5db transparent;
        white-space: nowrap;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 12px;
        padding: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        flex: 1;
    }

    .modern-breadcrumbs::-webkit-scrollbar {
        height: 4px;
    }

    .modern-breadcrumbs::-webkit-scrollbar-track {
        background: transparent;
    }

    .modern-breadcrumbs::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 2px;
    }

    .modern-breadcrumbs::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }

    .breadcrumb-item {
        position: relative;
        margin: 0;
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }

    .breadcrumb-item:not(:last-child)::after {
        content: '';
        width: 6px;
        height: 6px;
        background: #d1d5db;
        border-radius: 50%;
        margin: 0 8px;
        flex-shrink: 0;
        opacity: 0.6;
    }

    .breadcrumb-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        color: #6b7280;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        background: transparent;
        border: 1px solid transparent;
        white-space: nowrap;
        min-width: fit-content;
        max-width: none;
        overflow: hidden;
    }

    .breadcrumb-link:hover {
        color: #374151;
        background: rgba(59, 130, 246, 0.08);
        border-color: rgba(59, 130, 246, 0.2);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
    }

    .breadcrumb-link:focus {
        outline: none;
        color: #2563eb;
        background: rgba(59, 130, 246, 0.12);
        border-color: rgba(59, 130, 246, 0.3);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .breadcrumb-link:active {
        transform: translateY(0);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .breadcrumb-icon {
        flex-shrink: 0;
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }

    .breadcrumb-link:hover .breadcrumb-icon {
        opacity: 1;
    }

    .breadcrumb-text {
        position: relative;
        z-index: 1;
        overflow: visible;
        text-overflow: clip;
        white-space: nowrap;
    }

    /* Special highlight for Coin Predictions */
    .breadcrumb-link.special-highlight {
        background: linear-gradient(135deg, #f59e0b, #f97316);
        color: #fff;
        border-color: #f59e0b;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        position: relative;
        animation: specialGlow 3s ease-in-out infinite;
    }

    .breadcrumb-link.special-highlight:hover {
        background: linear-gradient(135deg, #d97706, #ea580c);
        color: #fff;
        border-color: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }

    .breadcrumb-link.special-highlight:focus {
        background: linear-gradient(135deg, #d97706, #ea580c);
        color: #fff;
        border-color: #d97706;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.3);
    }

    .breadcrumb-link.special-highlight .breadcrumb-icon {
        opacity: 1;
        color: #fff;
    }

    .highlight-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background: #ef4444;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 10px;
        animation: badgePulse 2s ease-in-out infinite;
        z-index: 2;
    }

    @keyframes specialGlow {
        0%, 100% {
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }
        50% {
            box-shadow: 0 4px 16px rgba(245, 158, 11, 0.5);
        }
    }

    @keyframes badgePulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    /* Active state for current page */
    .breadcrumb-item.active .breadcrumb-link {
        color: #2563eb;
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.3);
        font-weight: 600;
    }

    /* Update All Data Button */
    .modern-update-btn.modern-update-btn-fancy {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(270deg, #ff512f, #f7971e, #ffd200, #43cea2, #185a9d, #6a11cb, #ff512f);
        background-size: 1400% 1400%;
        animation: gradientFlow 8s ease infinite;
        color: #fff;
        font-weight: 800;
        font-size: 1.15rem;
        border: none;
        border-radius: 40px;
        padding: 16px 38px;
        box-shadow: 0 6px 24px 0 rgba(255, 81, 47, 0.18), 0 1.5px 8px 0 rgba(67, 206, 162, 0.10);
        cursor: pointer;
        transition: box-shadow 0.2s, transform 0.1s;
        outline: none;
        position: relative;
        min-width: 200px;
        letter-spacing: 0.7px;
        text-shadow: 0 2px 8px rgba(255, 255, 255, 0.12);
        overflow: hidden;
    }

    .modern-update-btn.modern-update-btn-fancy:focus {
        box-shadow: 0 0 0 4px #ffd20055, 0 6px 24px 0 rgba(255, 81, 47, 0.18);
    }

    .modern-update-btn.modern-update-btn-fancy:hover:not(:disabled):not([aria-busy="true"]) {
        box-shadow: 0 8px 32px 0 rgba(221, 36, 118, 0.18), 0 2px 12px 0 rgba(67, 206, 162, 0.12);
        transform: translateY(-2px) scale(1.05);
        filter: brightness(1.08);
    }

    .modern-update-btn.modern-update-btn-fancy:active {
        animation: bounce 0.3s;
        transform: scale(0.97);
    }

    .confetti {
        pointer-events: none;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
        display: none;
    }

    .btn-icon {
        display: none;
        margin-right: 8px;
    }

    .btn-content {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    #updateAllDataText {
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes gradientFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes bounce {
        0% { transform: scale(1); }
        30% { transform: scale(1.08); }
        50% { transform: scale(0.97); }
        100% { transform: scale(1); }
    }

    @keyframes spin {
        100% { transform: rotate(360deg); }
    }

    /* Responsive design */
    @media (max-width: 1400px) {
        .breadcrumb-link {
            padding: 6px 10px;
            font-size: 13px;
            gap: 5px;
        }
        
        .breadcrumb-item:not(:last-child)::after {
            margin: 0 6px;
        }
    }

    @media (max-width: 1200px) {
        .subheader-left {
            gap: 15px;
        }
        
        .breadcrumb-link {
            padding: 5px 8px;
            font-size: 12px;
            gap: 4px;
        }
        
        .breadcrumb-item:not(:last-child)::after {
            margin: 0 5px;
            width: 4px;
            height: 4px;
        }
        
        .modern-update-btn.modern-update-btn-fancy {
            padding: 14px 32px;
            font-size: 1.1rem;
            min-width: 180px;
        }
    }

    @media (max-width: 992px) {
        .subheader-container {
            gap: 15px;
        }
        
        .subheader-left {
            gap: 12px;
        }
        
        .modern-breadcrumbs {
            padding: 3px;
            border-radius: 10px;
        }
        
        .breadcrumb-link {
            padding: 4px 6px;
            font-size: 11px;
            gap: 3px;
            border-radius: 6px;
        }
        
        .breadcrumb-item:not(:last-child)::after {
            margin: 0 4px;
            width: 3px;
            height: 3px;
        }
        
        .modern-update-btn.modern-update-btn-fancy {
            padding: 12px 28px;
            font-size: 1rem;
            min-width: 160px;
        }
    }

    @media (max-width: 768px) {
        .subheader-container {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
            padding: 0 16px;
        }
        
        .subheader-left {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        
        .m-subheader__title {
            font-size: 1.4rem;
            text-align: center;
            margin-bottom: 8px;
        }
        
        /* Enhanced mobile-friendly breadcrumb redesign - Inspired by modern mobile apps */
        .modern-breadcrumbs {
            width: 100%;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-wrap: nowrap;
            min-height: auto;
        }
        
        .modern-breadcrumbs::-webkit-scrollbar {
            display: none;
        }
        
        /* Remove gradient fade indicators for mobile */
        .modern-breadcrumbs::before,
        .modern-breadcrumbs::after {
            display: none;
        }
        
        .breadcrumb-item {
            position: relative;
            z-index: 2;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            width: 100%;
            margin: 0;
        }
        
        /* Remove separators on mobile for cleaner look */
        .breadcrumb-item:not(:last-child)::after {
            display: none;
        }
        
        .breadcrumb-link {
            width: 100%;
            padding: 16px 20px;
            font-size: 16px;
            font-weight: 500;
            gap: 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(226, 232, 240, 0.8);
            color: #475569;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 100%;
            position: relative;
            backdrop-filter: blur(10px);
            white-space: nowrap;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            min-height: 56px;
            touch-action: manipulation;
            text-align: left;
        }
        
        .breadcrumb-link:hover {
            background: rgba(255, 255, 255, 1);
            border-color: #cbd5e1;
            color: #374151;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .breadcrumb-link:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
        
        .breadcrumb-link:focus {
            outline: none;
            background: rgba(255, 255, 255, 1);
            border-color: #3b82f6;
            color: #1e40af;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .breadcrumb-icon {
            width: 20px;
            height: 20px;
            opacity: 0.8;
            flex-shrink: 0;
            margin-right: 8px;
        }
        
        .breadcrumb-text {
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: none;
            flex: 1;
            font-size: 16px;
        }
        
        /* Enhanced special highlight for mobile */
        .breadcrumb-link.special-highlight {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            color: #fff;
            border-color: #f59e0b;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            animation: specialGlow 3s ease-in-out infinite;
        }
        
        .breadcrumb-link.special-highlight:hover {
            background: linear-gradient(135deg, #d97706, #ea580c);
            color: #fff;
            border-color: #d97706;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
        }
        
        .highlight-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 6px;
            border-radius: 12px;
            animation: badgePulse 2s ease-in-out infinite;
            z-index: 3;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    }

    @media (max-width: 480px) {
        .subheader-container {
            gap: 12px;
            padding: 0 12px;
        }
        
        .subheader-left {
            gap: 10px;
        }
        
        .m-subheader__title {
            font-size: 1.3rem;
        }
        
        .modern-breadcrumbs {
            padding: 6px;
            border-radius: 14px;
            min-height: auto;
            gap: 6px;
        }
        
        .breadcrumb-link {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            gap: 10px;
            border-radius: 10px;
            min-height: 52px;
        }
        
        .breadcrumb-item {
            width: 100%;
        }
        
        .breadcrumb-icon {
            width: 18px;
            height: 18px;
            margin-right: 6px;
        }
        
        .breadcrumb-text {
            max-width: none;
            flex: 1;
            font-size: 15px;
        }
        
        .highlight-badge {
            font-size: 9px;
            padding: 2px 5px;
            top: -6px;
            right: -6px;
            border-radius: 10px;
        }
        
        .modern-update-btn.modern-update-btn-fancy {
            padding: 14px 20px;
            font-size: 1rem;
            border-radius: 14px;
        }
    }

    @media (max-width: 360px) {
        .subheader-container {
            gap: 10px;
            padding: 0 8px;
        }
        
        .subheader-left {
            gap: 8px;
        }
        
        .m-subheader__title {
            font-size: 1.2rem;
        }
        
        .modern-breadcrumbs {
            padding: 4px;
            border-radius: 12px;
            min-height: auto;
            gap: 4px;
        }
        
        .breadcrumb-link {
            width: 100%;
            padding: 12px 14px;
            font-size: 14px;
            gap: 8px;
            border-radius: 8px;
            min-height: 48px;
        }
        
        .breadcrumb-item {
            width: 100%;
        }
        
        .breadcrumb-icon {
            width: 16px;
            height: 16px;
            margin-right: 4px;
        }
        
        .breadcrumb-text {
            max-width: none;
            flex: 1;
            font-size: 14px;
        }
        
        .highlight-badge {
            font-size: 8px;
            padding: 1px 4px;
            top: -5px;
            right: -5px;
            border-radius: 8px;
        }
        
        .modern-update-btn.modern-update-btn-fancy {
            padding: 12px 16px;
            font-size: 0.95rem;
            border-radius: 12px;
        }
    }

    /* Additional touch-friendly improvements for all mobile devices */
    @media (max-width: 768px) {
        .breadcrumb-link {
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            user-select: none;
        }
        
        .breadcrumb-link:active {
            -webkit-transform: scale(0.98);
            transform: scale(0.98);
        }
        
        /* Improve scroll performance */
        .modern-breadcrumbs {
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }
        
        /* Better focus indicators for accessibility */
        .breadcrumb-link:focus-visible {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }
        
        /* Enhanced mobile breadcrumb container */
        .modern-breadcrumbs {
            /* Add subtle animation for better UX */
            animation: slideInUp 0.3s ease-out;
        }
        
        /* Individual breadcrumb item animations */
        .breadcrumb-item {
            animation: fadeInUp 0.3s ease-out;
            animation-fill-mode: both;
        }
        
        .breadcrumb-item:nth-child(1) { animation-delay: 0.1s; }
        .breadcrumb-item:nth-child(2) { animation-delay: 0.2s; }
        .breadcrumb-item:nth-child(3) { animation-delay: 0.3s; }
        .breadcrumb-item:nth-child(4) { animation-delay: 0.4s; }
        .breadcrumb-item:nth-child(5) { animation-delay: 0.5s; }
        .breadcrumb-item:nth-child(6) { animation-delay: 0.6s; }
        
        /* Enhanced touch feedback */
        .breadcrumb-link {
            position: relative;
            overflow: hidden;
        }
        
        .breadcrumb-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }
        
        .breadcrumb-link:active::before {
            left: 100%;
        }
        
        /* Improved visual hierarchy */
        .breadcrumb-link {
            border-left: 4px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .breadcrumb-link:hover {
            border-left-color: #3b82f6;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(59, 130, 246, 0.1) 100%);
        }
        
        /* Special styling for active/current page */
        .breadcrumb-item.active .breadcrumb-link {
            border-left-color: #10b981;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.15) 100%);
            color: #065f46;
            font-weight: 600;
        }
        
        /* Enhanced special highlight for mobile */
        .breadcrumb-link.special-highlight {
            border-left-color: #f59e0b;
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            animation: specialGlow 3s ease-in-out infinite;
        }
        
        .breadcrumb-link.special-highlight:hover {
            background: linear-gradient(135deg, #d97706 0%, #ea580c 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
        }
        
        /* Improved badge positioning for mobile */
        .highlight-badge {
            position: absolute;
            top: -6px;
            right: 12px;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 6px;
            border-radius: 12px;
            animation: badgePulse 2s ease-in-out infinite;
            z-index: 3;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        /* Add subtle shadows for depth */
        .modern-breadcrumbs {
            box-shadow: 
                0 4px 16px rgba(0, 0, 0, 0.08),
                0 2px 8px rgba(0, 0, 0, 0.04);
        }
        
        .breadcrumb-link {
            box-shadow: 
                0 2px 8px rgba(0, 0, 0, 0.06),
                0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        /* Smooth animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Enhanced loading state */
        .modern-breadcrumbs.loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Improved accessibility for screen readers */
        .breadcrumb-link {
            position: relative;
        }
        
        .breadcrumb-link::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 12px;
            pointer-events: none;
        }
        
        /* Better contrast for text */
        .breadcrumb-text {
            color: #1f2937;
            font-weight: 500;
        }
        
        .breadcrumb-link:hover .breadcrumb-text {
            color: #111827;
        }
        
        /* Enhanced icon styling */
        .breadcrumb-icon {
            color: #6b7280;
            transition: color 0.3s ease;
        }
        
        .breadcrumb-link:hover .breadcrumb-icon {
            color: #374151;
        }
        
        .breadcrumb-link.special-highlight .breadcrumb-icon {
            color: #fff;
        }
    }

    /* Ensure proper text sizing on iOS */
    @media screen and (-webkit-min-device-pixel-ratio: 0) {
        .breadcrumb-text {
            font-size: 16px;
        }
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .breadcrumb-link {
            border-width: 2px;
        }
        
        .breadcrumb-link:focus {
            border-width: 3px;
        }
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        .breadcrumb-link {
            transition: none;
        }
        
        .breadcrumb-link:hover {
            transform: none;
        }
        
        .breadcrumb-link.special-highlight {
            animation: none;
        }
        
        .highlight-badge {
            animation: none;
        }
    }
</style>
<script>
// Confetti effect for Update All Data button
(function() {
    function createConfettiPiece(color, left, delay) {
        var el = document.createElement('span');
        el.style.position = 'absolute';
        el.style.left = left + '%';
        el.style.top = '50%';
        el.style.width = '10px';
        el.style.height = '10px';
        el.style.background = color;
        el.style.borderRadius = '50%';
        el.style.opacity = 0.85;
        el.style.transform = 'translateY(0) scale(1)';
        el.style.transition = 'transform 0.9s cubic-bezier(.62,.28,.23,.99) ' + delay + 'ms, opacity 0.7s ' + delay + 'ms';
        return el;
    }
    function showConfetti(btn) {
        var confettiColors = ['#ffd200','#ff512f','#43cea2','#6a11cb','#f7971e','#185a9d','#ffb300','#ff69b4'];
        var confetti = btn.querySelector('.confetti');
        if (!confetti) return;
        confetti.innerHTML = '';
        confetti.style.display = 'block';
        for (var i = 0; i < 18; i++) {
            var color = confettiColors[Math.floor(Math.random()*confettiColors.length)];
            var left = Math.random()*100;
            var delay = Math.random()*200;
            var el = createConfettiPiece(color, left, delay);
            confetti.appendChild(el);
            setTimeout((function(el) {
                return function() {
                    el.style.transform = 'translateY(' + (Math.random()*-80-40) + 'px) scale(' + (Math.random()*0.7+0.7) + ')';
                    el.style.opacity = 0;
                }
            })(el), 30+delay);
        }
        setTimeout(function() {
            confetti.style.display = 'none';
            confetti.innerHTML = '';
        }, 1100);
    }
    document.addEventListener('DOMContentLoaded', function() {
        var btn = document.getElementById('updateAllData');
        if (!btn) return;
        btn.addEventListener('click', function() {
            if (btn.getAttribute('aria-busy') === 'true') return;
            showConfetti(btn);
        });
    });
})();

// Add active state detection for breadcrumb menu
document.addEventListener('DOMContentLoaded', function() {
    var currentPath = window.location.pathname;
    var breadcrumbLinks = document.querySelectorAll('.modern-breadcrumbs .breadcrumb-link');
    
    breadcrumbLinks.forEach(function(link) {
        if (link.getAttribute('href') === currentPath) {
            link.parentElement.classList.add('active');
        }
    });
    
    // Add smooth scrolling for mobile touch
    var breadcrumbContainer = document.querySelector('.modern-breadcrumbs');
    if (breadcrumbContainer) {
        let isScrolling = false;
        
        breadcrumbContainer.addEventListener('touchstart', function() {
            isScrolling = true;
        });
        
        breadcrumbContainer.addEventListener('touchend', function() {
            setTimeout(() => {
                isScrolling = false;
            }, 100);
        });
        
        // Prevent link clicks during scroll on mobile
        breadcrumbLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (isScrolling) {
                    e.preventDefault();
                }
            });
        });
    }
});
</script>


