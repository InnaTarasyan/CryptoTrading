<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Dashboard
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item ">
                    <a href="/" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Live Coin Watch
                        </span>
                    </a>
                </li>
                <li class="m-nav__item">
                    <a href="/coingeckomarketsindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                           Coingecko
                        </span>
                    </a>
                </li>
                <li class="m-nav__item">
                    <a href="/coinmarketcalindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                           Coin market Cal
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <button type="button" id="updateAllData" class="modern-update-btn" aria-live="polite" aria-busy="false">
                <span class="btn-icon" id="updateAllDataSpinner" style="display:none;">
                    <svg width="20" height="20" viewBox="0 0 50 50" class="spinner" aria-hidden="true"><circle cx="25" cy="25" r="20" fill="none" stroke="#fff" stroke-width="5" stroke-linecap="round" stroke-dasharray="31.415, 31.415" transform="rotate(0 25 25)"><animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/></circle></svg>
                </span>
                <span id="updateAllDataText">Update All Data</span>
            </button>
        </div>
    </div>
</div>
<!-- END: Subheader -->
