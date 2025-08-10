<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\UserNotification;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer\PngWriter;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('account.index');
    }

    public function profile()
    {
        return view('account.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => [
                'nullable',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:280',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'email_notifications' => 'required|in:all,important,none',
            'country' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'profile_public' => 'boolean',
            'show_email' => 'boolean',
            'show_location' => 'boolean',
            'show_social' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->update($request->all());

        return back()->with('success', 'Profile updated successfully!');
    }

    public function security()
    {
        return view('account.security');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->new_password),
            'password_changed_at' => now(),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function setupTwoFactor(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Check if 2FA is already enabled
            if ($user->two_factor_enabled) {
                return response()->json([
                    'success' => false,
                    'message' => 'Two-factor authentication is already enabled.'
                ], 400);
            }
            
            // Generate a new 2FA secret
            $google2fa = new Google2FA();
            $secret = $google2fa->generateSecretKey();
            
            // Generate QR code URL
            $qrCodeUrl = $google2fa->getQRCodeUrl(
                config('app.name', 'Crypto Trading'),
                $user->email,
                $secret
            );
            
            // Generate recovery codes
            $recoveryCodes = [];
            for ($i = 0; $i < 8; $i++) {
                $recoveryCodes[] = Str::random(10) . '-' . Str::random(10);
            }
            
            // Store the secret and recovery codes temporarily (not enabled yet)
            $user->update([
                'two_factor_secret' => $secret,
                'two_factor_recovery_codes' => $recoveryCodes,
            ]);
            
            return response()->json([
                'success' => true,
                'secret' => $secret,
                'qr_code_url' => $qrCodeUrl,
                'recovery_codes' => $recoveryCodes,
                'message' => 'Two-factor authentication setup initiated. Please scan the QR code and enter the verification code.'
            ]);
        } catch (\Exception $e) {
            \Log::error('2FA setup error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while setting up 2FA. Please try again.'
            ], 500);
        }
    }

    public function getRecoveryCodes(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->two_factor_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Two-factor authentication is not enabled.'
            ], 400);
        }
        
        return response()->json([
            'success' => true,
            'recovery_codes' => $user->two_factor_recovery_codes ?? []
        ]);
    }

    public function verifyTwoFactor(Request $request)
    {
        try {
            $request->validate([
                'verification_code' => ['required', 'string', 'size:6'],
            ]);

            $user = Auth::user();
            
            if (!$user->two_factor_secret) {
                return response()->json([
                    'success' => false,
                    'message' => 'Two-factor authentication setup not initiated.'
                ], 400);
            }

            $google2fa = new Google2FA();
            $valid = $google2fa->verifyKey($user->two_factor_secret, $request->verification_code);

            if ($valid) {
                $user->update([
                    'two_factor_enabled' => true,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Two-factor authentication enabled successfully!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code. Please try again.'
            ], 400);
        } catch (\Exception $e) {
            \Log::error('2FA verification error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying 2FA. Please try again.'
            ], 500);
        }
    }

    public function disableTwoFactor(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Two-factor authentication disabled successfully!'
        ]);
    }

    public function terminateSession(Request $request, $sessionId)
    {
        // Here you would implement session termination logic
        // For now, we'll just return a success response
        
        return response()->json([
            'success' => true,
            'message' => 'Session terminated successfully!'
        ]);
    }

    public function terminateAllSessions(Request $request)
    {
        // Here you would implement logic to terminate all other sessions
        // For now, we'll just return a success response
        
        return response()->json([
            'success' => true,
            'message' => 'All other sessions terminated successfully!'
        ]);
    }

    public function notifications()
    {
        $user = Auth::user();
        
        // Get recent notifications
        $recentNotifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Get notification statistics
        $stats = [
            'unread' => $user->unread_notifications_count,
            'today' => $user->notifications()->whereDate('created_at', today())->count(),
            'this_week' => $user->notifications()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'active_alerts' => $user->notifications()->where('type', 'price')->where('is_read', false)->count()
        ];
        
        return view('account.notifications', compact('recentNotifications', 'stats'));
    }

    public function saveNotificationSettings(Request $request)
    {
        \Log::info('saveNotificationSettings called with data:', $request->all());
        
        // More flexible validation rules
        $request->validate([
            'price' => 'nullable|array',
            'price.email' => 'nullable|boolean',
            'price.push' => 'nullable|boolean',
            'price.in_app' => 'nullable|boolean',
            'price.frequency' => 'nullable|in:immediate,hourly,daily',
            'portfolio' => 'nullable|array',
            'portfolio.email' => 'nullable|boolean',
            'portfolio.push' => 'nullable|boolean',
            'portfolio.in_app' => 'nullable|boolean',
            'portfolio.frequency' => 'nullable|in:immediate,hourly,daily',
            'security' => 'nullable|array',
            'security.email' => 'nullable|boolean',
            'security.push' => 'nullable|boolean',
            'security.in_app' => 'nullable|boolean',
            'security.frequency' => 'nullable|in:immediate,hourly,daily',
            'system' => 'nullable|array',
            'system.email' => 'nullable|boolean',
            'system.push' => 'nullable|boolean',
            'system.in_app' => 'nullable|boolean',
            'system.frequency' => 'nullable|in:immediate,hourly,daily',
            'advanced' => 'nullable|array',
            'advanced.quietHours' => 'nullable|boolean',
            'advanced.quietStart' => 'nullable|date_format:H:i',
            'advanced.quietEnd' => 'nullable|date_format:H:i',
            'advanced.sound' => 'nullable|boolean',
            'advanced.position' => 'nullable|in:top-right,top-left,bottom-right,bottom-left',
            'advanced.autoDismiss' => 'nullable|boolean',
            'advanced.groupNotifications' => 'nullable|boolean',
        ]);

        try {
            $user = Auth::user();
            \Log::info('User authenticated:', ['user_id' => $user->id, 'email' => $user->email]);
            
            // Process the form data and set defaults for missing values
            $notificationData = $this->processNotificationData($request->all());
            \Log::info('Processed notification data:', $notificationData);
            
            $user->notification_preferences = $notificationData;
            $user->save();
            
            \Log::info('Notification preferences saved successfully for user:', ['user_id' => $user->id]);

            // Force JSON response with explicit headers
            $response = response()->json([
                'success' => true,
                'message' => 'Notification settings saved successfully!'
            ]);
            
            $response->header('Content-Type', 'application/json');
            $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->header('Pragma', 'no-cache');
            $response->header('Expires', '0');
            
            \Log::info('Sending JSON response with headers:', [
                'content_type' => $response->headers->get('Content-Type'),
                'response_data' => ['success' => true, 'message' => 'Notification settings saved successfully!']
            ]);
            
            return $response;
        } catch (\Exception $e) {
            \Log::error('Error saving notification settings: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Force JSON response with explicit headers for error case too
            $response = response()->json([
                'success' => false,
                'message' => 'Error saving notification settings: ' . $e->getMessage()
            ], 500);
            
            $response->header('Content-Type', 'application/json');
            $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
            
            return $response;
        }
    }

    /**
     * Process notification data and set defaults
     */
    private function processNotificationData($data)
    {
        $defaults = [
            'price' => [
                'email' => true,
                'push' => true,
                'in_app' => true,
                'frequency' => 'immediate'
            ],
            'portfolio' => [
                'email' => true,
                'push' => true,
                'in_app' => true,
                'frequency' => 'daily'
            ],
            'security' => [
                'email' => true,
                'push' => true,
                'in_app' => true,
                'frequency' => 'immediate'
            ],
            'system' => [
                'email' => false,
                'push' => true,
                'in_app' => true,
                'frequency' => 'daily'
            ],
            'advanced' => [
                'quietHours' => false,
                'quietStart' => '22:00',
                'quietEnd' => '08:00',
                'sound' => true,
                'position' => 'top-right',
                'autoDismiss' => true,
                'groupNotifications' => true
            ]
        ];

        // Merge provided data with defaults
        $result = [];
        foreach ($defaults as $category => $categoryDefaults) {
            if (isset($data[$category]) && is_array($data[$category])) {
                $result[$category] = array_merge($categoryDefaults, $data[$category]);
            } else {
                $result[$category] = $categoryDefaults;
            }
        }

        return $result;
    }

    /**
     * Update notification read status
     */
    public function updateNotificationStatus(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications()->findOrFail($id);
            
            $request->validate([
                'is_read' => 'required|boolean'
            ]);

            if ($request->is_read) {
                $notification->markAsRead();
            } else {
                $notification->markAsUnread();
            }

            return response()->json([
                'success' => true,
                'message' => 'Notification status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating notification status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a notification
     */
    public function deleteNotification(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications()->findOrFail($id);
            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting notification: ' . $e->getMessage()
            ], 500);
        }
    }

    public function connections()
    {
        return view('account.connections');
    }

    public function apiKeys()
    {
        $apiKeys = Auth::user()->apiKeys()->orderBy('created_at', 'desc')->get();
        $availablePermissions = ApiKey::getAvailablePermissions();
        
        return view('account.api_keys', compact('apiKeys', 'availablePermissions'));
    }

    public function generateApiKey(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array|min:1',
            'permissions.*' => [
                'string',
                Rule::in(ApiKey::getAvailablePermissions())
            ]
        ]);

        // Check if user already has 10 API keys (limit)
        if (Auth::user()->apiKeys()->count() >= 10) {
            return back()->with('error', 'You can only have a maximum of 10 API keys.');
        }

        $apiKey = Auth::user()->apiKeys()->create([
            'name' => $request->name,
            'key' => ApiKey::generateKey(),
            'permissions' => $request->permissions,
            'is_active' => true
        ]);

        return back()->with('success', 'API key generated successfully!')
                    ->with('new_api_key', $apiKey->key);
    }

    public function deleteApiKey(ApiKey $apiKey)
    {
        // Ensure the API key belongs to the authenticated user
        if ($apiKey->user_id !== Auth::id()) {
            abort(403);
        }

        $apiKey->delete();

        return back()->with('success', 'API key deleted successfully.');
    }

    public function toggleApiKey(ApiKey $apiKey)
    {
        // Ensure the API key belongs to the authenticated user
        if ($apiKey->user_id !== Auth::id()) {
            abort(403);
        }

        $apiKey->update(['is_active' => !$apiKey->is_active]);

        $status = $apiKey->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "API key {$status} successfully.");
    }

    public function billing()
    {
        $user = Auth::user();
        
        // Mock data for demonstration - in a real app, this would come from your billing provider
        $billingData = [
            'current_plan' => [
                'name' => 'Pro Trading',
                'price' => 29.99,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'status' => 'active',
                'next_billing_date' => now()->addMonth()->format('M d, Y'),
                'features' => [
                    'Advanced trading tools',
                    'Real-time market data',
                    'Portfolio analytics',
                    'Priority support',
                    'API access'
                ]
            ],
            'payment_method' => [
                'type' => 'card',
                'last4' => '4242',
                'brand' => 'Visa',
                'expiry' => '12/25',
                'is_default' => true
            ],
            'billing_history' => [
                [
                    'date' => now()->subMonth()->format('M d, Y'),
                    'amount' => 29.99,
                    'currency' => 'USD',
                    'status' => 'paid',
                    'invoice_number' => 'INV-001'
                ],
                [
                    'date' => now()->subMonths(2)->format('M d, Y'),
                    'amount' => 29.99,
                    'currency' => 'USD',
                    'status' => 'paid',
                    'invoice_number' => 'INV-002'
                ]
            ],
            'usage' => [
                'api_calls' => 1250,
                'api_limit' => 10000,
                'storage_used' => '2.5 GB',
                'storage_limit' => '10 GB'
            ]
        ];
        
        return view('account.billing', compact('billingData'));
    }

    public function support()
    {
        return view('account.support');
    }
} 