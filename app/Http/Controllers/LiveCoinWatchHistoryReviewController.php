<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveCoinWatchHistoryReview;

class LiveCoinWatchHistoryReviewController extends Controller
{
    public function index()
    {
        $reviews = LiveCoinWatchHistoryReview::orderBy('created_at', 'desc')->get();
        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);
        $review = LiveCoinWatchHistoryReview::create($validated);
        return response()->json(['success' => true, 'review' => $review]);
    }
}
