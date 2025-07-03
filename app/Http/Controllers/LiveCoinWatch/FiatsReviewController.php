<?php

namespace App\Http\Controllers\LiveCoinWatch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveCoinWatch\FiatsReview;

class FiatsReviewController extends Controller
{
    public function index(Request $request)
    {
        $fiatCode = $request->query('fiat_code');
        $query = FiatsReview::query();
        if ($fiatCode) {
            $query->where('fiat_code', $fiatCode);
        }
        $reviews = $query->orderBy('created_at', 'desc')->get();
        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fiat_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
            'country' => 'nullable|string|max:255',
            'experience_level' => 'nullable|string|max:255',
            'pros' => 'nullable|string',
            'cons' => 'nullable|string',
            'recommend' => 'nullable|boolean',
        ]);
        $review = FiatsReview::create($validated);
        return response()->json(['success' => true, 'review' => $review]);
    }
} 