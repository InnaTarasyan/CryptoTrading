<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FacebookPost;
use App\Models\FacebookGroup;
use App\Models\FacebookUser;
use App\Services\FacebookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FacebookApiController extends Controller
{
    protected $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    /**
     * Get Facebook posts about cryptocurrencies
     */
    public function posts(Request $request)
    {
        try {
            $query = $request->input('search', 'bitcoin');
            $limit = min($request->get('per_page', 50), 100);
            $coin = $request->input('coin', $query);

            // Use Facebook service to fetch real data
            $facebookData = $this->facebookService->searchCryptoPosts($coin, $limit);

            if ($facebookData['status'] === 'success') {
                // Store fetched data in database for future use
                $this->storeFacebookPosts($facebookData['data']);

                return response()->json([
                    'status' => 'success',
                    'data' => $facebookData['data'],
                    'pagination' => [
                        'current_page' => 1,
                        'last_page' => 1,
                        'per_page' => $limit,
                        'total' => $facebookData['total']
                    ],
                    'api_status' => $this->facebookService->getConfigStatus(),
                    'note' => $facebookData['note'] ?? null
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch Facebook data'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Facebook API posts error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch Facebook posts: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Facebook groups related to cryptocurrencies
     */
    public function groups(Request $request)
    {
        try {
            $query = $request->input('search', 'cryptocurrency');
            $limit = min($request->get('per_page', 50), 100);

            // Use Facebook service to fetch real data
            $facebookData = $this->facebookService->searchCryptoGroups($query, $limit);

            if ($facebookData['status'] === 'success') {
                // Store fetched groups in database for future use
                $this->storeFacebookGroups($facebookData['data']);

                return response()->json([
                    'status' => 'success',
                    'data' => $facebookData['data'],
                    'pagination' => [
                        'current_page' => 1,
                        'last_page' => 1,
                        'per_page' => $limit,
                        'total' => $facebookData['total']
                    ],
                    'api_status' => $this->facebookService->getConfigStatus(),
                    'note' => $facebookData['note'] ?? null
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch Facebook groups'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Facebook API groups error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch Facebook groups: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Facebook users who post about cryptocurrencies
     */
    public function users(Request $request)
    {
        try {
            // For now, we'll get users from our database
            // In the future, we can extend this to fetch from Facebook API
            $query = FacebookUser::withCount(['posts' => function ($query) {
                $query->visible();
            }]);

            if ($request->filled('search')) {
                $query->search($request->input('search'));
            }

            if ($request->filled('verified')) {
                $query->verified();
            }

            $perPage = min($request->get('per_page', 50), 100);
            $data = $query->orderBy('followers_count', 'desc')->paginate($perPage);

            $users = $data->items();
            $formattedUsers = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'user_id' => $user->user_id,
                    'profile' => [
                        'name' => $user->name,
                        'username' => $user->username,
                        'bio' => $user->bio,
                        'location' => $user->location,
                        'profile_picture' => $user->profile_picture_url
                    ],
                    'verification' => [
                        'is_verified' => $user->is_verified,
                        'display_name' => $user->display_name
                    ],
                    'stats' => [
                        'followers_count' => $user->followers_count,
                        'following_count' => $user->following_count,
                        'posts_count' => $user->posts_count
                    ],
                    'interests' => $user->interests,
                    'activity' => [
                        'last_active' => $user->last_active ? $user->last_active->toISOString() : null
                    ],
                    'timestamps' => [
                        'created_at' => $user->created_at->toISOString(),
                        'updated_at' => $user->updated_at->toISOString()
                    ]
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $formattedUsers,
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total()
                ],
                'api_status' => $this->facebookService->getConfigStatus()
            ]);

        } catch (\Exception $e) {
            Log::error('Facebook API users error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch Facebook users: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics about Facebook cryptocurrency discussions
     */
    public function stats(Request $request)
    {
        try {
            $coin = $request->input('coin', 'bitcoin');
            $cacheKey = "facebook_api_stats_{$coin}";

            return Cache::remember($cacheKey, 1800, function () use ($coin) {
                // Get stats from Facebook service
                $facebookData = $this->facebookService->searchCryptoPosts($coin, 100);
                
                $totalPosts = $facebookData['total'] ?? 0;
                $posts = $facebookData['data'] ?? [];

                // Calculate engagement metrics
                $totalLikes = collect($posts)->sum('likes_count');
                $totalComments = collect($posts)->sum('comments_count');
                $totalShares = collect($posts)->sum('shares_count');

                // Get group stats
                $groupsData = $this->facebookService->searchCryptoGroups($coin, 20);
                $totalGroups = $groupsData['total'] ?? 0;

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'posts' => [
                            'total' => $totalPosts,
                            'types' => collect($posts)->groupBy('type')->map->count()
                        ],
                        'engagement' => [
                            'total_likes' => $totalLikes,
                            'total_comments' => $totalComments,
                            'total_shares' => $totalShares,
                            'total_engagement' => $totalLikes + $totalComments + $totalShares,
                            'avg_engagement_per_post' => $totalPosts > 0 ? round(($totalLikes + $totalComments + $totalShares) / $totalPosts, 2) : 0
                        ],
                        'groups' => [
                            'total' => $totalGroups,
                            'open_groups' => $totalGroups, // Assuming most crypto groups are open
                            'top_groups' => collect($groupsData['data'] ?? [])->take(5)->map(function ($group) {
                                return [
                                    'name' => $group['name'],
                                    'member_count' => $group['member_count'],
                                    'privacy' => $group['privacy']
                                ];
                            })
                        ],
                        'users' => [
                            'total' => FacebookUser::count(),
                            'verified' => FacebookUser::verified()->count(),
                            'top_posters' => FacebookUser::withCount(['posts' => function ($query) {
                                $query->visible();
                            }])
                            ->orderBy('posts_count', 'desc')
                            ->take(5)
                            ->get()
                            ->map(function ($user) {
                                return [
                                    'name' => $user->name,
                                    'username' => $user->username,
                                    'posts_count' => $user->posts_count,
                                    'followers_count' => $user->followers_count
                                ];
                            })
                        ],
                        'timeline' => [
                            'recent_activity' => collect($posts)->take(10)->map(function ($post) {
                                return [
                                    'id' => $post['id'],
                                    'message' => $this->truncateMessage($post['message'], 80),
                                    'group' => $post['group']['name'] ?? 'Unknown',
                                    'author' => $post['author']['name'] ?? 'Unknown',
                                    'posted_at' => $post['created_time'],
                                    'engagement' => ($post['likes_count'] ?? 0) + ($post['comments_count'] ?? 0) + ($post['shares_count'] ?? 0)
                                ];
                            })
                        ]
                    ],
                    'api_status' => $this->facebookService->getConfigStatus(),
                    'note' => $facebookData['note'] ?? null
                ]);
            });

        } catch (\Exception $e) {
            Log::error('Facebook API stats error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch Facebook statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search across all Facebook data
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('q');
            $type = $request->input('type', 'all');
            $limit = min($request->input('limit', 20), 50);

            if (empty($query)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Search query is required'
                ], 400);
            }

            $results = [];

            if ($type === 'all' || $type === 'posts') {
                $postsData = $this->facebookService->searchCryptoPosts($query, $limit);
                if ($postsData['status'] === 'success') {
                    $results['posts'] = collect($postsData['data'])->map(function ($post) {
                        return [
                            'type' => 'post',
                            'id' => $post['id'],
                            'content' => $this->truncateMessage($post['message'], 120),
                            'group' => $post['group']['name'] ?? 'Unknown',
                            'author' => $post['author']['name'] ?? 'Unknown',
                            'posted_at' => $post['created_time'],
                            'engagement' => ($post['likes_count'] ?? 0) + ($post['comments_count'] ?? 0) + ($post['shares_count'] ?? 0)
                        ];
                    });
                }
            }

            if ($type === 'all' || $type === 'groups') {
                $groupsData = $this->facebookService->searchCryptoGroups($query, $limit);
                if ($groupsData['status'] === 'success') {
                    $results['groups'] = collect($groupsData['data'])->map(function ($group) {
                        return [
                            'type' => 'group',
                            'id' => $group['id'],
                            'name' => $group['name'],
                            'description' => $group['description'] ? $this->truncateMessage($group['description'], 120) : null,
                            'member_count' => $group['member_count'],
                            'privacy' => $group['privacy']
                        ];
                    });
                }
            }

            if ($type === 'all' || $type === 'users') {
                $users = FacebookUser::search($query)->take($limit)->get();
                $results['users'] = $users->map(function ($user) {
                    return [
                        'type' => 'user',
                        'id' => $user->user_id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'bio' => $user->bio ? $this->truncateMessage($user->bio, 120) : null,
                        'is_verified' => $user->is_verified,
                        'followers_count' => $user->followers_count
                    ];
                });
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'query' => $query,
                    'results' => $results,
                    'total_results' => array_sum(array_map('count', $results))
                ],
                'api_status' => $this->facebookService->getConfigStatus()
            ]);

        } catch (\Exception $e) {
            Log::error('Facebook API search error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search Facebook data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store Facebook posts in database
     */
    protected function storeFacebookPosts($posts)
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
            Log::error('Failed to store Facebook posts: ' . $e->getMessage());
        }
    }

    /**
     * Store Facebook groups in database
     */
    protected function storeFacebookGroups($groups)
    {
        try {
            foreach ($groups as $groupData) {
                FacebookGroup::updateOrCreate(
                    ['group_id' => $groupData['id']],
                    [
                        'name' => $groupData['name'],
                        'description' => $groupData['description'],
                        'privacy' => $groupData['privacy'],
                        'member_count' => $groupData['member_count'],
                        'icon_url' => $groupData['icon'],
                        'cover_photo_url' => $groupData['cover'],
                        'is_active' => true,
                        'last_updated' => now()
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error('Failed to store Facebook groups: ' . $e->getMessage());
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