@extends('layouts.base')
@section('styles')
    <link href="{{url('css/coindetails.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="m-content">
        <!-- Modern Coin Info Summary Card -->
        <div id="coinInfoSummary" class="coin-info-summary fade-in-up" style="display:none;">
            <img class="coin-logo" id="coinLogo" src="" alt="Coin Logo" loading="lazy">
            <div class="coin-meta">
                <div class="coin-title" id="coinTitle"></div>
                <span class="coin-symbol" id="coinSymbol"></span>
                <div class="coin-desc" id="coinDesc"></div>
                <div class="coin-links" id="coinLinks"></div>
            </div>
            <div class="coin-meta-stats">
                <div><strong>Price:</strong> <span id="coinPrice"></span></div>
                <div><strong>Market Cap:</strong> <span id="coinMarketCap"></span></div>
                <div><strong>Rank:</strong> <span id="coinRank"></span></div>
                <div><strong>Supply:</strong> <span id="coinSupply"></span></div>
            </div>
        </div>
        <div id="coinInfoLoading" style="text-align:center; margin:2em 0;">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation:spin 1s linear infinite;"><circle cx="24" cy="24" r="20" stroke="#ff6a88" stroke-width="4" stroke-linecap="round" stroke-dasharray="31.4 31.4"/><style>@keyframes spin{100%{transform:rotate(360deg)}}</style></svg>
        </div>
        <div id="coinInfoError" style="display:none; color:#ff6a88; text-align:center; font-weight:600; margin:2em 0;"></div>
    </div>



    <!--begin::Portlet-->
    <div class="m-portlet" id="m_portlet_calendar" style="padding: 3em 3em 1.5em 3em;">
        <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_1">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-map-location"></i>
                </span>
                        <h3 class="m-portlet__head-text">
                            Coin Events
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="" data-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon" title="" data-original-title="Collapse">
                                <i class="la la-angle-down"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
            </div>
        </div>
    </div>
    <!--end::Portlet-->



    <div class="row" style="padding: 3em 3em 1.5em 3em;">
        <div class="col-xl-5 col-lg-5 trading_view_chart_section" >
            {{--@if(!isset($tradingPair))--}}
            {{--<div style="padding-top: 10px; padding-bottom: 10px;">--}}
            {{--Please add a Trading Pair <a href="/tradingPairs">Here</a>:--}}
            {{--</div>--}}
            {{--@else--}}
            @php
                // TradingView symbol mapping (expand as needed)
               $tvSymbols = [
                  'btc' => 'BINANCE:BTCUSDT',
                  'eth' => 'BINANCE:ETHUSDT',
                  'bnb' => 'BINANCE:BNBUSDT',
                  'sol' => 'BINANCE:SOLUSDT',
                  'ada' => 'BINANCE:ADAUSDT',
                  'xrp' => 'BINANCE:XRPUSDT',
                  'doge' => 'BINANCE:DOGEUSDT',
                  'ton' => 'BINANCE:TONUSDT',
                  'avax' => 'BINANCE:AVAXUSDT',
                  'shib' => 'BINANCE:SHIBUSDT',
                  'dot' => 'BINANCE:DOTUSDT',
                  'trx' => 'BINANCE:TRXUSDT',
                  'link' => 'BINANCE:LINKUSDT',
                  'matic' => 'BINANCE:MATICUSDT',
                  'bch' => 'BINANCE:BCHUSDT',
                  'ltc' => 'BINANCE:LTCUSDT',
                  'uni' => 'BINANCE:UNIUSDT',
                  'atom' => 'BINANCE:ATOMUSDT',
                  'etc' => 'BINANCE:ETCUSDT',
                  'fil' => 'BINANCE:FILUSDT',
                  'icp' => 'BINANCE:ICPUSDT',
                  'near' => 'BINANCE:NEARUSDT',
                  'apt' => 'BINANCE:APTUSDT',
                  'hbar' => 'BINANCE:HBARUSDT',
                  'op' => 'BINANCE:OPUSDT',
                  'arb' => 'BINANCE:ARBUSDT',
                  'stx' => 'BINANCE:STXUSDT',
                  'egld' => 'BINANCE:EGLDUSDT',
                  'ftm' => 'BINANCE:FTMUSDT',
                  'sand' => 'BINANCE:SANDUSDT',
                  'rune' => 'BINANCE:RUNEUSDT',
                  'grt' => 'BINANCE:GRTUSDT',
                  'flow' => 'BINANCE:FLOWUSDT',
                  'qnt' => 'BINANCE:QNTUSDT',
                  'gala' => 'BINANCE:GALAUSDT',
                  'chz' => 'BINANCE:CHZUSDT',
                  'mana' => 'BINANCE:MANAUSDT',
                  'enj' => 'BINANCE:ENJUSDT',
                  'aave' => 'BINANCE:AAVEUSDT',
                  'crv' => 'BINANCE:CRVUSDT',
                  'snx' => 'BINANCE:SNXUSDT',
                  '1inch' => 'BINANCE:1INCHUSDT',
                  'lrc' => 'BINANCE:LRCUSDT',
                  'bat' => 'BINANCE:BATUSDT',
                  'zrx' => 'BINANCE:ZRXUSDT',
                  'comp' => 'BINANCE:COMPUSDT',
                  'sushi' => 'BINANCE:SUSHIUSDT',
                  'yfi' => 'BINANCE:YFIUSDT',
                  'bal' => 'BINANCE:BALUSDT',
                  'mkr' => 'BINANCE:MKRUSDT',
                  'dydx' => 'BINANCE:DYDXUSDT',
                  'cfx' => 'BINANCE:CFXUSDT',
                  'luna' => 'BINANCE:LUNAUSDT',
                  'zec' => 'BINANCE:ZECUSDT',
                  'dash' => 'BINANCE:DASHUSDT',
                  'xmr' => 'BINANCE:XMRUSDT',
                  'xlm' => 'BINANCE:XLMUSDT',
                  'algo' => 'BINANCE:ALGOUSDT',
                  'vet' => 'BINANCE:VETUSDT',
                  'icx' => 'BINANCE:ICXUSDT',
                  'ont' => 'BINANCE:ONTUSDT',
                  'qtum' => 'BINANCE:QTUMUSDT',
                  'iota' => 'BINANCE:IOTAUSDT',
                  'waves' => 'BINANCE:WAVESUSDT',
                  'dgb' => 'BINANCE:DGBUSDT',
                  'nano' => 'BINANCE:NANOUSDT',
                  'sc' => 'BINANCE:SCUSDT',
                  'storj' => 'BINANCE:STORJUSDT',
                  'cvc' => 'BINANCE:CVCUSDT',
                  'sxp' => 'BINANCE:SXPUSDT',
                  'bnt' => 'BINANCE:BNTUSDT',
                  'ocean' => 'BINANCE:OCEANUSDT',
                  'ankr' => 'BINANCE:ANKRUSDT',
                  'fet' => 'BINANCE:FETUSDT',
                  'rose' => 'BINANCE:ROSEUSDT',
                  'kava' => 'BINANCE:KAVAUSDT',
                  'rsr' => 'BINANCE:RSRUSDT',
                  'celr' => 'BINANCE:CELRUSDT',
                  'ctsi' => 'BINANCE:CTSIUSDT',
                  'dodo' => 'BINANCE:DODOUSDT',
                  'reef' => 'BINANCE:REEFUSDT',
                  'ava' => 'BINANCE:AVAUSDT',
                  'srm' => 'BINANCE:SRMUSDT',
                  'perp' => 'BINANCE:PERPUSDT',
                  'inj' => 'BINANCE:INJUSDT',
                  'flm' => 'BINANCE:FLMUSDT',
                  'hnt' => 'BINANCE:HNTUSDT',
                  'stmx' => 'BINANCE:STMXUSDT',
                  'doge' => 'BINANCE:DOGEUSDT',
                  'usdc' => 'BINANCE:USDCUSDT',
                  'usdt' => 'BINANCE:USDTUSDT',
                  // Add more as needed
                ];
                $tvSymbol = $tvSymbols[strtolower($coin->id ?? '')] ?? ($coin->code ?? 'BINANCE:BTCUSDT');
                $tvChartUrl = 'https://www.tradingview.com/symbols/' . (str_contains($tvSymbol, ':') ? explode(':', $tvSymbol)[1] : $tvSymbol) . '/';
            @endphp
            <div class="coin-chart-card" style="margin-bottom:2em;">
                <div class="modern-title-bar" style="margin-bottom:1.2em; display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:1em;">
                        <img src="{{ $coin->logo }}" alt="{{ $coin->name }} Logo" style="width:38px; height:38px; border-radius:50%; background:#fff; box-shadow:0 2px 8px rgba(67,206,162,0.10);">
                        <div>
                            <div class="modern-title-text" style="font-size:1.3em; font-weight:700; color:#43cea2;">TradingView Chart</div>
                            <div style="font-size:1em; color:#888;">Live Price Chart for {{ $coin->name }} ({{ strtoupper($coin->symbol) }})</div>
                        </div>
                    </div>
                    <div style="display:flex; gap:0.7em;">
                        <button id="tvFullscreenBtn" class="modern-fullscreen-btn" style="background:linear-gradient(90deg,#43cea2 0%,#ffd200 100%); color:#fff; border:none; border-radius:2em; padding:0.5em 1.2em; font-size:1em; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:0.5em;">
                            <svg width="20" height="20" fill="none" viewBox="0 0 20 20"><rect x="2" y="2" width="16" height="16" rx="3" stroke="#fff" stroke-width="2"/><path d="M6 6h2v2M14 14h-2v-2" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                            Fullscreen
                        </button>
                        <a href="{{ $tvChartUrl }}" target="_blank" rel="noopener" class="modern-fullscreen-btn" style="background:linear-gradient(90deg,#ffd200 0%,#43cea2 100%); color:#fff; border:none; border-radius:2em; padding:0.5em 1.2em; font-size:1em; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:0.5em; text-decoration:none;">
                            <svg width="20" height="20" fill="none" viewBox="0 0 20 20"><path d="M4 10h12M10 4v12" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                            On TradingView
                        </a>
                    </div>
                </div>
                {{--<div class="tradingview-widget-container" style="min-height:350px; height:95vw; max-height:520px; width:100%; border-radius:1.2em; overflow:hidden; background:#f7faff; box-shadow:0 2px 12px rgba(67,206,162,0.08);">--}}
                    <div id="tradingview_chart"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                    <script type="text/javascript">
                        function resizeTVChart() {
                            var el = document.getElementById('tradingview_chart');
                            if (el) {
                                el.style.height = (window.innerWidth < 700 ? '600px' : '500px');
                            }

                            var el2 = document.getElementById('tv-mini-chart');
                            if (el2) {
                                el2.style.height = (window.innerWidth < 700 ? '600px' : '500px');
                            }

                            var el3 = document.getElementById('tv-ta-chart');
                            if (el3) {
                                el3.style.height = (window.innerWidth < 700 ? '600px' : '500px');
                            }

                            var el4 = document.getElementById('tv-volume-chart');
                            if (el4) {
                                el4.style.height = (window.innerWidth < 700 ? '600px' : '500px');
                            }
                        }
                        new TradingView.widget({
                            "width": '100%',
                            "height": '100%',
                            "symbol": "{{ $tvSymbol }}",
                            "interval": "D",
                            "autosize": true,
                            "timezone": "Etc/UTC",
                            "theme": "Light",
                            "style": "1",
                            "locale": "en",
                            "toolbar_bg": "#f1f3f6",
                            "enable_publishing": false,
                            "allow_symbol_change": true,
                            "container_id": "tradingview_chart"
                        });
                        window.addEventListener('resize', resizeTVChart);
                        setTimeout(resizeTVChart, 500);
                        document.getElementById('tvFullscreenBtn').onclick = function() {
                            var el = document.getElementById('tradingview_chart');
                            if (el.requestFullscreen) el.requestFullscreen();
                            else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
                            else if (el.msRequestFullscreen) el.msRequestFullscreen();
                        };
                    </script>
                {{--</div>--}}
                <div class="coin-chart-stats" style="display:flex; flex-wrap:wrap; gap:2em; margin-top:1.2em; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.95); border-radius:1em; box-shadow:0 2px 8px rgba(67,206,162,0.06); padding:1.2em 1.5em;">
                    <div><b>Current Price:</b> ${{ number_format($coin->price_usd, 2) }}</div>
                    <div><b>24h Change:</b> <span class="coin-price-change {{ $coin->change_24h > 0 ? 'up' : 'down' }}">{{ $coin->change_24h > 0 ? '+' : '' }}{{ number_format($coin->change_24h, 2) }}%</span></div>
                    <div><b>24h High:</b> ${{ number_format($coin->high_24h ?? 0, 2) }}</div>
                    <div><b>24h Low:</b> ${{ number_format($coin->low_24h ?? 0, 2) }}</div>
                    <div><b>24h Volume:</b> ${{ number_format($coin->volume_24h) }}</div>
                    <div><b>Market Cap:</b> ${{ number_format($coin->market_cap) }}</div>
                </div>
            </div>
            {{--@endif--}}
        </div>


        <div class="col-xl-7 col-lg-7 trading_view_chart_section" >
            <div class="modern-title-bar" style="margin-bottom:1.2em; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:1em;">
                    <img src="{{ $coin->logo }}" alt="{{ $coin->name }} Logo" style="width:38px; height:38px; border-radius:50%; background:#fff; box-shadow:0 2px 8px rgba(67,206,162,0.10);">
                    <div>
                        <div class="modern-title-text" style="font-size:1.3em; font-weight:700; color:#43cea2;">Mini Price Chart</div>
                    </div>
                </div>
                <div style="display:flex; gap:0.7em;">
                    <button id="tvFullscreenBtn2" class="modern-fullscreen-btn" style="background:linear-gradient(90deg,#43cea2 0%,#ffd200 100%); color:#fff; border:none; border-radius:2em; padding:0.5em 1.2em; font-size:1em; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:0.5em;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 20 20"><rect x="2" y="2" width="16" height="16" rx="3" stroke="#fff" stroke-width="2"/><path d="M6 6h2v2M14 14h-2v-2" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                        Fullscreen
                    </button>
                </div>
            </div>

            {{--<div class="tradingview-widget-container" style="min-height:350px; height:45vw; max-height:520px; width:100%; border-radius:1.2em; overflow:hidden; background:#f7faff; box-shadow:0 2px 12px rgba(67,206,162,0.08);">--}}
                <div id="tv-mini-chart"></div>
                <script type="text/javascript">
                    new TradingView.widget({
                        symbol: "{{ $tvSymbol }}",
                        width: "100%",
                        height:  "100%",
                        locale: "en",
                        dateRange: "1M",
                        colorTheme: "light",
                        trendLineColor: "#43cea2",
                        underLineColor: "#e3f7f3",
                        isTransparent: false,
                        autosize: true,
                        container_id: "tv-mini-chart"
                    });
                    document.getElementById('tvFullscreenBtn2').onclick = function() {
                        var el = document.getElementById('tv-mini-chart');
                        if (el.requestFullscreen) el.requestFullscreen();
                        else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
                        else if (el.msRequestFullscreen) el.msRequestFullscreen();
                    };
                </script>
            {{--</div>--}}
        </div>
    </div>

    <div class="row" style="padding: 3em 3em 1.5em 3em;">
        <div class="col-xl-6 col-lg-6 trading_view_chart_section" >
            <div class="modern-title-bar" style="margin-bottom:1.2em; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:1em;">
                    <img src="{{ $coin->logo }}" alt="{{ $coin->name }} Logo" style="width:38px; height:38px; border-radius:50%; background:#fff; box-shadow:0 2px 8px rgba(67,206,162,0.10);">
                    <div>
                        <div class="modern-title-text" style="font-size:1.3em; font-weight:700; color:#43cea2;">Technical Analysis</div>
                    </div>
                </div>
                <div style="display:flex; gap:0.7em;">
                    <button id="tvFullscreenBtn3" class="modern-fullscreen-btn" style="background:linear-gradient(90deg,#43cea2 0%,#ffd200 100%); color:#fff; border:none; border-radius:2em; padding:0.5em 1.2em; font-size:1em; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:0.5em;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 20 20"><rect x="2" y="2" width="16" height="16" rx="3" stroke="#fff" stroke-width="2"/><path d="M6 6h2v2M14 14h-2v-2" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                        Fullscreen
                    </button>
                </div>
            </div>

            {{--<div class="tradingview-widget-container" style="min-height:450px; height:45vw; max-height:620px; width:100%; border-radius:1.2em; overflow:hidden; background:#f7faff; box-shadow:0 2px 12px rgba(67,206,162,0.08);">--}}
                <div id="tv-ta-chart"></div>
                <script type="text/javascript">
                    new TradingView.widget({
                        autosize: true,
                        width: "100%",
                        height:  "100%",
                        symbol: "{{ $tvSymbol }}",
                        interval: "1D",
                        timezone: "Etc/UTC",
                        theme: "light",
                        style: "2",
                        locale: "en",
                        toolbar_bg: "#f1f3f6",
                        enable_publishing: false,
                        allow_symbol_change: true,
                        hide_top_toolbar: true,
                        save_image: false,
                        studies: ["MACD@tv-basicstudies", "RSI@tv-basicstudies"],
                        container_id: "tv-ta-chart"
                    });
                    document.getElementById('tvFullscreenBtn3').onclick = function() {
                        var el = document.getElementById('tv-ta-chart');
                        if (el.requestFullscreen) el.requestFullscreen();
                        else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
                        else if (el.msRequestFullscreen) el.msRequestFullscreen();
                    };
                </script>
            {{--</div>--}}
        </div>

        <div class="col-xl-6 col-lg-6 trading_view_chart_section" >
            <div class="modern-title-bar" style="margin-bottom:1.2em; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:1em;">
                    <img src="{{ $coin->logo }}" alt="{{ $coin->name }} Logo" style="width:38px; height:38px; border-radius:50%; background:#fff; box-shadow:0 2px 8px rgba(67,206,162,0.10);">
                    <div>
                        <div class="modern-title-text" style="font-size:1.3em; font-weight:700; color:#43cea2;">Market Cap & Volume</div>
                    </div>
                </div>
                <div style="display:flex; gap:0.7em;">
                    <button id="tvFullscreenBtn4" class="modern-fullscreen-btn" style="background:linear-gradient(90deg,#43cea2 0%,#ffd200 100%); color:#fff; border:none; border-radius:2em; padding:0.5em 1.2em; font-size:1em; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:0.5em;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 20 20"><rect x="2" y="2" width="16" height="16" rx="3" stroke="#fff" stroke-width="2"/><path d="M6 6h2v2M14 14h-2v-2" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                        Fullscreen
                    </button>
                </div>
            </div>

            {{--<div class="tradingview-widget-container" style="min-height:450px; height:45vw; max-height:620px; width:100%; border-radius:1.2em; overflow:hidden; background:#f7faff; box-shadow:0 2px 12px rgba(67,206,162,0.08);">--}}
                <div id="tv-volume-chart"></div>
                <script type="text/javascript">
                    new TradingView.widget({
                        autosize: true,
                        width: "100%",
                        height:  "100%",
                        symbol: "{{ $tvSymbol }}",
                        interval: "1D",
                        timezone: "Etc/UTC",
                        theme: "light",
                        style: "3",
                        locale: "en",
                        toolbar_bg: "#f1f3f6",
                        enable_publishing: false,
                        allow_symbol_change: true,
                        hide_top_toolbar: true,
                        save_image: false,
                        studies: ["Volume@tv-basicstudies"],
                        container_id: "tv-volume-chart"
                    });
                    document.getElementById('tvFullscreenBtn4').onclick = function() {
                        var el = document.getElementById('tv-volume-chart');
                        if (el.requestFullscreen) el.requestFullscreen();
                        else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
                        else if (el.msRequestFullscreen) el.msRequestFullscreen();
                    };
                </script>
            {{--</div>--}}
        </div>
    </div>

    
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>

    <!--Begin::Portlet-->
    <div class="m-portlet " style="padding: 3em 3em 1.5em 3em;">
        <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_2">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="socicon-telegram"></i>
                                </span>
                        <h3 class="m-portlet__head-text">
                            Telegram Channel
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="" data-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon" title="" data-original-title="Collapse">
                                <i class="la la-angle-down"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                @if(isset($tweets))
                    <div class="m-scrollable mCustomScrollbar _mCS_5 mCS-autoHide" data-scrollbar-shown="true" data-scrollable="true" data-max-height="600" style="overflow: visible; height: 380px; max-height: 380px; position: relative;">
                        <!--Begin::Timeline 2 -->
                        <div class="m-timeline-2">
                            @foreach($tweets as $tweet)
                                <div class="m-timeline-2__items  m--padding-top-25 m--padding-bottom-30">
                                    <div class="m-timeline-2__item">
                                                <span class="m-timeline-2__item-time">
                                                    {{\Carbon\Carbon::parse($tweet['created_at'])->format('y, M, d, H:i:s')}}
                                                </span>
                                        <div class="m-timeline-2__item-cricle">
                                            <i class="fa fa-genderless m--font-danger"></i>
                                        </div>
                                        <div class="m-timeline-2__item-text  m--padding-top-5">
                                            {!! $tweet['content'] !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--End::Timeline 2 -->
                    </div>
                @else
                    <i>Twitter Account</i> has not been added.
                    Please configure it <a href="{{ url('twitter') }}">here...</a>
                @endif
            </div>
        </div>
    </div>
    <!--end::Portlet-->


@endsection
@section('scripts')
    <script>
        // --- Modern Coin Info Fetcher (CoinGecko) ---
        // Set your coin id here, or fetch dynamically from backend/route/JS variable
        const coinId = '{{ $name ?? "monero" }}'; // fallback to monero for demo
        console.log(coinId);

        let apiUrl = `https://api.coingecko.com/api/v3/coins/${coinId}?localization=false&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false`;

        function formatNumber(n) {
            if (!n && n !== 0) return '-';
            return n.toLocaleString('en-US', {maximumFractionDigits: 2});
        }
        function formatCurrency(n) {
            if (!n && n !== 0) return '-';
            return '$' + n.toLocaleString('en-US', {maximumFractionDigits: 6});
        }
        function escapeHTML(str) {
            var div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }
        function stripTags(str) {
            return str.replace(/<[^>]*>?/gm, '');
        }

        fetch(apiUrl)
            .then(r => r.json())
        .then(data => {
            document.getElementById('coinLogo').src = data.image.large || data.image.small || '';
        document.getElementById('coinLogo').alt = data.name + ' logo';
        document.getElementById('coinTitle').textContent = data.name;
        document.getElementById('coinSymbol').textContent = data.symbol ? data.symbol.toUpperCase() : '';
        document.getElementById('coinDesc').innerHTML = data.description.en ? data.description.en.split('. ').slice(0,2).join('. ') + '.' : '';
        document.getElementById('coinPrice').textContent = formatCurrency(data.market_data.current_price.usd);
        document.getElementById('coinMarketCap').textContent = formatCurrency(data.market_data.market_cap.usd);
        document.getElementById('coinRank').textContent = data.market_cap_rank ? '#' + data.market_cap_rank : '-';
        document.getElementById('coinSupply').textContent = formatNumber(data.market_data.circulating_supply) + (data.market_data.max_supply ? ' / ' + formatNumber(data.market_data.max_supply) : '');
        // Links
        let links = [];
        if (data.links.homepage && data.links.homepage[0]) links.push(`<a class="coin-link" href="${data.links.homepage[0]}" target="_blank" rel="noopener">Website</a>`);
        if (data.links.blockchain_site && data.links.blockchain_site[0]) links.push(`<a class="coin-link" href="${data.links.blockchain_site[0]}" target="_blank" rel="noopener">Blockchain</a>`);
        if (data.links.repos_url && data.links.repos_url.github && data.links.repos_url.github[0]) links.push(`<a class="coin-link" href="${data.links.repos_url.github[0]}" target="_blank" rel="noopener">GitHub</a>`);
        if (data.links.subreddit_url) links.push(`<a class="coin-link" href="${data.links.subreddit_url}" target="_blank" rel="noopener">Reddit</a>`);
        if (data.links.twitter_screen_name) links.push(`<a class="coin-link" href="https://twitter.com/${data.links.twitter_screen_name}" target="_blank" rel="noopener">Twitter</a>`);
        document.getElementById('coinLinks').innerHTML = links.join(' ');
        document.getElementById('coinInfoSummary').style.display = '';
        document.getElementById('coinInfoLoading').style.display = 'none';
        })
        .catch(e => {

           apiUrl = `https://api.coingecko.com/api/v3/coins/bitcoin?localization=false&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false`;

//            document.getElementById('coinInfoLoading').style.display = 'none';
//        document.getElementById('coinInfoError').style.display = '';
//        document.getElementById('coinInfoError').textContent = 'Failed to load coin data. Please try again later.';


        fetch(apiUrl)
            .then(r => r.json())
        .then(data => {
            document.getElementById('coinLogo').src = data.image.large || data.image.small || '';
        document.getElementById('coinLogo').alt = data.name + ' logo';
        document.getElementById('coinTitle').textContent = data.name;
        document.getElementById('coinSymbol').textContent = data.symbol ? data.symbol.toUpperCase() : '';
        document.getElementById('coinDesc').innerHTML = data.description.en ? data.description.en.split('. ').slice(0,2).join('. ') + '.' : '';
        document.getElementById('coinPrice').textContent = formatCurrency(data.market_data.current_price.usd);
        document.getElementById('coinMarketCap').textContent = formatCurrency(data.market_data.market_cap.usd);
        document.getElementById('coinRank').textContent = data.market_cap_rank ? '#' + data.market_cap_rank : '-';
        document.getElementById('coinSupply').textContent = formatNumber(data.market_data.circulating_supply) + (data.market_data.max_supply ? ' / ' + formatNumber(data.market_data.max_supply) : '');
        // Links
        let links = [];
        if (data.links.homepage && data.links.homepage[0]) links.push(`<a class="coin-link" href="${data.links.homepage[0]}" target="_blank" rel="noopener">Website</a>`);
        if (data.links.blockchain_site && data.links.blockchain_site[0]) links.push(`<a class="coin-link" href="${data.links.blockchain_site[0]}" target="_blank" rel="noopener">Blockchain</a>`);
        if (data.links.repos_url && data.links.repos_url.github && data.links.repos_url.github[0]) links.push(`<a class="coin-link" href="${data.links.repos_url.github[0]}" target="_blank" rel="noopener">GitHub</a>`);
        if (data.links.subreddit_url) links.push(`<a class="coin-link" href="${data.links.subreddit_url}" target="_blank" rel="noopener">Reddit</a>`);
        if (data.links.twitter_screen_name) links.push(`<a class="coin-link" href="https://twitter.com/${data.links.twitter_screen_name}" target="_blank" rel="noopener">Twitter</a>`);
        document.getElementById('coinLinks').innerHTML = links.join(' ');
        document.getElementById('coinInfoSummary').style.display = '';
        document.getElementById('coinInfoLoading').style.display = 'none';
        });


        });
    </script>
    <script>
        var events = {!! $events !!};
    </script>
    <script src="{{ url('js/details.js') }}"></script>
@endsection