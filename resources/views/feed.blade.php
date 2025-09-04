@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<rss version="2.0">
  <channel>
    <title>CryptoTrading RSS Feed</title>
    <link>{{ url('/') }}</link>
    <description>Latest updates from CryptoTrading</description>
    <language>en-us</language>
    <lastBuildDate>{{ now()->toRfc2822String() }}</lastBuildDate>

    <item>
      <title>Homepage</title>
      <link>{{ url('/') }}</link>
      <guid isPermaLink="true">{{ url('/') }}</guid>
      <pubDate>{{ now()->toRfc2822String() }}</pubDate>
      <description><![CDATA[Welcome to CryptoTrading. Track live prices and market data.]]></description>
    </item>

    <item>
      <title>About</title>
      <link>{{ url('/about') }}</link>
      <guid isPermaLink="true">{{ url('/about') }}</guid>
      <pubDate>{{ now()->toRfc2822String() }}</pubDate>
      <description><![CDATA[Learn about CryptoTrading and the platform features.]]></description>
    </item>

  </channel>
</rss> 