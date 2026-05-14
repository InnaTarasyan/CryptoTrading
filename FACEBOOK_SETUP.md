# Facebook API Setup Guide

## Prerequisites
1. A Facebook Developer Account
2. A Facebook App
3. Proper permissions and access tokens

## Step 1: Create Facebook App
1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Click "My Apps" → "Create App"
3. Choose "Business" as the app type
4. Fill in your app details

## Step 2: Configure App Settings
1. In your app dashboard, go to "Settings" → "Basic"
2. Note down your `App ID` and `App Secret`

## Step 3: Add Facebook Login Product
1. In your app dashboard, click "Add Product"
2. Add "Facebook Login" product
3. Configure OAuth redirect URIs if needed

## Step 4: Generate Access Token
1. Go to "Tools" → "Graph API Explorer"
2. Select your app from the dropdown
3. Click "Generate Access Token"
4. Grant necessary permissions (pages_read_engagement, groups_access, etc.)
5. Copy the generated access token

## Step 5: Configure Environment Variables
Create or update your `.env` file with:

```env
FACEBOOK_CLIENT_ID=your_app_id_here
FACEBOOK_CLIENT_SECRET=your_app_secret_here
FACEBOOK_REDIRECT_URI=your_redirect_uri_here
FACEBOOK_ACCESS_TOKEN=your_access_token_here
```

## Step 6: Test Configuration
1. Clear your application cache: `php artisan cache:clear`
2. Restart your application
3. Try the Facebook features again

## Important Notes
- Access tokens expire periodically and need to be refreshed
- Make sure your app has the necessary permissions for the features you want to use
- The app must be approved by Facebook for production use
- Keep your credentials secure and never commit them to version control

## Troubleshooting
- Check Laravel logs for detailed error messages
- Verify all environment variables are set correctly
- Ensure your Facebook app is not in development mode if you need public access
- Check if your access token has the required permissions 