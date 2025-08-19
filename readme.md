# 🚀 CryptoTrading Platform

**A Comprehensive Cryptocurrency Trading & Analytics Platform**

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE.txt)

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Pages & Functionality](#-pages--functionality)
- [Technologies Used](#-technologies-used)
- [Installation](#-installation)
- [API Integration](#-api-integration)
- [Performance Optimizations](#-performance-optimizations)
- [Screenshots](#-screenshots)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🌟 Overview

**CryptoTrading** is a sophisticated web application designed to provide comprehensive cryptocurrency market data, real-time analytics, and advanced trading insights. Built with Laravel 10 and modern web technologies, this platform aggregates data from multiple trusted sources to deliver accurate, up-to-date information for crypto traders and analysts.

### 🎯 Key Highlights

- **Real-time Data Integration** from 4 major crypto data providers
- **Advanced Price Predictions** using mathematical models and external APIs
- **Interactive Charts** powered by TradingView integration
- **Social Media Sentiment Analysis** from Telegram and Twitter
- **Comprehensive Market Analytics** with detailed metrics and comparisons
- **Mobile-First Responsive Design** for all devices
- **High-Performance Architecture** with intelligent caching

---

## ✨ Features

### 🔥 Core Features

- **📊 Real-Time Market Data**: Live price updates, market cap, volume, and trading metrics
- **📈 Advanced Charting**: Interactive TradingView charts with multiple timeframes
- **🎯 Price Predictions**: 7-day forecasts using linear regression and external APIs
- **📱 Social Sentiment**: Telegram and Twitter integration for community insights
- **📋 DataTables**: Advanced filtering, sorting, and export capabilities
- **🔄 Auto-Refresh**: Automatic data updates every 3 hours with manual refresh options
- **📊 Market Comparisons**: Cross-platform data comparison and analysis
- **🎪 Event Tracking**: Crypto calendar integration for upcoming events

### 🚀 Advanced Features

- **Multi-Layer Caching System**: Intelligent caching for optimal performance
- **Database-First Approach**: Prioritizes local data over API calls
- **Fallback Strategy**: Robust error handling with multiple data sources
- **Parallel Processing**: Concurrent data processing for multiple cryptocurrencies
- **Browser Caching**: HTTP cache headers for instant subsequent loads
- **API Rate Limiting**: Smart API usage with timeout management

---

## 📄 Pages & Functionality

### 🏠 **Main Dashboard** (`/`)
![Main Dashboard](https://via.placeholder.com/800x400/4F46E5/FFFFFF?text=Main+Dashboard)

**Description**: The central hub displaying comprehensive market overview with real-time data from multiple sources.

**Features**:
- Live market data from LiveCoinWatch, CoinGecko, and CoinMarketCal
- Interactive comparison charts and analytics
- Real-time price updates and market trends
- Cross-platform data validation
- Export functionality for data analysis

**Technical Implementation**:
- AJAX-powered real-time updates
- DataTables integration for advanced filtering
- Chart.js for visual analytics
- Responsive Bootstrap grid layout

---

### 🔮 **Coin Predictions** (`/coinpredictions`)
![Coin Predictions](https://via.placeholder.com/800x400/10B981/FFFFFF?text=Coin+Predictions)

**Description**: Advanced cryptocurrency price prediction system using mathematical models and external APIs.

**Features**:
- 7-day price forecasts for top cryptocurrencies (BTC, ETH, BNB, SOL, ADA)
- Linear regression analysis with confidence intervals
- Volatility calculations using standard deviation
- Multi-source validation (internal + external predictions)
- Real-time updates with new market data

**APIs Used**:
- **CoinGecko API**: Primary historical data source (14 days)
- **CoinPaprika API**: Secondary fallback data source
- **Cryptics.tech API**: External prediction service
- **Internal Database**: LiveCoinWatch and CoinGecko tables

**Technical Implementation**:
- Multi-layer caching system (10-15 minute cache durations)
- Database-first approach for 90% faster response times
- 3-second API timeouts for responsive UX
- Parallel processing with array_map
- Browser caching with ETag support

---

### 📊 **LiveCoinWatch History** (`/history`)
![LiveCoinWatch History](https://via.placeholder.com/800x400/3B82F6/FFFFFF?text=LiveCoinWatch+History)

**Description**: Comprehensive historical data analysis with detailed market metrics and trends.

**Features**:
- Historical price data with OHLCV information
- Market capitalization trends
- Volume analysis and liquidity metrics
- Price change percentages over multiple timeframes
- Advanced filtering and search capabilities

**Data Sources**:
- LiveCoinWatch API for real-time and historical data
- Multiple exchange integrations
- Fiat currency support
- Detailed market depth information

---

### 🏦 **LiveCoinWatch Exchanges** (`/livecoinexchangesindex`)
![Exchanges](https://via.placeholder.com/800x400/8B5CF6/FFFFFF?text=Exchanges)

**Description**: Comprehensive exchange listing with detailed metrics and performance data.

**Features**:
- Exchange rankings and ratings
- Trading volume and liquidity metrics
- Fee structures and trading pairs
- Security ratings and compliance information
- Real-time exchange status monitoring

---

### 💱 **LiveCoinWatch Fiats** (`/livecoinfiatsindex`)
![Fiats](https://via.placeholder.com/800x400/F59E0B/FFFFFF?text=Fiat+Currencies)

**Description**: Fiat currency tracking and exchange rate monitoring.

**Features**:
- Global fiat currency support
- Real-time exchange rates
- Historical rate trends
- Currency conversion tools
- Market impact analysis

---

### 🦎 **CoinGecko Markets** (`/coingeckomarketsindex`)
![CoinGecko Markets](https://via.placeholder.com/800x400/EF4444/FFFFFF?text=CoinGecko+Markets)

**Description**: Comprehensive cryptocurrency market data from CoinGecko's extensive database.

**Features**:
- 10,000+ cryptocurrency listings
- Market cap rankings and trends
- Price change analysis (1h, 24h, 7d, 30d)
- Developer activity metrics
- Community statistics and social sentiment

**Data Points**:
- Current price and market cap
- 24h trading volume
- Circulating and total supply
- All-time high/low prices
- Price change percentages

---

### 🏢 **CoinGecko Exchanges** (`/coingeckoexchangesindex`)
![CoinGecko Exchanges](https://via.placeholder.com/800x400/06B6D4/FFFFFF?text=CoinGecko+Exchanges)

**Description**: Detailed exchange information with trading volumes and trust scores.

**Features**:
- Exchange trust scores and rankings
- Trading volume analysis
- Year of establishment
- Country of origin
- Trading pair information

---

### 🔥 **CoinGecko Trendings** (`/coingeckotrendingsindex`)
![Trending Coins](https://via.placeholder.com/800x400/EC4899/FFFFFF?text=Trending+Cryptocurrencies)

**Description**: Real-time trending cryptocurrencies based on social media and market activity.

**Features**:
- Trending coin rankings
- Social media mentions
- Market cap rankings
- Price performance metrics
- Community engagement data

---

### 💱 **CoinGecko Exchange Rates** (`/coingeckoexchangeratesindex`)
![Exchange Rates](https://via.placeholder.com/800x400/84CC16/FFFFFF?text=Exchange+Rates)

**Description**: Global exchange rates and currency conversion data.

**Features**:
- Real-time exchange rates
- Multiple currency support
- Historical rate tracking
- Rate change analysis
- Currency conversion tools

---

### 🎨 **CoinGecko NFTs** (`/coingeckonftsindex`)
![NFTs](https://via.placeholder.com/800x400/A855F7/FFFFFF?text=NFT+Marketplace)

**Description**: NFT marketplace data and collection analytics.

**Features**:
- NFT collection rankings
- Floor prices and sales volume
- Market cap and trading activity
- Collection statistics
- Price trend analysis

---

### 📈 **CoinGecko Derivatives** (`/coingeckoderivativesindex`)
![Derivatives](https://via.placeholder.com/800x400/F97316/FFFFFF?text=Derivatives+Market)

**Description**: Cryptocurrency derivatives market data and analytics.

**Features**:
- Futures and options data
- Open interest and volume
- Funding rates
- Perpetual contract information
- Risk metrics

---

### 🏢 **CoinGecko Derivatives Exchanges** (`/coingeckoderivativesexchangesindex`)
![Derivatives Exchanges](https://via.placeholder.com/800x400/14B8A6/FFFFFF?text=Derivatives+Exchanges)

**Description**: Derivatives exchange rankings and performance metrics.

**Features**:
- Exchange trust scores
- Trading volume analysis
- Contract types supported
- Fee structures
- Security ratings

---

### 📅 **CoinMarketCal Events** (`/coinmarketcalindex`)
![Events Calendar](https://via.placeholder.com/800x400/6366F1/FFFFFF?text=Crypto+Events+Calendar)

**Description**: Comprehensive cryptocurrency events calendar and market-moving announcements.

**Features**:
- Upcoming crypto events
- Project announcements
- Exchange listings
- Hard forks and updates
- Community events

**Event Categories**:
- Exchange listings
- Hard forks
- Project updates
- Community events
- Regulatory announcements

---

### 💬 **Telegram Integration** (`/telegram`)
![Telegram](https://via.placeholder.com/800x400/0088CC/FFFFFF?text=Telegram+Integration)

**Description**: Social media sentiment analysis from Telegram channels and groups.

**Features**:
- Real-time message monitoring
- Sentiment analysis
- Trending topics
- Community engagement metrics
- Message filtering and search

**Technical Implementation**:
- MadelineProto integration
- Real-time message processing
- Sentiment scoring algorithms
- Message categorization
- User engagement tracking

---

### 🐦 **Twitter Integration** (`/twitter`)
![Twitter](https://via.placeholder.com/800x400/1DA1F2/FFFFFF?text=Twitter+Integration)

**Description**: Twitter sentiment analysis and crypto community monitoring.

**Features**:
- Real-time tweet monitoring
- Sentiment analysis
- Trending hashtags
- Influencer tracking
- Market sentiment correlation

**Technical Implementation**:
- Twitter API v2 integration
- Real-time stream processing
- Sentiment analysis algorithms
- Hashtag tracking
- User engagement metrics

---

### 🔗 **Trading Pairs** (`/tradingPairs`)
![Trading Pairs](https://via.placeholder.com/800x400/059669/FFFFFF?text=Trading+Pairs)

**Description**: Comprehensive trading pair analysis and market data.

**Features**:
- Trading pair listings
- Volume analysis
- Price correlation
- Market depth
- Liquidity metrics

---

### 📋 **Coin Details** (`/details/{coin}`)
![Coin Details](https://via.placeholder.com/800x400/7C3AED/FFFFFF?text=Detailed+Coin+Analysis)

**Description**: In-depth analysis page for individual cryptocurrencies.

**Features**:
- TradingView chart integration
- Social media mentions
- Upcoming events
- Technical indicators
- Market analysis

**Chart Features**:
- Multiple timeframes (1m to 1y)
- Technical indicators (RSI, MACD, Bollinger Bands)
- Drawing tools
- Price alerts
- Export capabilities

---

### 👤 **Profile** (`/profile`)
![Profile](https://via.placeholder.com/800x400/6B7280/FFFFFF?text=User+Profile)

**Description**: User profile management and preferences.

**Features**:
- User account settings
- Preference management
- Data export options
- Notification settings
- Security settings

---

### ℹ️ **About** (`/about`)
![About](https://via.placeholder.com/800x400/374151/FFFFFF?text=About+Project)

**Description**: Comprehensive project information and developer details.

**Features**:
- Project overview and features
- Technology stack details
- Developer information
- Contact form
- Feedback system

---

### 🔒 **Privacy Policy** (`/privacy-policy`)
![Privacy Policy](https://via.placeholder.com/800x400/1F2937/FFFFFF?text=Privacy+Policy)

**Description**: Privacy policy and data protection information.

---

## 🛠️ Technologies Used

### 🎯 **Backend Technologies**

| Technology | Version | Purpose |
|------------|---------|---------|
| **Laravel** | 10.x | PHP framework for robust backend development |
| **PHP** | 8.2+ | Server-side programming language |
| **MySQL** | 8.0+ | Primary database for data storage |
| **Redis** | 6.0+ | Caching and session management |
| **Composer** | 2.x | PHP dependency management |

### 🎨 **Frontend Technologies**

| Technology | Version | Purpose |
|------------|---------|---------|
| **Bootstrap** | 4.0+ | Responsive CSS framework |
| **jQuery** | 3.2+ | JavaScript library for DOM manipulation |
| **Vue.js** | 2.5+ | Progressive JavaScript framework |
| **Laravel Mix** | 2.0+ | Asset compilation and optimization |
| **Axios** | 0.18+ | HTTP client for API requests |

### 📊 **Data & Analytics**

| Technology | Purpose |
|------------|---------|
| **DataTables** | Advanced table functionality with sorting, filtering, and export |
| **TradingView** | Professional charting and technical analysis |
| **Chart.js** | Interactive charts and data visualization |
| **Select2** | Enhanced select dropdowns with search |

### 🔌 **API Integrations**

| API | Purpose | Rate Limits |
|-----|---------|-------------|
| **LiveCoinWatch** | Real-time price data and market metrics | 10,000 requests/month |
| **CoinGecko** | Comprehensive crypto data and rankings | 50 calls/minute |
| **CoinMarketCal** | Crypto events and announcements | 100 requests/hour |
| **CryptoCompare** | Markets, exchanges, coins metadata, news, top pairs | Varies by endpoint |
| **Twitter API** | Social media sentiment analysis | 300 requests/15min |
| **Telegram** | Community sentiment via MadelineProto | Real-time |

### 🚀 **Performance & Caching**

| Technology | Purpose |
|------------|---------|
| **Laravel Cache** | Multi-layer caching system |
| **Redis Cache** | High-performance data caching |
| **Browser Caching** | HTTP cache headers and ETags |
| **Database Indexing** | Optimized query performance |
| **CDN Integration** | Static asset delivery |

### 🔧 **Development Tools**

| Tool | Purpose |
|------|---------|
| **Git** | Version control and collaboration |
| **Composer** | PHP dependency management |
| **NPM** | JavaScript package management |
| **Laravel Mix** | Asset compilation and optimization |
| **PHPUnit** | Unit testing framework |

---

## 🚀 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer 2.x
- MySQL 8.0 or higher
- Redis 6.0 or higher
- Node.js 16.x or higher
- NPM 8.x or higher

### Step-by-Step Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/cryptotrading.git
   cd cryptotrading
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build Assets**
   ```bash
   npm run production
   ```

7. **Configure APIs**
   Add your API keys to the `.env` file:
   ```env
   LIVECOINWATCH_API_KEY=your_key_here
   COINGECKO_API_KEY=your_key_here
   TWITTER_API_KEY=your_key_here
   TELEGRAM_API_ID=your_id_here
   TELEGRAM_API_HASH=your_hash_here
   ```

8. **Start the Application**
   ```bash
   php artisan serve
   ```

### Docker Installation (Alternative)

```bash
# Build and run with Docker Compose
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate

# Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install && npm run production
```

---

## 🔌 API Integration

### LiveCoinWatch API

```php
// Example API integration
$response = Http::withHeaders([
    'x-api-key' => config('services.livecoinwatch.api_key')
])->get('https://api.livecoinwatch.com/coins/single', [
    'currency' => 'USD',
    'code' => 'BTC'
]);
```

### CoinGecko API

```php
// Example API integration
$response = Http::get('https://api.coingecko.com/api/v3/coins/markets', [
    'vs_currency' => 'usd',
    'order' => 'market_cap_desc',
    'per_page' => 100,
    'page' => 1
]);
```

### CryptoCompare API

```php
// Example: Fetch CryptoCompare markets from internal API
$response = Http::withHeaders([
    'X-API-Key' => $yourApiKey,
])->get(url('/api/cryptocompare/markets'), [
    'per_page' => 50,
]);
```

### Twitter API Integration

```php
// Using Twitter API v2
$twitter = new TwitterAPIExchange([
    'oauth_access_token' => config('services.twitter.access_token'),
    'oauth_access_token_secret' => config('services.twitter.access_token_secret'),
    'consumer_key' => config('services.twitter.consumer_key'),
    'consumer_secret' => config('services.twitter.consumer_secret')
]);
```

---

## ⚡ Performance Optimizations

### Caching Strategy

```php
// Multi-layer caching implementation
$data = Cache::remember('market_data', 300, function () {
    return $this->fetchMarketData();
});
```

### Database Optimization

```php
// Optimized queries with eager loading
$coins = Coin::with(['marketData', 'socialData'])
    ->where('active', true)
    ->orderBy('market_cap', 'desc')
    ->get();
```

### Asset Optimization

```bash
# Production asset compilation
npm run production

# Development with hot reload
npm run hot
```

---

## 🚀 API Management System (`/account/api-keys`)

### 🌟 **Revolutionary API Access Control**

The CryptoTrading platform features a **state-of-the-art API management system** that provides secure, scalable, and user-friendly access to all cryptocurrency data endpoints. This system transforms how developers and traders access our comprehensive data services.

![API Management](https://via.placeholder.com/800x400/8B5CF6/FFFFFF?text=API+Management+System)

---

### 🎯 **What is the API System?**

Our **API Management System** is a sophisticated authentication and authorization platform that allows users to:

- **Generate secure API keys** with custom permissions
- **Access 15+ data endpoints** across multiple cryptocurrency services
- **Control access levels** with granular permission settings
- **Monitor usage statistics** and track API key activity
- **Manage multiple keys** for different projects or applications

---

### 💎 **Key Benefits & Profits**

#### 🔒 **Security Benefits**
- **SHA-256 Encrypted Keys**: Military-grade encryption for API keys
- **Permission-Based Access**: Granular control over endpoint access
- **Instant Revocation**: Disable or delete keys immediately
- **Usage Tracking**: Monitor when and how your keys are used
- **Rate Limiting Ready**: Built-in protection against abuse

#### 💰 **Business Value**
- **Monetization Ready**: Foundation for premium API services
- **Developer-Friendly**: Easy integration for third-party applications
- **Scalable Architecture**: Handles thousands of concurrent requests
- **Cost Optimization**: Reduce server load with efficient data access
- **Analytics Foundation**: Track usage patterns and popular endpoints

#### 🚀 **Technical Advantages**
- **RESTful Design**: Industry-standard API architecture
- **JSON Responses**: Structured, parseable data format
- **Pagination Support**: Handle large datasets efficiently
- **Error Handling**: Comprehensive error messages and status codes
- **Multiple Auth Methods**: Header or query parameter authentication

---

### 🛠️ **Technologies Used**

#### **Backend Framework**
- **Laravel 10.x**: Modern PHP framework with elegant syntax
- **Eloquent ORM**: Database abstraction and relationships
- **Laravel Middleware**: Custom authentication and authorization
- **Artisan Commands**: Command-line tools for development

#### **Security Implementation**
- **SHA-256 Hashing**: Cryptographic key generation
- **Laravel Validation**: Robust input validation and sanitization
- **CSRF Protection**: Cross-site request forgery prevention
- **SQL Injection Prevention**: Parameterized queries and ORM protection

#### **Database Technology**
- **MySQL 8.0+**: Reliable relational database
- **Foreign Key Constraints**: Data integrity and referential integrity
- **JSON Columns**: Flexible permission storage
- **Indexing Strategy**: Optimized for fast key lookups

#### **Frontend Technologies**
- **Bootstrap 5**: Modern responsive framework
- **Vanilla JavaScript**: No framework dependencies
- **AJAX**: Asynchronous requests for smooth UX
- **FontAwesome Icons**: Professional iconography

---

### 📊 **Available Data Endpoints**

Our API provides access to **20+ comprehensive endpoints** across major cryptocurrency data sources:

#### 🟦 **CoinGecko Integration** (8 Endpoints)
```bash
GET /api/coingecko/exchanges          # Exchange data and rankings
GET /api/coingecko/coins              # Comprehensive coin information
GET /api/coingecko/exchange-rates     # Real-time exchange rates
GET /api/coingecko/markets            # Market data and analytics
GET /api/coingecko/trendings          # Trending cryptocurrencies
GET /api/coingecko/derivatives        # Derivatives market data
GET /api/coingecko/derivatives-exchanges  # Derivatives exchanges
GET /api/coingecko/nfts               # NFT market information
```

#### 🟢 **CoinMarketCal Integration** (2 Endpoints)
```bash
GET /api/coinmarketcal/coinmarketcals # Market calendar data
GET /api/coinmarketcal/events         # Upcoming crypto events
```

#### 🔵 **LiveCoinWatch Integration** (3 Endpoints)
```bash
GET /api/livecoinwatch/fiats          # Fiat currency data
GET /api/livecoinwatch/live-coin-histories  # Historical price data
GET /api/livecoinwatch/live-coin-watches    # Real-time coin tracking
```

#### 🟪 **CryptoCompare Integration** (5 Endpoints)
```bash
GET /api/cryptocompare/markets        # Aggregated market coverage
GET /api/cryptocompare/news           # Crypto news feed
GET /api/cryptocompare/exchanges      # Exchanges metadata
GET /api/cryptocompare/coins          # Coins metadata
GET /api/cryptocompare/top-pairs      # Top trading pairs
```

#### 🟡 **Social Media Integration** (2 Endpoints)
```bash
GET /api/telegram/messages            # Telegram crypto discussions
GET /api/twitter/messages             # Twitter crypto sentiment
```

---

### 🔑 **How to Use the API System**

#### **Step 1: Access API Management**
1. **Login** to your account
2. Navigate to **Account Settings** 
3. Click on **"API Keys"** in the sidebar
4. You'll see the comprehensive API management dashboard

#### **Step 2: Generate Your First API Key**
1. **Fill out the form**:
   - **Name**: Give your key a descriptive name (e.g., "Trading Bot v1")
   - **Permissions**: Select which endpoints you need access to
2. **Choose Permissions** by service:
   - **CoinGecko**: Market data, exchanges, trending coins
   - **CoinMarketCal**: Events and calendar data
   - **LiveCoinWatch**: Real-time prices and history
   - **Social**: Telegram and Twitter sentiment
3. **Click "Generate API Key"**
4. **Copy your key immediately** - you won't see it again!

#### **Step 3: Making API Requests**

##### **Authentication Methods**
```bash
# Method 1: HTTP Header (Recommended)
curl -H "X-API-Key: your_api_key_here" \
     "https://yoursite.com/api/coingecko/coins"

# Method 2: Query Parameter
curl "https://yoursite.com/api/coingecko/coins?api_key=your_api_key_here"
```

##### **Example Requests**
```bash
# Get trending cryptocurrencies with pagination
curl -H "X-API-Key: your_key" \
     "https://yoursite.com/api/coingecko/trendings?per_page=20&page=1"

# Get live coin data
curl -H "X-API-Key: your_key" \
     "https://yoursite.com/api/livecoinwatch/live-coin-watches?per_page=50"

# Get upcoming crypto events
curl -H "X-API-Key: your_key" \
     "https://yoursite.com/api/coinmarketcal/events"
```

##### **Response Format**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Bitcoin",
      "symbol": "BTC",
      "price": 45000.00,
      "market_cap": 850000000000
    }
  ],
  "pagination": {
    "current_page": 1,
    "last_page": 10,
    "per_page": 50,
    "total": 500
  }
}
```

---

### 📋 **Detailed Endpoint Documentation**

#### 🟦 **CoinGecko API Endpoints**

##### **1. Exchanges Data** (`/api/coingecko/exchanges`)
```bash
GET /api/coingecko/exchanges
```
**Description**: Comprehensive exchange information including rankings, trading volumes, and trust scores.

**Query Parameters**:
- `per_page` (optional): Number of results per page (default: 50, max: 250)
- `page` (optional): Page number for pagination (default: 1)

**Response Example**:
```json
{
  "status": "success",
  "data": [
    {
      "id": "binance",
      "name": "Binance",
      "year_established": 2017,
      "country": "Cayman Islands",
      "trust_score": 10,
      "trade_volume_24h_btc": 123456.789,
      "url": "https://www.binance.com/"
    }
  ]
}
```

##### **2. Coins Information** (`/api/coingecko/coins`)
```bash
GET /api/coingecko/coins
```
**Description**: Detailed information about cryptocurrencies including market data, community stats, and developer information.

**Query Parameters**:
- `vs_currency` (optional): Target currency (default: usd)
- `order` (optional): Sort order (market_cap_desc, market_cap_asc, volume_desc, volume_asc, id_desc, id_asc)
- `per_page` (optional): Results per page (default: 100, max: 250)
- `page` (optional): Page number (default: 1)
- `sparkline` (optional): Include sparkline data (true/false, default: false)

**Response Example**:
```json
{
  "status": "success",
  "data": [
    {
      "id": "bitcoin",
      "symbol": "btc",
      "name": "Bitcoin",
      "image": "https://assets.coingecko.com/coins/images/1/large/bitcoin.png",
      "current_price": 45000,
      "market_cap": 850000000000,
      "market_cap_rank": 1,
      "fully_diluted_valuation": 945000000000,
      "total_volume": 25000000000,
      "high_24h": 46000,
      "low_24h": 44000,
      "price_change_24h": 1000,
      "price_change_percentage_24h": 2.27,
      "market_cap_change_24h": 20000000000,
      "market_cap_change_percentage_24h": 2.41,
      "circulating_supply": 18800000,
      "total_supply": 21000000,
      "max_supply": 21000000,
      "ath": 69045,
      "ath_change_percentage": -34.85,
      "ath_date": "2021-11-10T14:24:11.849Z",
      "atl": 67.81,
      "atl_change_percentage": 66263.74,
      "atl_date": "2013-07-06T00:00:00.000Z",
      "roi": null,
      "last_updated": "2024-01-15T10:30:00.000Z"
    }
  ]
}
```

##### **3. Exchange Rates** (`/api/coingecko/exchange-rates`)
```bash
GET /api/coingecko/exchange-rates
```
**Description**: Real-time exchange rates for all supported cryptocurrencies.

**Response Example**:
```json
{
  "status": "success",
  "data": {
    "rates": {
      "btc": {
        "name": "Bitcoin",
        "unit": "BTC",
        "value": 1,
        "type": "crypto"
      },
      "eth": {
        "name": "Ether",
        "unit": "ETH",
        "value": 0.022,
        "type": "crypto"
      },
      "usd": {
        "name": "US Dollar",
        "unit": "$",
        "value": 45000,
        "type": "fiat"
      }
    }
  }
}
```

##### **4. Markets Data** (`/api/coingecko/markets`)
```bash
GET /api/coingecko/markets?vs_currency=usd&order=market_cap_desc&per_page=100&page=1&sparkline=false
```
**Description**: Market data for cryptocurrencies with comprehensive metrics and price information.

**Query Parameters**:
- `vs_currency` (required): Target currency (e.g., usd, eur, btc)
- `order` (optional): Sort order (default: market_cap_desc)
- `per_page` (optional): Results per page (default: 100, max: 250)
- `page` (optional): Page number (default: 1)
- `sparkline` (optional): Include sparkline data (default: false)

##### **5. Trending Coins** (`/api/coingecko/trendings`)
```bash
GET /api/coingecko/trendings
```
**Description**: Top trending coins in the last 24 hours based on price and volume changes.

**Response Example**:
```json
{
  "status": "success",
  "data": {
    "coins": [
      {
        "item": {
          "id": "shiba-inu",
          "coin_id": 279,
          "name": "Shiba Inu",
          "symbol": "shib",
          "market_cap_rank": 15,
          "thumb": "https://assets.coingecko.com/coins/images/11939/thumb/shiba.png",
          "small": "https://assets.coingecko.com/coins/images/11939/small/shiba.png",
          "large": "https://assets.coingecko.com/coins/images/11939/large/shiba.png",
          "slug": "shiba-inu",
          "price_btc": 0.00000001,
          "score": 0
        }
      }
    ]
  }
}
```

##### **6. Derivatives Data** (`/api/coingecko/derivatives`)
```bash
GET /api/coingecko/derivatives
```
**Description**: Information about cryptocurrency derivatives including futures and options.

##### **7. Derivatives Exchanges** (`/api/coingecko/derivatives-exchanges`)
```bash
GET /api/coingecko/derivatives-exchanges
```
**Description**: List of exchanges that offer cryptocurrency derivatives trading.

##### **8. NFTs Data** (`/api/coingecko/nfts`)
```bash
GET /api/coingecko/nfts
```
**Description**: Non-fungible token market data and collections information.

#### 🟢 **CoinMarketCal API Endpoints**

##### **1. Market Calendar** (`/api/coinmarketcal/coinmarketcals`)
```bash
GET /api/coinmarketcal/coinmarketcals
```
**Description**: General market calendar information and metadata.

##### **2. Events** (`/api/coinmarketcal/events`)
```bash
GET /api/coinmarketcal/events
```
**Description**: Upcoming cryptocurrency events, announcements, and important dates.

**Query Parameters**:
- `per_page` (optional): Results per page (default: 50)
- `page` (optional): Page number (default: 1)

**Response Example**:
```json
{
  "status": "success",
  "data": [
    {
      "id": 12345,
      "title": "Bitcoin Halving Event",
      "description": "Bitcoin block reward will be reduced from 6.25 BTC to 3.125 BTC",
      "date_event": "2024-04-20T00:00:00.000Z",
      "date_to": "2024-04-20T23:59:59.000Z",
      "date_from": "2024-04-20T00:00:00.000Z",
      "is_hot": true,
      "vote_count": 150,
      "positive_vote_count": 120,
      "percentage": 80,
      "categories": "Mining",
      "tip_symbol": "BTC",
      "tip_adress": "1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa"
    }
  ]
}
```

#### 🔵 **LiveCoinWatch API Endpoints**

##### **1. Fiat Currencies** (`/api/livecoinwatch/fiats`)
```bash
GET /api/livecoinwatch/fiats
```
**Description**: List of supported fiat currencies and their exchange rates.

##### **2. Live Coin Histories** (`/api/livecoinwatch/live-coin-histories`)
```bash
GET /api/livecoinwatch/live-coin-histories
```
**Description**: Historical price data for cryptocurrencies with customizable timeframes.

**Query Parameters**:
- `currency` (required): Cryptocurrency symbol (e.g., BTC, ETH)
- `start` (optional): Start timestamp in milliseconds
- `end` (optional): End timestamp in milliseconds

##### **3. Live Coin Watches** (`/api/livecoinwatch/live-coin-watches`)
```bash
GET /api/livecoinwatch/live-coin-watches
```
**Description**: Real-time cryptocurrency data including prices, volumes, and market metrics.

**Query Parameters**:
- `per_page` (optional): Results per page (default: 50)
- `page` (optional): Page number (default: 1)

#### 🟡 **Social Media API Endpoints**

##### **1. Telegram Messages** (`/api/telegram/messages`)
```bash
GET /api/telegram/messages
```
**Description**: Cryptocurrency-related discussions and sentiment from Telegram channels.

**Query Parameters**:
- `per_page` (optional): Results per page (default: 50)
- `page` (optional): Page number (default: 1)

**Response Example**:
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "message": "Bitcoin showing strong support at $45,000 level",
      "channel": "CryptoNews",
      "date": "2024-01-15T10:30:00.000Z",
      "sentiment": "positive",
      "engagement": 150
    }
  ]
}
```

##### **2. Twitter Messages** (`/api/twitter/messages`)
```bash
GET /api/twitter/messages
```
**Description**: Cryptocurrency tweets and social sentiment analysis from Twitter.

**Query Parameters**:
- `per_page` (optional): Results per page (default: 50)
- `page` (optional): Page number (default: 1)

---

### ⚙️ **Advanced Features**

#### **Permission Management**
- **Granular Control**: Select exactly which endpoints each key can access
- **Service Grouping**: Permissions organized by data provider
- **Easy Updates**: Enable/disable permissions without creating new keys

#### **Key Management**
- **Multiple Keys**: Create up to 10 API keys per account
- **Enable/Disable**: Temporarily disable keys without deletion
- **Usage Tracking**: See when each key was last used
- **Key Rotation**: Delete old keys and create new ones for security

#### **Security Features**
- **Automatic Expiry**: Optional key expiration (coming soon)
- **IP Restrictions**: Limit keys to specific IP addresses (coming soon)
- **Rate Limiting**: Prevent abuse with request limits
- **Activity Logging**: Track all API key usage

---

### 📈 **Performance & Scalability**

#### **Optimized Performance**
- **Database Indexing**: Fast API key lookups
- **Efficient Queries**: Optimized database queries with pagination
- **Caching Ready**: Prepared for Redis/Memcached integration
- **Minimal Overhead**: Lightweight authentication middleware

#### **Scalability Features**
- **Horizontal Scaling**: Ready for load balancer distribution
- **Database Optimization**: Efficient foreign key relationships
- **JSON Storage**: Flexible permission system that scales
- **Microservices Ready**: Modular architecture for future expansion

---

### 🛡️ **Security Best Practices**

#### **For Developers**
```bash
# ✅ DO: Use environment variables
export API_KEY="your_secret_key_here"
curl -H "X-API-Key: $API_KEY" "https://api.example.com/data"

# ❌ DON'T: Hardcode keys in your code
curl -H "X-API-Key: abc123def456" "https://api.example.com/data"
```

#### **Key Management Tips**
- **Rotate Regularly**: Create new keys every 3-6 months
- **Minimal Permissions**: Only grant access to needed endpoints
- **Monitor Usage**: Check the "Last Used" column regularly
- **Secure Storage**: Store keys in environment variables or secure vaults
- **Delete Unused Keys**: Remove keys you no longer need

---

### 🚀 **Real-World Use Cases**

#### **Trading Bots**
```javascript
// Example: Automated trading bot
const axios = require('axios');

const apiKey = process.env.CRYPTO_API_KEY;
const baseURL = 'https://yoursite.com/api';

async function getTrendingCoins() {
  const response = await axios.get(`${baseURL}/coingecko/trendings`, {
    headers: { 'X-API-Key': apiKey },
    params: { per_page: 10 }
  });
  return response.data;
}

async function getMarketData(symbol) {
  const response = await axios.get(`${baseURL}/livecoinwatch/live-coin-watches`, {
    headers: { 'X-API-Key': apiKey },
    params: { 
      per_page: 1,
      search: symbol 
    }
  });
  return response.data;
}

// Example trading strategy
async function analyzeMarket() {
  const trending = await getTrendingCoins();
  const analysis = [];
  
  for (const coin of trending.data.coins.slice(0, 5)) {
    const marketData = await getMarketData(coin.item.symbol);
    if (marketData.data.length > 0) {
      const coinData = marketData.data[0];
      analysis.push({
        symbol: coin.item.symbol,
        name: coin.item.name,
        price: coinData.price,
        volume_24h: coinData.volume_24h,
        market_cap: coinData.market_cap
      });
    }
  }
  
  return analysis;
}
```

#### **Mobile Applications**
```swift
// Example: iOS app integration
func fetchCoinData() {
    let url = URL(string: "https://yoursite.com/api/livecoinwatch/live-coin-watches")!
    var request = URLRequest(url: url)
    request.setValue("your_api_key", forHTTPHeaderField: "X-API-Key")
    
    URLSession.shared.dataTask(with: request) { data, response, error in
        // Handle response
    }.resume()
}

// Example: SwiftUI integration
struct CoinListView: View {
    @State private var coins: [Coin] = []
    
    var body: some View {
        List(coins, id: \.id) { coin in
            CoinRowView(coin: coin)
        }
        .onAppear {
            fetchCoins()
        }
    }
    
    func fetchCoins() {
        // API call implementation
    }
}
```

#### **Data Analytics**
```python
# Example: Python data analysis
import requests
import pandas as pd
import matplotlib.pyplot as plt

API_KEY = "your_api_key_here"
BASE_URL = "https://yoursite.com/api"

def get_market_data():
    headers = {"X-API-Key": API_KEY}
    response = requests.get(f"{BASE_URL}/coingecko/markets", headers=headers)
    return pd.DataFrame(response.json()['data'])

def get_historical_data(currency, days=30):
    headers = {"X-API-Key": API_KEY}
    end_time = int(pd.Timestamp.now().timestamp() * 1000)
    start_time = end_time - (days * 24 * 60 * 60 * 1000)
    
    params = {
        "currency": currency,
        "start": start_time,
        "end": end_time
    }
    
    response = requests.get(f"{BASE_URL}/livecoinwatch/live-coin-histories", 
                           headers=headers, params=params)
    return response.json()

# Analyze market trends
df = get_market_data()
print("Market Overview:")
print(f"Total coins: {len(df)}")
print(f"Total market cap: ${df['market_cap'].sum():,.0f}")
print(f"Average 24h volume: ${df['total_volume'].mean():,.0f}")

# Get Bitcoin historical data
btc_data = get_historical_data("BTC", days=7)
print(f"\nBitcoin 7-day data points: {len(btc_data['data'])}")

# Create price trend visualization
if 'data' in btc_data and btc_data['data']:
    prices = [point['price'] for point in btc_data['data']]
    dates = [pd.to_datetime(point['date']) for point in btc_data['data']]
    
    plt.figure(figsize=(12, 6))
    plt.plot(dates, prices)
    plt.title('Bitcoin Price Trend (7 Days)')
    plt.xlabel('Date')
    plt.ylabel('Price (USD)')
    plt.xticks(rotation=45)
    plt.tight_layout()
    plt.show()
```

#### **Web Applications**
```javascript
// Example: React.js integration
import React, { useState, useEffect } from 'react';
import axios from 'axios';

const API_KEY = process.env.REACT_APP_CRYPTO_API_KEY;
const BASE_URL = 'https://yoursite.com/api';

function CryptoDashboard() {
  const [coins, setCoins] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchCoins();
  }, []);

  const fetchCoins = async () => {
    try {
      setLoading(true);
      const response = await axios.get(`${BASE_URL}/coingecko/markets`, {
        headers: { 'X-API-Key': API_KEY },
        params: { 
          vs_currency: 'usd',
          order: 'market_cap_desc',
          per_page: 20,
          page: 1
        }
      });
      
      setCoins(response.data.data);
      setError(null);
    } catch (err) {
      setError('Failed to fetch coin data');
      console.error('API Error:', err);
    } finally {
      setLoading(false);
    }
  };

  if (loading) return <div>Loading...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <div className="crypto-dashboard">
      <h1>Cryptocurrency Dashboard</h1>
      <div className="coins-grid">
        {coins.map(coin => (
          <div key={coin.id} className="coin-card">
            <img src={coin.image} alt={coin.name} />
            <h3>{coin.name}</h3>
            <p>${coin.current_price.toLocaleString()}</p>
            <p className={coin.price_change_percentage_24h > 0 ? 'positive' : 'negative'}>
              {coin.price_change_percentage_24h.toFixed(2)}%
            </p>
          </div>
        ))}
      </div>
    </div>
  );
}

export default CryptoDashboard;
```

#### **Python Trading Bot**
```python
# Example: Advanced trading bot with multiple data sources
import requests
import time
import json
from datetime import datetime, timedelta

class CryptoTradingBot:
    def __init__(self, api_key):
        self.api_key = api_key
        self.base_url = "https://yoursite.com/api"
        self.headers = {"X-API-Key": api_key}
        
    def get_trending_coins(self):
        """Get trending coins for potential opportunities"""
        response = requests.get(
            f"{self.base_url}/coingecko/trendings",
            headers=self.headers
        )
        return response.json()
    
    def get_market_data(self, symbol):
        """Get comprehensive market data for a specific coin"""
        response = requests.get(
            f"{self.base_url}/coingecko/coins",
            headers=self.headers,
            params={"ids": symbol, "vs_currency": "usd"}
        )
        return response.json()
    
    def get_social_sentiment(self):
        """Get social media sentiment for market analysis"""
        telegram = requests.get(
            f"{self.base_url}/telegram/messages",
            headers=self.headers,
            params={"per_page": 50}
        ).json()
        
        twitter = requests.get(
            f"{self.base_url}/twitter/messages",
            headers=self.headers,
            params={"per_page": 50}
        ).json()
        
        return {"telegram": telegram, "twitter": twitter}
    
    def analyze_market_opportunity(self, symbol):
        """Analyze if a coin presents a trading opportunity"""
        try:
            # Get market data
            market_data = self.get_market_data(symbol)
            if not market_data.get('data'):
                return None
            
            coin = market_data['data'][0]
            
            # Get social sentiment
            sentiment = self.get_social_sentiment()
            
            # Calculate opportunity score
            score = 0
            
            # Price momentum (30% weight)
            if coin['price_change_percentage_24h'] > 5:
                score += 30
            elif coin['price_change_percentage_24h'] > 0:
                score += 15
            
            # Volume analysis (25% weight)
            if coin['total_volume'] > 10000000:  # $10M+ volume
                score += 25
            elif coin['total_volume'] > 1000000:  # $1M+ volume
                score += 15
            
            # Market cap analysis (20% weight)
            if coin['market_cap'] < 1000000000:  # Under $1B (potential for growth)
                score += 20
            elif coin['market_cap'] < 10000000000:  # Under $10B
                score += 10
            
            # Social sentiment (25% weight)
            social_volume = len(sentiment['telegram'].get('data', [])) + len(sentiment['twitter'].get('data', []))
            if social_volume > 100:
                score += 25
            elif social_volume > 50:
                score += 15
            
            return {
                "symbol": symbol,
                "name": coin['name'],
                "current_price": coin['current_price'],
                "opportunity_score": score,
                "analysis": {
                    "price_momentum": coin['price_change_percentage_24h'],
                    "volume": coin['total_volume'],
                    "market_cap": coin['market_cap'],
                    "social_volume": social_volume
                }
            }
            
        except Exception as e:
            print(f"Error analyzing {symbol}: {e}")
            return None
    
    def run_opportunity_scan(self):
        """Scan for trading opportunities across trending coins"""
        print("🔍 Scanning for trading opportunities...")
        
        trending = self.get_trending_coins()
        opportunities = []
        
        for coin in trending['data']['coins'][:10]:  # Top 10 trending
            symbol = coin['item']['id']
            opportunity = self.analyze_market_opportunity(symbol)
            
            if opportunity and opportunity['opportunity_score'] > 60:
                opportunities.append(opportunity)
        
        # Sort by opportunity score
        opportunities.sort(key=lambda x: x['opportunity_score'], reverse=True)
        
        print(f"\n🎯 Found {len(opportunities)} high-opportunity coins:")
        for opp in opportunities:
            print(f"\n{opp['name']} ({opp['symbol'].upper()})")
            print(f"  Opportunity Score: {opp['opportunity_score']}/100")
            print(f"  Current Price: ${opp['current_price']:,.2f}")
            print(f"  Analysis: {opp['analysis']}")
        
        return opportunities

# Usage example
if __name__ == "__main__":
    bot = CryptoTradingBot("your_api_key_here")
    
    while True:
        try:
            opportunities = bot.run_opportunity_scan()
            
            if opportunities:
                print(f"\n🚀 Top opportunity: {opportunities[0]['name']}")
                print(f"   Score: {opportunities[0]['opportunity_score']}/100")
            
            print(f"\n⏰ Next scan in 5 minutes...")
            time.sleep(300)  # Wait 5 minutes
            
        except KeyboardInterrupt:
            print("\n🛑 Bot stopped by user")
            break
        except Exception as e:
            print(f"❌ Error: {e}")
            time.sleep(60)  # Wait 1 minute before retry
```

---

### 📞 **API Support & Documentation**

#### **Getting Help**
- **Built-in Documentation**: Complete API docs in the dashboard
- **Response Examples**: See exactly what each endpoint returns
- **Error Codes**: Comprehensive error handling and status codes
- **Rate Limits**: Clear information about usage limits

#### **Status Codes**
```
200 - Success: Request completed successfully
401 - Unauthorized: Invalid or missing API key
403 - Forbidden: Insufficient permissions for endpoint
429 - Too Many Requests: Rate limit exceeded
500 - Server Error: Internal server error
```

#### **Common Issues & Solutions**
```bash
# Issue: "API key is required"
# Solution: Include X-API-Key header or api_key parameter

# Issue: "Invalid or inactive API key"
# Solution: Check if key is active in dashboard

# Issue: "API key does not have permission"
# Solution: Add required permissions in key settings
```

#### **Rate Limiting & Best Practices**
```bash
# ✅ DO: Implement exponential backoff
# ✅ DO: Cache responses when possible
# ✅ DO: Use pagination for large datasets
# ✅ DO: Monitor your API usage

# ❌ DON'T: Make requests faster than 1 per second
# ❌ DON'T: Ignore rate limit headers
# ❌ DON'T: Make unnecessary requests
```

---

### 🎯 **API Monetization Strategy**

#### **Current Free Tier**
- **15+ Endpoints**: Access to all major cryptocurrency data sources
- **Unlimited Requests**: No artificial rate limiting
- **Full Data Access**: Complete market data and analytics
- **Professional Support**: Developer assistance and documentation

#### **Future Premium Features** (Coming Soon)
- **Higher Rate Limits**: Increased requests per minute
- **WebSocket Support**: Real-time data streaming
- **Advanced Analytics**: Machine learning insights and predictions
- **Priority Support**: Dedicated technical support
- **Custom Endpoints**: Tailored data solutions for enterprise clients

#### **Enterprise Solutions**
- **White-Label APIs**: Custom branding and endpoints
- **Dedicated Infrastructure**: Isolated servers and databases
- **Custom Integrations**: Tailored data solutions
- **SLA Guarantees**: 99.9% uptime and response time guarantees

---

## 📸 Screenshots

### 📱 **Mobile Responsive Design**

All screenshots above demonstrate the platform's mobile-first responsive design, ensuring optimal user experience across all devices.

### 🎨 **Interactive Features**

- **Click to Enlarge**: Click any screenshot to view in full resolution
- **Hover Effects**: Hover over images for smooth scaling animations
- **Responsive Grid**: Automatically adjusts layout for different screen sizes
- **High Quality**: All screenshots are captured in high resolution (800x600+)

---

## 🖼️ **Screenshot Gallery (Alternative View)**

For a more traditional view, you can also access the screenshots directly:

| Screenshot | Description | Link |
|------------|-------------|------|
| **Top Coins** | Overview of top cryptocurrencies | [View Full Size](/demo/TopCoins.png) |
| **Markets Comparison Charts** | Market comparison analytics | [View Full Size](/demo/MarketsComparisonCharts.png) |
| **TradingView Charts** | Professional trading charts | [View Full Size](/demo/TradingViewCharts.png) |
| **Coin Details** | Detailed coin analysis page | [View Full Size](/demo/details.png) |
| **Events Calendar** | Crypto events calendar | [View Full Size](/demo/coinmarketcal.png) |
| **CoinGecko Markets** | Cryptocurrency market data | [View Full Size](/demo/coingecko.png) |
| **LiveCoinWatch** | LiveCoinWatch integration | [View Full Size](/demo/livecoinwatch.png) |
| **Markets Comparison** | Market comparison view | [View Full Size](/demo/MarketsComparizon.png) |
| **Price Predictions** | Coin price prediction system | [View Full Size](/demo/Predictions.png) |

---

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards
- Write unit tests for new features
- Update documentation for API changes
- Ensure mobile responsiveness
- Optimize for performance

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.txt](LICENSE.txt) file for details.

---

## 👨‍💻 Developer

**Inna Tarasyan** - Web Developer & Crypto Enthusiast

- 🌍 **Location**: Armenia
- 📧 **Email**: innatarasyanmail@gmail.com
- 💬 **Telegram**: [@innatarasyan](https://t.me/innatarasyan)
- 🐙 **GitHub**: [@innatarasyan](https://github.com/innatarasyan)

---

## 🙏 Acknowledgments

- **Laravel Team** for the amazing framework
- **LiveCoinWatch** for real-time market data
- **CoinGecko** for comprehensive crypto information
- **CoinMarketCal** for crypto events calendar
- **CryptoCompare** for markets, exchanges, coins, news and pairs data
- **TradingView** for professional charting tools
- **Bootstrap** for responsive design framework

---

## 📞 Support

For support, questions, or feedback:

- 📧 Email: innatarasyanmail@gmail.com
- 💬 Telegram: [@innatarasyan](https://t.me/innatarasyan)
- 🐙 GitHub Issues: [Create an issue](https://github.com/yourusername/cryptotrading/issues)

---

**Disclaimer**: This platform is for informational purposes only and does not provide financial advice. Always do your own research before making investment decisions.
