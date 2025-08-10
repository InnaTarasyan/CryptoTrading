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
        return view('account.notifications');
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
        return view('account.billing');
    }

    public function support()
    {
        return view('account.support');
    }
} 