<?php

namespace App\Http\Controllers;

use App\Models\FacebookGroup;
use App\Models\FacebookPost;
use App\Models\FacebookUser;
use App\Models\FacebookComment;
use App\Services\FacebookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FacebookController extends Controller
{
    protected $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    /**
     * Display the Facebook dashboard
     */
    public function index()
    {
        $stats = $this->getStats();
        $apiStatus = $this->facebookService->getConfigStatus();
        
        return view('facebook.index', compact('stats', 'apiStatus'));
    }

    /**
     * Display Facebook groups
     */
    public function groups()
    {
        $groups = FacebookGroup::active()
            ->open()
            ->withCount(['posts' => function ($query) {
                $query->visible();
            }])
            ->orderBy('member_count', 'desc')
            ->paginate(20);

        return view('facebook.groups', compact('groups'));
    }

    /**
     * Display Facebook posts
     */
    public function posts(Request $request)
    {
        $query = FacebookPost::visible()
            ->with(['group', 'author'])
            ->withCount('comments');

        // Apply filters
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->dateRange($request->date_from, $request->date_to);
        }

        $posts = $query->orderBy('posted_at', 'desc')->paginate(20);
        $groups = FacebookGroup::active()->pluck('name', 'group_id');

        return view('facebook.posts', compact('posts', 'groups'));
    }

    /**
     * Display Facebook users
     */
    public function users(Request $request)
    {
        $query = FacebookUser::withCount(['posts' => function ($query) {
            $query->visible();
        }]);

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('verified')) {
            $query->verified();
        }

        $users = $query->orderBy('followers_count', 'desc')->paginate(20);

        return view('facebook.users', compact('users'));
    }

    /**
     * Display posts for a specific coin
     */
    public function coinPosts($coin)
    {
        $coin = strtolower(trim($coin));
        
        $posts = FacebookPost::visible()
            ->with(['group', 'author'])
            ->withCount('comments')
            ->where(function ($query) use ($coin) {
                $query->where('message', 'like', "%{$coin}%")
                      ->orWhere('message', 'like', "%#" . strtoupper($coin) . "%")
                      ->orWhere('message', 'like', "%" . ucfirst($coin) . "%");
            })
            ->orderBy('posted_at', 'desc')
            ->paginate(20);

        $stats = $this->getCoinStats($coin);

        return view('facebook.coin-posts', compact('posts', 'coin', 'stats'));
    }

    /**
     * Get posts for DataTable
     */
    public function getPosts(Request $request)
    {
        $query = FacebookPost::visible()
            ->with(['group', 'author'])
            ->withCount('comments');

        // Apply search
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->search($search);
        }

        // Apply filters
        if ($request->filled('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        $total = $query->count();
        $posts = $query->orderBy('posted_at', 'desc')
            ->skip($request->input('start', 0))
            ->take($request->input('length', 10))
            ->get();

        $data = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'post_id' => $post->post_id,
                'group_name' => $post->group->name ?? 'Unknown Group',
                'author_name' => $post->author->name ?? 'Unknown User',
                'message' => $this->truncateMessage($post->message, 100),
                'type' => ucfirst($post->type),
                'likes_count' => $post->likes_count,
                'comments_count' => $post->comments_count,
                'shares_count' => $post->shares_count,
                'posted_at' => $post->posted_at->format('M d, Y H:i'),
                'group_id' => $post->group_id,
                'author_id' => $post->author_id
            ];
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ]);
    }

    /**
     * Fetch Facebook data from API
     */
    public function fetchData(Request $request)
    {
        try {
            $coin = $request->input('coin', 'bitcoin');
            $limit = min($request->input('limit', 50), 100);

            // Check if Facebook API is configured
            $apiStatus = $this->facebookService->getConfigStatus();
            
            if (!$apiStatus['fully_configured']) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Facebook API not configured. Please configure your Facebook API credentials to fetch real data.',
                    'api_status' => $apiStatus,
                    'note' => 'Currently showing mock data'
                ], 200);
            }

            // Use Facebook service to fetch real data
            $data = $this->facebookService->searchCryptoPosts($coin, $limit);

            if ($data['status'] === 'success') {
                // Store fetched data in database
                $this->storeFacebookData($data['data']);

                return response()->json([
                    'status' => 'success',
                    'data' => $data,
                    'message' => 'Facebook data fetched successfully',
                    'api_status' => $apiStatus
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch Facebook data',
                'api_status' => $apiStatus
            ], 500);

        } catch (\Exception $e) {
            Log::error('Facebook data fetch error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch Facebook data: ' . $e->getMessage(),
                'api_status' => $this->facebookService->getConfigStatus()
            ], 500);
        }
    }

    /**
     * Search for cryptocurrency posts
     */
    public function searchPosts(Request $request)
    {
        try {
            $query = $request->input('query', 'bitcoin');
            $limit = min($request->input('limit', 20), 50);

            // Check if Facebook API is configured
            $apiStatus = $this->facebookService->getConfigStatus();
            
            if (!$apiStatus['fully_configured']) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Facebook API not configured. Please configure your Facebook API credentials to search real posts.',
                    'api_status' => $apiStatus,
                    'note' => 'Currently showing mock data'
                ], 200);
            }

            $data = $this->facebookService->searchCryptoPosts($query, $limit);

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'api_status' => $apiStatus
            ]);

        } catch (\Exception $e) {
            Log::error('Facebook search error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search Facebook posts: ' . $e->getMessage(),
                'api_status' => $this->facebookService->getConfigStatus()
            ], 500);
        }
    }

    /**
     * Check Facebook API configuration status
     */
    public function checkApiStatus()
    {
        try {
            $apiStatus = $this->facebookService->getConfigStatus();
            
            return response()->json([
                'status' => 'success',
                'api_status' => $apiStatus,
                'message' => $apiStatus['fully_configured'] 
                    ? 'Facebook API is properly configured' 
                    : 'Facebook API is not configured. Please check your credentials.'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Facebook API status check error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to check API status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for the dashboard
     */
    private function getStats()
    {
        return Cache::remember('facebook_stats', 300, function () {
            return [
                'total_groups' => FacebookGroup::active()->count(),
                'total_users' => FacebookUser::count(),
                'total_posts' => FacebookPost::visible()->count(),
                'total_comments' => FacebookComment::visible()->count(),
                'open_groups' => FacebookGroup::active()->open()->count(),
                'verified_users' => FacebookUser::verified()->count(),
                'recent_posts' => FacebookPost::visible()
                    ->with(['group', 'author'])
                    ->orderBy('posted_at', 'desc')
                    ->take(5)
                    ->get()
            ];
        });
    }

    /**
     * Get statistics for a specific coin
     */
    private function getCoinStats($coin)
    {
        return Cache::remember("facebook_coin_stats_{$coin}", 300, function () use ($coin) {
            $posts = FacebookPost::visible()
                ->where(function ($query) use ($coin) {
                    $query->where('message', 'like', "%{$coin}%")
                          ->orWhere('message', 'like', "%#" . strtoupper($coin) . "%")
                          ->orWhere('message', 'like', "%" . ucfirst($coin) . "%");
                });

            return [
                'total_posts' => $posts->count(),
                'total_engagement' => $posts->sum('likes_count') + $posts->sum('comments_count') + $posts->sum('shares_count'),
                'avg_likes' => $posts->avg('likes_count'),
                'avg_comments' => $posts->avg('comments_count'),
                'avg_shares' => $posts->avg('shares_count'),
                'groups_count' => $posts->distinct('group_id')->count(),
                'users_count' => $posts->distinct('author_id')->count()
            ];
        });
    }

    /**
     * Store Facebook data in database
     */
    private function storeFacebookData($posts)
    {
        try {
            foreach ($posts as $postData) {
                // Store or update group
                $group = FacebookGroup::updateOrCreate(
                    ['group_id' => $postData['group']['id']],
                    [
                        'name' => $postData['group']['name'],
                        'privacy' => $postData['group']['privacy'],
                        'member_count' => $postData['group']['member_count'],
                        'is_active' => true,
                        'last_updated' => now()
                    ]
                );

                // Store or update user
                $user = FacebookUser::updateOrCreate(
                    ['user_id' => $postData['author']['id']],
                    [
                        'name' => $postData['author']['name'],
                        'profile_picture_url' => $postData['author']['profile_picture'],
                        'last_active' => now()
                    ]
                );

                // Store or update post
                FacebookPost::updateOrCreate(
                    ['post_id' => $postData['id']],
                    [
                        'group_id' => $group->group_id,
                        'author_id' => $user->user_id,
                        'message' => $postData['message'],
                        'type' => $postData['type'],
                        'attachments' => $postData['attachments'],
                        'likes_count' => $postData['likes_count'],
                        'comments_count' => $postData['comments_count'],
                        'shares_count' => $postData['shares_count'],
                        'reactions' => $postData['reactions'],
                        'posted_at' => $postData['created_time'],
                        'is_visible' => true
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error('Failed to store Facebook data: ' . $e->getMessage());
        }
    }

    /**
     * Truncate message for display
     */
    private function truncateMessage($message, $length = 100)
    {
        if (strlen($message) <= $length) {
            return $message;
        }
        
        return substr($message, 0, $length) . '...';
    }
} 