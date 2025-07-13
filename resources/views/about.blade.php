@extends('layouts.base')
@section('styles')
<style>
    body {
        background: #f4f7fa;
    }
    .about-hero {
        background: linear-gradient(120deg, #e0e7ff 0%, #f8fafc 100%, #c7d2fe 100%);
        padding: 3.5em 0 2.5em 0;
        border-radius: 2em;
        margin-bottom: 2.5em;
        box-shadow: 0 8px 40px rgba(80,80,200,0.10);
        position: relative;
        overflow: hidden;
        animation: gradientBG 8s ease-in-out infinite alternate;
    }
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }
    .about-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        box-shadow: 0 8px 32px rgba(80,80,200,0.18), 0 2px 8px rgba(80,80,200,0.10);
        object-fit: cover;
        border: 5px solid #fff;
        margin-bottom: 1em;
        background: #fff;
        transition: transform 0.2s;
    }
    .about-avatar:hover {
        transform: scale(1.04) rotate(-2deg);
    }
    .about-social {
        margin-bottom: 1.2em;
    }
    .about-social a {
        display: inline-block;
        margin: 0 0.4em;
        color: #6366f1;
        background: #fff;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        line-height: 38px;
        text-align: center;
        font-size: 1.3em;
        box-shadow: 0 2px 8px rgba(80,80,200,0.10);
        transition: background 0.2s, color 0.2s, transform 0.2s;
    }
    .about-social a:hover {
        background: #6366f1;
        color: #fff;
        transform: scale(1.12);
    }
    .about-tagline {
        font-size: 1.25em;
        color: #6366f1;
        font-weight: 600;
        margin-bottom: 1.2em;
        letter-spacing: 0.01em;
        animation: fadeIn 1.2s;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: none; }
    }
    .about-section {
        margin-bottom: 2.5em;
    }
    .about-card, .about-feedback-card, .about-timeline, .about-testimonials, .about-funfacts {
        background: rgba(255,255,255,0.85);
        border-radius: 1.5em;
        box-shadow: 0 4px 32px rgba(80,80,200,0.10);
        padding: 2.2em 1.7em;
        margin-bottom: 2.2em;
        backdrop-filter: blur(8px);
        border: 1.5px solid rgba(99,102,241,0.08);
        transition: box-shadow 0.2s, transform 0.2s;
        animation: fadeIn 1.2s;
    }
    .about-card:hover, .about-feedback-card:hover, .about-timeline:hover, .about-testimonials:hover, .about-funfacts:hover {
        box-shadow: 0 12px 48px rgba(80,80,200,0.16);
        transform: translateY(-2px) scale(1.01);
    }
    .about-section-title {
        font-weight: 800;
        font-size: 1.25em;
        margin-bottom: 1.1em;
        color: #3730a3;
        letter-spacing: 0.01em;
        display: flex;
        align-items: center;
        gap: 0.5em;
    }
    .about-section-title i {
        font-size: 1.1em;
    }
    .about-feature-list li {
        margin-bottom: 0.7em;
        font-size: 1.09em;
        line-height: 1.7;
        display: flex;
        align-items: flex-start;
        gap: 0.5em;
    }
    .about-feature-list i {
        color: #6366f1;
        margin-top: 0.2em;
        min-width: 1.2em;
        text-align: center;
    }
    .about-badge {
        display: inline-block;
        background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
        color: #fff;
        border-radius: 2em;
        padding: 0.35em 1.1em;
        font-size: 1em;
        margin: 0.2em 0.3em 0.2em 0;
        font-weight: 500;
        letter-spacing: 0.03em;
        box-shadow: 0 1px 4px rgba(99,102,241,0.10);
    }
    .about-timeline ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .about-timeline li {
        position: relative;
        padding-left: 2em;
        margin-bottom: 1.2em;
        font-size: 1.08em;
    }
    .about-timeline li:before {
        content: '\2022';
        color: #6366f1;
        font-size: 1.5em;
        position: absolute;
        left: 0;
        top: 0.1em;
    }
    .about-testimonials blockquote {
        font-size: 1.08em;
        color: #444;
        border-left: 4px solid #6366f1;
        margin: 0 0 1.2em 0;
        padding: 0.5em 1em;
        background: rgba(99,102,241,0.06);
        border-radius: 0.7em;
        font-style: italic;
        animation: fadeIn 1.2s;
    }
    .about-testimonials cite {
        display: block;
        font-size: 0.98em;
        color: #6366f1;
        margin-top: 0.2em;
        font-style: normal;
    }
    .about-funfacts ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 1.2em;
        justify-content: center;
    }
    .about-funfacts li {
        background: linear-gradient(90deg, #e0e7ff 0%, #f8fafc 100%);
        border-radius: 1.2em;
        padding: 1em 1.5em;
        font-size: 1.07em;
        color: #3730a3;
        box-shadow: 0 1px 6px rgba(99,102,241,0.07);
        min-width: 180px;
        text-align: center;
        animation: fadeIn 1.2s;
    }
    .about-feedback-card .btn-primary {
        background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
        border: none;
        border-radius: 2em;
        font-weight: 700;
        font-size: 1.1em;
        padding: 0.8em 2.2em;
        transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
        box-shadow: 0 2px 12px rgba(99,102,241,0.10);
    }
    .about-feedback-card .btn-primary:hover {
        background: linear-gradient(90deg, #60a5fa 0%, #6366f1 100%);
        box-shadow: 0 4px 24px rgba(99,102,241,0.18);
        transform: scale(1.04);
    }
    .form-control, .m-input {
        border-radius: 1.5em !important;
        border: 1.5px solid #e0e7ff !important;
        background: rgba(255,255,255,0.95) !important;
        font-size: 1.07em;
        padding: 0.9em 1.2em;
        margin-bottom: 1em;
        box-shadow: 0 1px 4px rgba(99,102,241,0.06);
        transition: border 0.2s, box-shadow 0.2s;
    }
    .form-control:focus, .m-input:focus {
        border: 1.5px solid #6366f1 !important;
        box-shadow: 0 2px 12px rgba(99,102,241,0.10);
        outline: none;
    }
    .input-group-text {
        border-radius: 1.5em 0 0 1.5em !important;
        background: #e0e7ff !important;
        color: #6366f1 !important;
        border: none !important;
        font-size: 1.1em;
    }
    @media (max-width: 767px) {
        .about-hero, .about-card, .about-feedback-card, .about-timeline, .about-testimonials, .about-funfacts {
            padding: 1.2em 0.7em;
        }
        .about-avatar {
            width: 90px;
            height: 90px;
        }
        .about-section-title {
            font-size: 1.1em;
        }
        .about-funfacts ul {
            flex-direction: column;
            gap: 0.7em;
        }
        .about-funfacts li {
            min-width: 0;
        }
    }
</style>
@endsection
@section('content')
<div class="about-hero text-center">
    <img src="{{ asset('img/inna_photo.jpg') }}" alt="Inna Tarasyan" class="about-avatar">
    <div class="about-social">
        <a href="mailto:innatarasyanmail@gmail.com" title="Email"><i class="fa fa-envelope"></i></a>
        <a href="https://t.me/innatarasyan" target="_blank" title="Telegram"><i class="fa fa-telegram"></i></a>
        <a href="https://github.com/innatarasyan" target="_blank" title="GitHub"><i class="fa fa-github"></i></a>
        <a href="https://linkedin.com/in/innatarasyan" target="_blank" title="LinkedIn"><i class="fa fa-linkedin"></i></a>
    </div>
    <h1 style="margin-top: 0.7em; font-weight: 700; color: #3730a3;">Inna Tarasyan</h1>
    <div class="about-tagline">Empowering crypto traders with data-driven insights</div>
    <p style="color: #555; max-width: 500px; margin: 0 auto 1.2em auto;">Web Developer & Crypto Enthusiast. Based in Armenia.<br><a href="mailto:innatarasyanmail@gmail.com" style="color:#6366f1;text-decoration:underline;">innatarasyanmail@gmail.com</a></p>
</div>
<div class="container-fluid" style="max-width: 1100px;">
        <div class="row">
        <div class="col-md-6 about-section">
            <div class="about-card">
                <div class="about-section-title"><i class="fa fa-star"></i> Key Features</div>
                <ul class="about-feature-list">
                    <li><i class="fa fa-chart-line"></i> <b>Comprehensive Market Coverage:</b> Real-time & historical data from top exchanges.</li>
                    <li><i class="fa fa-table"></i> <b>Advanced DataTables:</b> Instant filtering, export, and responsive tables.</li>
                    <li><i class="fa fa-bolt"></i> <b>Real-Time Analytics:</b> Live price updates, OHLCV charts, and liquidity metrics.</li>
                    <li><i class="fa fa-calendar-alt"></i> <b>Event & Sentiment Tracking:</b> Crypto event calendar and social analytics.</li>
                    <li><i class="fa fa-bell"></i> <b>Portfolio & Alerts (Coming Soon):</b> Track coins, set alerts, and monitor performance.</li>
                    <li><i class="fa fa-lock"></i> <b>Security & Privacy:</b> Data is secure and privacy is respected.</li>
                    <li><i class="fa fa-sliders-h"></i> <b>Advanced Order Types:</b> Place limit, trailing stop, take profit, and stop loss orders for flexible trading strategies.</li>
                    <li><i class="fa fa-robot"></i> <b>DCA Bots:</b> Automate your trading with Dollar-Cost Averaging bots for consistent investment.</li>
                    <li><i class="fa fa-bell"></i> <b>Real-Time Notifications:</b> Get instant alerts for price movements, order execution, and important events.</li>
                    <li><i class="fa fa-search"></i> <b>DEX Screener:</b> Analyze decentralized exchange markets and spot new opportunities.</li>
                    <li><i class="fa fa-shield-alt"></i> <b>MEV Protection:</b> Protect your trades from front-running and maximize returns.</li>
                    <li><i class="fa fa-users"></i> <b>Copy Trading (Upcoming):</b> Follow top traders and automatically copy their strategies.</li>
                    <li><i class="fa fa-layer-group"></i> <b>Batch Orders & Transfers:</b> Execute multiple trades or transfers in a single action for efficiency.</li>
                    <li><i class="fa fa-trophy"></i> <b>Trading Rewards & Loyalty:</b> Earn rewards and participate in loyalty programs for active trading.</li>
                    <li><i class="fa fa-mobile-alt"></i> <b>Mobile-Friendly Design:</b> Enjoy a seamless experience on any device, from desktop to mobile.</li>
                    <li><i class="fa fa-th-large"></i> <b>Customizable Dashboards:</b> Personalize your workspace with widgets and layouts that fit your workflow.</li>
                    <li><i class="fa fa-file-export"></i> <b>Export Options:</b> Download your data and reports in multiple formats for further analysis.</li>
                    <li><i class="fa fa-code"></i> <b>API Access:</b> Integrate platform data into your own tools and automate your workflow.</li>
                    <li><i class="fa fa-graduation-cap"></i> <b>Educational Resources:</b> Access guides, tutorials, and tips to improve your trading skills.</li>
                </ul>
                                </div>
                            </div>
        <div class="col-md-6 about-section">
            <div class="about-card">
                <div class="about-section-title"><i class="fa fa-cogs"></i> Technologies</div>
                <div style="margin-bottom:1em;">
                    <span class="about-badge">Laravel</span>
                    <span class="about-badge">Datatables</span>
                    <span class="about-badge">TradingView</span>
                    <span class="about-badge">Metronic</span>
                    <span class="about-badge">Telegram API</span>
                    <span class="about-badge">select2.js</span>
                    <span class="about-badge">AJAX</span>
                    <span class="about-badge">REST APIs</span>
                    <span class="about-badge">Google Maps API</span>
                            </div>
                <div style="font-size:1.04em; color:#444; margin-bottom:1.2em;">
                    <b>What data is shown in our tables?</b><br>
                    The interactive datatables present a rich set of crypto market data, including:
                    <ul style="margin:0.7em 0 0.7em 1.2em;">
                        <li><b>OHLCV:</b> Open, High, Low, Close, and Volume for each asset and timeframe—essential for price analysis and candlestick charts.</li>
                        <li><b>Market Cap:</b> The total value of a cryptocurrency, helping users gauge its size and significance.</li>
                        <li><b>Liquidity & Order Book:</b> Real-time snapshots of buy/sell orders and market depth, useful for understanding trading activity and slippage.</li>
                        <li><b>Trade History:</b> Detailed records of recent trades, including price, amount, and time, for transparency and pattern spotting.</li>
                        <li><b>Price Change & Performance:</b> Percentage changes over various periods (1h, 24h, 7d, etc.), helping users spot trends and volatility.</li>
                        <li><b>Volume & Turnover:</b> Total traded volume, a key indicator of market activity and interest.</li>
                        <li><b>Social & Sentiment Data:</b> Metrics from platforms like Telegram and Twitter to gauge community sentiment and news impact.</li>
                    </ul>
                    This comprehensive data empowers traders and analysts to perform technical analysis, backtest strategies, monitor trends, and make informed decisions in the fast-moving crypto market.
                    <div style="margin-top:1.2em;">
                        <b>Data Sources Integrated:</b><br>
                        <ul style="margin:0.7em 0 0.7em 1.2em;">
                            <li><b>LiveCoinWatch:</b> Provides real-time and historical price data, market capitalization, volume, and liquidity metrics for thousands of cryptocurrencies across multiple exchanges. Its API enables up-to-the-second updates and deep market analytics.</li>
                            <li><b>CoinGecko:</b> Offers comprehensive crypto data including prices, trading volume, developer activity, community stats, and on-chain metrics. CoinGecko is known for its wide coverage of coins and tokens, as well as detailed project information and rankings.</li>
                            <li><b>CoinMarketCal:</b> The leading economic calendar for crypto, aggregating upcoming events, project announcements, forks, exchange listings, and more. This helps users anticipate market-moving news and plan their trading strategies accordingly.</li>
                        </ul>
                        By integrating these trusted sources, the platform ensures users have access to the most accurate, timely, and actionable information in the crypto space.
                    </div>
                </div>
                <ul class="about-feature-list">
                    <li><b>Laravel (PHP):</b> Secure, scalable backend</li>
                    <li><b>TradingView JS API:</b> Real-time charting</li>
                    <li><b>Metronic Theme:</b> Modern, responsive UI/UX</li>
                    <li><b>Telegram API:</b> Social sentiment insights</li>
                    <li><b>select2.js:</b> Fast, intuitive search</li>
                </ul>
            </div>
                            </div>
                        </div>
    <div class="row">
        <div class="col-md-6 about-section">
            <div class="about-card">
                <div class="about-section-title"><i class="fa fa-users"></i> Why This Matters for You</div>
                <ul class="about-feature-list">
                    <li><b>For Traders:</b> Make informed decisions with up-to-the-second data, advanced analytics, and event tracking.</li>
                    <li><b>For Analysts:</b> Export and analyze large datasets, backtest strategies, and monitor market trends.</li>
                    <li><b>For Learners:</b> Explore a real-world example of a modern, full-stack web application using the latest technologies in crypto and web development.</li>
                                </ul>
                            </div>
                            </div>
        <div class="col-md-6 about-section">
            <div class="about-card">
                <div class="about-section-title"><i class="fa fa-shield-alt"></i> Reliability & Security</div>
                <ul class="about-feature-list">
                    <li><b>Low Latency:</b> Data is updated in real time, with minimal delay.</li>
                    <li><b>Scalability:</b> Built to handle thousands of users and millions of data points.</li>
                    <li><b>Data Integrity:</b> Aggregated and standardized data ensures accuracy and consistency.</li>
                    <li><b>GDPR & Data Privacy:</b> User privacy is a top priority; no sensitive data is shared.</li>
                </ul>
                            </div>
                            </div>
                            </div>
    <!-- Timeline / Milestones Section -->
    <div class="row">
        <div class="col-12 about-section">
            <div class="about-timeline">
                <div class="about-section-title"><i class="fa fa-trophy"></i> Milestones</div>
                <ul>
                    <li><b>2022:</b> Launched CryptoTrading platform</li>
                    <li><b>2023:</b> Integrated CoinGecko & LiveCoinWatch APIs</li>
                    <li><b>2024:</b> Reached 10,000+ users and added CoinMarketCal integration</li>
                                </ul>
                                </div>
                            </div>
                        </div>
    <!-- Testimonials Section -->
    <div class="row">
        <div class="col-12 about-section">
            <div class="about-testimonials">
                <div class="about-section-title"><i class="fa fa-comment"></i> What Users Say</div>
                <blockquote>“The best crypto dashboard I’ve used!”<cite>— Crypto Analyst</cite></blockquote>
                <blockquote>“Superb real-time data and easy to use.”<cite>— Trader</cite></blockquote>
                <blockquote>“Love the event calendar and portfolio tracking features.”<cite>— Community Member</cite></blockquote>
            </div>
                    </div>
                </div>
    <!-- Fun Facts / Behind the Scenes Section -->
    <div class="row">
        <div class="col-12 about-section">
            <div class="about-funfacts">
                <div class="about-section-title"><i class="fa fa-lightbulb"></i> Fun Facts & Behind the Scenes</div>
                <ul>
                    <li><span role="img" aria-label="coffee">☕</span> Code powered by Armenian coffee</li>
                    <li><span role="img" aria-label="rocket">🚀</span> Over 1 million API calls served</li>
                    <li><span role="img" aria-label="books">📚</span> Always learning new web tech</li>
                    <li><span role="img" aria-label="chart">📈</span> Favorite chart: candlesticks!</li>
                    <li><span role="img" aria-label="cat">🐱</span> Cat occasionally walks on the keyboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Note from Inna -->
        <div class="row">
        <div class="col-12 about-section">
            <div class="about-card" style="background: linear-gradient(120deg, #f8fafc 0%, #e0e7ff 100%);">
                <div class="about-section-title"><i class="fa fa-quote-left"></i> A Note from Inna</div>
                <p style="font-size:1.08em; color:#444;">I created this project to help both new and experienced crypto traders navigate the fast-paced world of digital assets. I hope you find it useful, insightful, and easy to use. Your feedback is always welcome—please use the form below to share your thoughts or suggestions!</p>
                <div style="font-size:0.98em; color:#888; margin-top:1em;"><em>Disclaimer: This site is for informational purposes only and does not provide financial advice. Please do your own research before making investment decisions.</em></div>
            </div>
                            </div>
                        </div>
    <!-- Feedback Section -->
    <div class="row">
        <div class="col-12 about-section">
            <div class="about-feedback-card">
                <div class="about-section-title"><i class="fa fa-comment-dots"></i> Feedback</div>
                <p class="mb-4">Have suggestions or want to say hi? I'd love to hear from you!</p>
                        <div class="m-section__content" id="contactUs">
                            <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                                @if(session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action={{route('about','#contactUs')}} method="post">
                                    {{csrf_field()}}
                                    <div class="m-demo__preview">
                                        <div class="form-group m-form__group">
                                    <input  class="form-control m-input m-input--square"  name="name" placeholder="Your Name">
                                        </div>
                                        <div class="form-group m-form__group">
                                            <div class="input-group m-input-group">
                                                <div class="input-group-prepend">
                                            <span class="input-group-text">@</span>
                                        </div>
                                        <input type="text" class="form-control m-input" placeholder="Your Email" name="email">
                                    </div>
                                </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-12">
                                        <textarea name="text" class="form-control" data-provide="markdown" rows="7" placeholder="Your Message"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Feedback</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function myMap() {
            var myCenter = new google.maps.LatLng(40.182344, 44.513337);
            var mapCanvas = document.getElementById("map");
            var mapOptions = {center: myCenter, zoom: 5};
            var map = new google.maps.Map(mapCanvas, mapOptions);
            var marker = new google.maps.Marker({position:myCenter});
            marker.setMap(map);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$key}}&callback=myMap"></script>
@endsection