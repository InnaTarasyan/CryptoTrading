@extends('layouts.base')
@section('styles')
    <link href="{{ url('css/about.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="about-hero text-center">
    <img src="{{ asset('img/inna_photo.jpg') }}" alt="Inna Tarasyan" class="about-avatar">
    <div class="about-social">
        <a href="mailto:innatarasyanmail@gmail.com" title="Email"><i class="fa fa-envelope"></i></a>
        <a href="https://t.me/innatarasyan" target="_blank" title="Telegram"><i class="fa fa-telegram"></i></a>
        <a href="https://github.com/innatarasyan" target="_blank" title="GitHub"><i class="fa fa-github"></i></a>
    </div>
    <h1 style="margin-top: 0.7em; font-weight: 700; color: #3730a3;">Inna Tarasyan</h1>
    <p class="lead" style="color: #6366f1; font-size: 1.2em;">Web Developer & Crypto Enthusiast</p>
    <p style="color: #555; max-width: 500px; margin: 0 auto 1.2em auto;">Hello! I'm a passionate web developer from Armenia, dedicated to creating tools that make crypto trading more accessible and informed. I believe in the power of real-time data and user-friendly interfaces to help traders make better decisions.</p>
</div>
<div class="container-fluid" style="max-width: 1100px;">
    <div class="row">
        <div class="col-md-6">
            <div class="about-card">
                <div class="about-section-title"><i class="fa fa-star"></i> Key Features</div>
                <ul class="about-feature-list">
                    <li><i class="fa fa-chart-line"></i> <b>Comprehensive Market Coverage:</b> Real-time & historical data from top exchanges with 24/7 monitoring.</li>
                    <li><i class="fa fa-table"></i> <b>Advanced DataTables:</b> Instant filtering, sorting, export to CSV/Excel, and responsive tables with pagination.</li>
                    <li><i class="fa fa-bolt"></i> <b>Real-Time Analytics:</b> Live price updates, OHLCV charts, liquidity metrics, and market depth analysis.</li>
                    <li><i class="fa fa-calendar-alt"></i> <b>Event & Sentiment Tracking:</b> Crypto event calendar, social media sentiment analysis, and news impact monitoring.</li>
                    <li><i class="fa fa-chart-bar"></i> <b>Advanced Charting:</b> Interactive TradingView charts with multiple timeframes, technical indicators, and drawing tools.</li>
                    <li><i class="fa fa-search"></i> <b>Smart Search & Filters:</b> Find coins by name, symbol, market cap, or custom criteria with instant results.</li>
                    <li><i class="fa fa-bell"></i> <b>Portfolio & Alerts (Coming Soon):</b> Track your favorite coins, set price alerts, and monitor portfolio performance.</li>
                    <li><i class="fa fa-mobile-alt"></i> <b>Mobile-First Design:</b> Fully responsive interface that works perfectly on desktop, tablet, and mobile devices.</li>
                    <li><i class="fa fa-download"></i> <b>Data Export:</b> Download market data, charts, and reports in multiple formats for offline analysis.</li>
                    <li><i class="fa fa-code"></i> <b>API Integration:</b> RESTful APIs for developers to integrate crypto data into their own applications.</li>
                    <li><i class="fa fa-users"></i> <b>Social Features:</b> Share insights, track community sentiment, and discover trending coins.</li>
                    <li><i class="fa fa-shield-alt"></i> <b>Security & Privacy:</b> Data is secure, privacy is respected, and no sensitive information is stored.</li>
                    <li><i class="fa fa-sync"></i> <b>Auto-Refresh:</b> Data updates automatically every 3 hours, with manual refresh options for real-time accuracy.</li>
                    <li><i class="fa fa-lightbulb"></i> <b>Educational Resources:</b> Built-in tutorials, tooltips, and explanations for crypto trading concepts.</li>
                    <li><i class="fa fa-globe"></i> <b>Multi-Language Support:</b> Interface available in multiple languages for global accessibility.</li>
                    <li><i class="fa fa-cog"></i> <b>Customizable Dashboard:</b> Personalize your view with customizable widgets and layouts.</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
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
        <div class="col-md-6">
            <div class="about-card">
                <div class="about-section-title"><i class="fa fa-users"></i> Why This Matters for You</div>
                <ul class="about-feature-list">
                    <li><b>For Traders:</b> Make informed decisions with up-to-the-second data, advanced analytics, and event tracking.</li>
                    <li><b>For Analysts:</b> Export and analyze large datasets, backtest strategies, and monitor market trends.</li>
                    <li><b>For Learners:</b> Explore a real-world example of a modern, full-stack web application using the latest technologies in crypto and web development.</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
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
    <div class="row">
        <div class="col-12">
            <div class="about-card" style="background: linear-gradient(120deg, #f8fafc 0%, #e0e7ff 100%);">
                <div class="about-section-title"><i class="fa fa-quote-left"></i> A Note from Inna</div>
                <p style="font-size:1.08em; color:#444;">I created this project to help both new and experienced crypto traders navigate the fast-paced world of digital assets. I hope you find it useful, insightful, and easy to use. Your feedback is always welcome—please use the form below to share your thoughts or suggestions!</p>
                <div style="font-size:0.98em; color:#888; margin-top:1em;"><em>Disclaimer: This site is for informational purposes only and does not provide financial advice. Please do your own research before making investment decisions.</em></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="about-card">
                <div class="about-section-title"><i class="fa fa-info-circle"></i> About This Project</div>
                <div class="about-welcome-text">
                    <p><em>Dear All,</em></p>
                    <p>I'm <strong>Inna Tarasyan</strong>, a web developer from Armenia, and I'm excited to introduce you to the <strong>Coin Trading Project</strong>. This platform is designed to combine cryptocurrency information from different major sources, allowing you to track all changes in key indicators of the crypto market in real-time.</p>
                    
                    <p>Our platform integrates data from the following trusted sources:</p>
                    <ul class="about-welcome-list">
                        <li>livecoinwatch.com - Real-time price tracking and market data</li>
                        <li>coingecko.com - Comprehensive crypto information and rankings</li>
                        <li>coinmarketcal.com - Crypto events and announcements calendar</li>
                    </ul>
                    
                    <p><strong>How it works:</strong> Information is automatically updated every 3 hours, but you can get the latest updates instantly by clicking the "Update All Data" button on any page. The system update takes about one minute and provides you with up-to-date cryptocurrency capitalization results. Click on any row in the data tables to see detailed information about a particular crypto coin.</p>
                    
                    <p><strong>Advanced Features:</strong> On the crypto coin details page, you can explore TradingView charts, social media mentions, and upcoming events. The charts display candlestick patterns and price performance over variable time spans, helping you predict trends and make better investment decisions. This information is perfect for both beginners and technical analysis experts.</p>
                    
                    <div style="background: linear-gradient(120deg, #e0f2fe 0%, #b3e5fc 100%); border: 2px solid #0288d1; border-radius: 1em; padding: 1.2em; margin: 1.2em 0; box-shadow: 0 2px 8px rgba(2,136,209,0.15);">
                        <div style="font-weight: 700; color: #01579b; margin-bottom: 0.8em; font-size: 1.2em;"><i class="fa fa-chart-line" style="margin-right: 0.5em;"></i>Coin Predictions Feature (/coinpredictions)</div>
                        <p style="font-size: 1.05em; color: #0277bd; margin-bottom: 1em; line-height: 1.6;"><strong>Advanced Price Prediction System:</strong> Our platform includes a sophisticated cryptocurrency price prediction feature that analyzes historical data and market trends to forecast future price movements for top cryptocurrencies including Bitcoin (BTC), Ethereum (ETH), Binance Coin (BNB), Solana (SOL), and Cardano (ADA).</p>
                        
                        <div style="margin-bottom: 1.2em;">
                            <h5 style="color: #01579b; font-weight: 600; margin-bottom: 0.5em;"><i class="fa fa-database" style="margin-right: 0.5em;"></i>Data Sources & APIs Used:</h5>
                            <ul style="margin: 0.7em 0 0.7em 1.2em; color: #0277bd;">
                                <li><strong>CoinGecko API:</strong> Primary data source providing comprehensive historical price data, market capitalization, trading volume, and current market metrics. The system fetches up to 14 days of historical data with daily intervals for accurate trend analysis.</li>
                                <li><strong>CoinPaprika API:</strong> Secondary fallback data source that provides alternative historical price data when CoinGecko data is insufficient. This ensures data reliability and continuous service availability.</li>
                                <li><strong>Cryptics.tech API:</strong> External prediction service that provides additional forecasting data from their proprietary analysis models, offering complementary insights to our internal calculations.</li>
                                <li><strong>Internal Database:</strong> Leverages existing platform data from LiveCoinWatch and CoinGecko tables for instant access to current market data, reducing API calls and improving response times.</li>
                            </ul>
                        </div>
                        
                        <div style="margin-bottom: 1.2em;">
                            <h5 style="color: #01579b; font-weight: 600; margin-bottom: 0.5em;"><i class="fa fa-calculator" style="margin-right: 0.5em;"></i>Technical Implementation:</h5>
                            <ul style="margin: 0.7em 0 0.7em 1.2em; color: #0277bd;">
                                <li><strong>Linear Regression Analysis:</strong> Implements mathematical regression models using the last 10 data points to calculate price trends and generate 7-day forward predictions with confidence intervals.</li>
                                <li><strong>Volatility Calculation:</strong> Computes price volatility using standard deviation analysis of the last 7 days of price data, helping users understand market risk and price stability.</li>
                                <li><strong>Multi-Layer Caching System:</strong> Implements intelligent caching at multiple levels - main predictions cache (10 minutes), symbol-specific cache (5 minutes), historical data cache (10 minutes), and external predictions cache (15 minutes) for optimal performance.</li>
                                <li><strong>Fallback Strategy:</strong> Robust error handling with automatic fallback between data sources, ensuring predictions are available even when primary APIs are temporarily unavailable.</li>
                            </ul>
                        </div>
                        
                        <div style="margin-bottom: 1.2em;">
                            <h5 style="color: #01579b; font-weight: 600; margin-bottom: 0.5em;"><i class="fa fa-tachometer-alt" style="margin-right: 0.5em;"></i>Performance Optimizations:</h5>
                            <ul style="margin: 0.7em 0 0.7em 1.2em; color: #0277bd;">
                                <li><strong>Database-First Approach:</strong> Prioritizes existing database data over API calls, reducing response times by up to 90% for frequently accessed symbols.</li>
                                <li><strong>Reduced API Timeouts:</strong> Implements 3-second timeout limits for external API calls to prevent page hanging and ensure responsive user experience.</li>
                                <li><strong>Minimal Data Requirements:</strong> Requires only 5 data points for predictions and 7 data points for volatility calculations, enabling faster processing while maintaining accuracy.</li>
                                <li><strong>Parallel Processing:</strong> Uses array_map for concurrent symbol data processing, reducing total calculation time for multiple cryptocurrencies.</li>
                                <li><strong>Browser Caching:</strong> Implements HTTP cache headers with 5-minute browser cache and ETag support for instant subsequent page loads.</li>
                            </ul>
                        </div>
                        
                        <div style="margin-bottom: 1.2em;">
                            <h5 style="color: #01579b; font-weight: 600; margin-bottom: 0.5em;"><i class="fa fa-chart-bar" style="margin-right: 0.5em;"></i>Prediction Features:</h5>
                            <ul style="margin: 0.7em 0 0.7em 1.2em; color: #0277bd;">
                                <li><strong>7-Day Price Forecasts:</strong> Generates daily price predictions for the next week based on historical trend analysis and market momentum.</li>
                                <li><strong>Market Metrics Integration:</strong> Includes current market capitalization, 24-hour trading volume, and price volatility in prediction analysis.</li>
                                <li><strong>Multi-Source Validation:</strong> Compares internal predictions with external API forecasts to provide users with comprehensive market insights.</li>
                                <li><strong>Real-Time Updates:</strong> Predictions refresh automatically with new market data, ensuring forecasts remain relevant and accurate.</li>
                                <li><strong>Error Handling:</strong> Graceful degradation when external APIs are unavailable, continuing to provide internal predictions based on available data.</li>
                            </ul>
                        </div>
                        
                        <div style="background: linear-gradient(120deg, #fff3e0 0%, #ffe0b2 100%); border: 1px solid #ff9800; border-radius: 0.5em; padding: 1em; margin-top: 1em;">
                            <p style="font-size: 1em; color: #e65100; margin: 0; line-height: 1.5;"><strong>Note:</strong> Predictions are based on historical data analysis and mathematical models. They should be used as one of many tools in your trading strategy, not as the sole basis for investment decisions. Market conditions can change rapidly, and past performance does not guarantee future results.</p>
                        </div>
                    </div>
                    
                    <div class="about-disclaimer" style="background: linear-gradient(120deg, #fef3c7 0%, #fde68a 100%); border: 2px solid #f59e0b; border-radius: 1em; padding: 1.2em; margin: 1.2em 0; box-shadow: 0 2px 8px rgba(245,158,11,0.15);">
                        <div style="font-weight: 700; color: #92400e; margin-bottom: 0.5em; font-size: 1.1em;"><i class="fa fa-exclamation-triangle" style="margin-right: 0.5em;"></i>Important Note:</div>
                        <p style="font-size: 1.05em; color: #78350f; margin: 0; line-height: 1.6;">This site is not responsible for your financial losses, if any. However, I will be very happy if this site helps you make money! Always do your own research and consider this as a learning tool rather than financial advice.</p>
                    </div>
                    
                    <p><strong>Educational Value:</strong> This site can also be considered as a tutorial of Laravel framework web application and other major web technologies. It demonstrates modern web development practices and real-world implementation of crypto data integration.</p>
                    
                    <p><strong>Your Feedback Matters:</strong> I would highly appreciate it if this site becomes a reference book for financial analysts. With gratitude, I will accept all your remarks, both in terms of functional purposes of this site and the software. Please contact me via the feedback feature found on this website if you have any questions or suggestions.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
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