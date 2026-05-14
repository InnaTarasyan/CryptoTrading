# API Configuration Guide

This document explains how to configure the external API settings for the CryptoTrading application.

## Environment Variables

Add these variables to your `.env` file to customize API behavior:

### Cryptics.tech API Settings

```bash
# Base URL for the API
CRYPTICS_TECH_BASE_URL=https://devapi.cryptics.tech

# Request timeout in seconds
CRYPTICS_TECH_TIMEOUT=10

# Whether to verify SSL certificates
CRYPTICS_TECH_SSL_VERIFY=false

# Whether to fallback to HTTP if HTTPS fails
CRYPTICS_TECH_FALLBACK_HTTP=true

# Whether to use demo data when API is unavailable
CRYPTICS_TECH_USE_DEMO_DATA=true
```

### CoinPaprika API Settings

```bash
# Base URL for the API
COINPAPRIKA_BASE_URL=https://api.coinpaprika.com

# Request timeout in seconds
COINPAPRIKA_TIMEOUT=10

# Whether to verify SSL certificates
COINPAPRIKA_SSL_VERIFY=true
```

### CoinGecko API Settings

```bash
# Base URL for the API
COINGECKO_BASE_URL=https://api.coingecko.com

# Request timeout in seconds
COINGECKO_TIMEOUT=10

# Whether to verify SSL certificates
COINGECKO_SSL_VERIFY=true
```

### Global API Settings

```bash
# Default timeout for all API calls
API_DEFAULT_TIMEOUT=10

# Default SSL verification for all API calls
API_DEFAULT_SSL_VERIFY=true

# Number of retry attempts for failed API calls
API_RETRY_ATTEMPTS=2

# Delay between retry attempts in milliseconds
API_RETRY_DELAY=1000
```

## SSL Issues Resolution

### For Cryptics.tech API

If you're experiencing SSL certificate issues with the Cryptics.tech API:

1. **Disable SSL verification** (for development/testing):
   ```bash
   CRYPTICS_TECH_SSL_VERIFY=false
   ```

2. **Enable HTTP fallback**:
   ```bash
   CRYPTICS_TECH_FALLBACK_HTTP=true
   ```

3. **Enable demo data fallback**:
   ```bash
   CRYPTICS_TECH_USE_DEMO_DATA=true
   ```

### For Production Environments

In production, you should:

1. **Enable SSL verification**:
   ```bash
   CRYPTICS_TECH_SSL_VERIFY=true
   CRYPTICS_TECH_FALLBACK_HTTP=false
   ```

2. **Contact the API provider** to fix SSL certificate issues

3. **Use proper SSL certificates** on your server

## Demo Data

When the Cryptics.tech API is unavailable, the system will automatically fall back to demo data that includes:

- Realistic prediction counts (150-300)
- Accuracy percentages (65-85%)
- Sample trending data
- Visual indicators that the data is demo data

## Testing Configuration

To test your API configuration:

1. Visit the main page (`/`)
2. Check the browser console for any API-related messages
3. Look for the Cryptics.tech block - it should show either real data or demo data
4. Check the network tab in browser dev tools for API calls

## Troubleshooting

### Common Issues

1. **SSL Certificate Errors**:
   - Set `CRYPTICS_TECH_SSL_VERIFY=false`
   - Enable `CRYPTICS_TECH_FALLBACK_HTTP=true`

2. **Timeout Errors**:
   - Increase timeout values (e.g., `CRYPTICS_TECH_TIMEOUT=30`)

3. **API Unavailable**:
   - Enable `CRYPTICS_TECH_USE_DEMO_DATA=true`
   - Check if the API endpoint is accessible from your server

### Debug Mode

Enable debug logging by setting in your `.env`:
```bash
APP_DEBUG=true
LOG_LEVEL=debug
```

This will log API errors to your Laravel log files.

## Security Notes

- **Never disable SSL verification in production** unless absolutely necessary
- **Use HTTPS endpoints** whenever possible
- **Implement rate limiting** for external API calls
- **Monitor API usage** to avoid hitting rate limits
- **Cache API responses** to reduce external dependencies 