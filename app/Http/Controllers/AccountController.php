<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

    public function security()
    {
        return view('account.security');
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