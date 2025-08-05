{{-- SEO Helper Functions --}}
@php
    // Default SEO values
    $defaultTitle = 'Crypto Trading - Live Cryptocurrency Tracking & Analysis Platform';
    $defaultDescription = 'Track live cryptocurrency prices, social volume changes on Reddit and Twitter, and comprehensive crypto market analysis. Real-time data from CoinMarketCap, TradingView, and more.';
    $defaultKeywords = 'cryptocurrency, bitcoin, ethereum, crypto trading, live crypto prices, cryptocurrency tracking, crypto market analysis, bitcoin price, ethereum price, altcoins, crypto portfolio, trading view, coinmarketcap, crypto news, blockchain, digital currency, crypto investment, crypto signals, crypto charts, crypto trading platform';
    $defaultImage = url('assets/demo/demo7/media/img/logo/logo.png');
    
    // Get current page SEO data
    $pageTitle = $pageTitle ?? $defaultTitle;
    $pageDescription = $pageDescription ?? $defaultDescription;
    $pageKeywords = $pageKeywords ?? $defaultKeywords;
    $pageImage = $pageImage ?? $defaultImage;
    $pageUrl = url()->current();
    $pageType = $pageType ?? 'website';
@endphp

{{-- SEO Meta Tags Section --}}
@section('seo_meta')
    {{-- Primary Meta Tags --}}
    <title>{{ $pageTitle }}</title>
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="keywords" content="{{ $pageKeywords }}">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="{{ $pageType }}">
    <meta property="og:url" content="{{ $pageUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $pageTitle }}">
    
    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $pageUrl }}">
    <meta property="twitter:title" content="{{ $pageTitle }}">
    <meta property="twitter:description" content="{{ $pageDescription }}">
    <meta property="twitter:image" content="{{ $pageImage }}">
    
    {{-- Additional Page-Specific Meta Tags --}}
    @if(isset($pageAuthor))
        <meta name="author" content="{{ $pageAuthor }}">
    @endif
    
    @if(isset($pagePublishedTime))
        <meta property="article:published_time" content="{{ $pagePublishedTime }}">
    @endif
    
    @if(isset($pageModifiedTime))
        <meta property="article:modified_time" content="{{ $pageModifiedTime }}">
    @endif
    
    @if(isset($pageSection))
        <meta property="article:section" content="{{ $pageSection }}">
    @endif
    
    @if(isset($pageTags))
        @foreach($pageTags as $tag)
            <meta property="article:tag" content="{{ $tag }}">
        @endforeach
    @endif
    
    {{-- Structured Data for Current Page --}}
    @if($pageType === 'article')
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "headline": "{{ $pageTitle }}",
            "description": "{{ $pageDescription }}",
            "image": "{{ $pageImage }}",
            "author": {
                "@type": "Person",
                "name": "{{ $pageAuthor ?? 'Crypto Trading Team' }}"
            },
            "publisher": {
                "@type": "Organization",
                "name": "Crypto Trading",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ url('assets/demo/demo7/media/img/logo/logo.png') }}"
                }
            },
            "datePublished": "{{ $pagePublishedTime ?? now()->toISOString() }}",
            "dateModified": "{{ $pageModifiedTime ?? now()->toISOString() }}",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ $pageUrl }}"
            }
        }
        </script>
    @elseif($pageType === 'product')
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Product",
            "name": "{{ $pageTitle }}",
            "description": "{{ $pageDescription }}",
            "image": "{{ $pageImage }}",
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "USD",
                "availability": "https://schema.org/InStock"
            }
        }
        </script>
    @endif
@endsection

{{-- SEO Helper Functions --}}
@php
    // Function to set page SEO data
    function setPageSEO($title = null, $description = null, $keywords = null, $image = null, $type = 'website', $author = null, $publishedTime = null, $modifiedTime = null, $section = null, $tags = []) {
        global $pageTitle, $pageDescription, $pageKeywords, $pageImage, $pageType, $pageAuthor, $pagePublishedTime, $pageModifiedTime, $pageSection, $pageTags;
        
        if ($title) $pageTitle = $title;
        if ($description) $pageDescription = $description;
        if ($keywords) $pageKeywords = $keywords;
        if ($image) $pageImage = $image;
        if ($type) $pageType = $type;
        if ($author) $pageAuthor = $author;
        if ($publishedTime) $pagePublishedTime = $publishedTime;
        if ($modifiedTime) $pageModifiedTime = $modifiedTime;
        if ($section) $pageSection = $section;
        if ($tags) $pageTags = $tags;
    }
    
    // Function to get current page data
    function getCurrentPageData() {
        return [
            'title' => $pageTitle ?? 'Crypto Trading - Live Cryptocurrency Tracking & Analysis Platform',
            'description' => $pageDescription ?? 'Track live cryptocurrency prices, social volume changes on Reddit and Twitter, and comprehensive crypto market analysis.',
            'keywords' => $pageKeywords ?? 'cryptocurrency, bitcoin, ethereum, crypto trading',
            'image' => $pageImage ?? url('assets/demo/demo7/media/img/logo/logo.png'),
            'url' => url()->current(),
            'type' => $pageType ?? 'website'
        ];
    }
@endphp 