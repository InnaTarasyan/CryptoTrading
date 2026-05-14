<?php

namespace App\Http\Requests\Reviews;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreExchangesRatesReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('submitPublicMarketReview');
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_name' => 'required|string|max:100',
            'user_email' => 'required|email|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'review_title' => 'required|string|max:150',
            'review_body' => 'required|string|max:2000',
            'exchange_symbol' => 'nullable|string|max:20',
            'exchange_name' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pros' => 'nullable|string|max:1000',
            'cons' => 'nullable|string|max:1000',
            'would_recommend' => 'required|boolean',
        ];
    }
}
