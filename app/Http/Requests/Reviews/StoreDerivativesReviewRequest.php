<?php

namespace App\Http\Requests\Reviews;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreDerivativesReviewRequest extends FormRequest
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
        return array_merge([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|max:2000',
            'country' => 'nullable|string|max:100',
            'experience_level' => 'nullable|string|max:100',
            'pros' => 'nullable|string|max:1000',
            'cons' => 'nullable|string|max:1000',
            'recommend' => 'nullable|boolean',
        ]);
    }
}
