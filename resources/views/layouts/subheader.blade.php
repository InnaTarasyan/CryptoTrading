<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator" data-lang-key="dashboard">
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
            <button type="button" id="updateAllData" class="modern-update-btn modern-update-btn-fancy" aria-live="polite" aria-busy="false" style="display:inline-flex;align-items:center;gap:10px;background:linear-gradient(270deg,#ff512f,#f7971e,#ffd200,#43cea2,#185a9d,#6a11cb,#ff512f);background-size:1400% 1400%;animation:gradientFlow 8s ease infinite;color:#fff;font-weight:800;font-size:1.15rem;border:none;border-radius:40px;padding:16px 38px;box-shadow:0 6px 24px 0 rgba(255,81,47,0.18),0 1.5px 8px 0 rgba(67,206,162,0.10);cursor:pointer;transition:box-shadow 0.2s,transform 0.1s;outline:none;position:relative;min-width:200px;letter-spacing:0.7px;text-shadow:0 2px 8px rgba(255,255,255,0.12);overflow:hidden;">
                <span class="confetti" style="pointer-events:none;position:absolute;left:0;top:0;width:100%;height:100%;z-index:2;display:none;"></span>
                <span class="btn-icon" id="updateAllDataSpinner" style="display:none;margin-right:8px;">
                    <svg width="20" height="20" viewBox="0 0 50 50" class="spinner" aria-hidden="true" style="animation:spin 1s linear infinite;"><circle cx="25" cy="25" r="20" fill="none" stroke="#fff" stroke-width="5" stroke-linecap="round" stroke-dasharray="31.415, 31.415" transform="rotate(0 25 25)"><animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/></circle></svg>
                </span>
                <span style="display:inline-flex;align-items:center;gap:8px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" style="vertical-align:middle;"><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" stroke="#fff" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="12" r="5" fill="#ffd200"/></svg>
                    <span id="updateAllDataText" style="font-weight:700;letter-spacing:0.5px;" data-lang-key="update_all_data">Update All Data</span>
                </span>
            </button>
            <style>
                @keyframes gradientFlow {
                    0% {background-position: 0% 50%;}
                    50% {background-position: 100% 50%;}
                    100% {background-position: 0% 50%;}
                }
                .modern-update-btn.modern-update-btn-fancy:focus {
                    box-shadow: 0 0 0 4px #ffd20055, 0 6px 24px 0 rgba(255, 81, 47, 0.18);
                }
                .modern-update-btn.modern-update-btn-fancy:hover:not(:disabled):not([aria-busy="true"]) {
                    box-shadow: 0 8px 32px 0 rgba(221,36,118,0.18), 0 2px 12px 0 rgba(67,206,162,0.12);
                    transform: translateY(-2px) scale(1.05);
                    filter: brightness(1.08);
                }
                .modern-update-btn.modern-update-btn-fancy:active {
                    animation: bounce 0.3s;
                    transform: scale(0.97);
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
                @media (max-width: 600px) {
                    .modern-update-btn.modern-update-btn-fancy {
                        width: 100%;
                        font-size: 1rem;
                        padding: 12px 0;
                        min-width: unset;
                        justify-content: center;
                    }
                }
            </style>
        </div>
    </div>
</div>
<!-- END: Subheader -->
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
</script>
