<?php

namespace App\Http\Requests\Reviews;

use App\Http\Requests\Concerns\AnonymousReviewRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreMarketsCoingeckoReviewRequest extends FormRequest
{
    use AnonymousReviewRules;

    public function authorize(): bool
    {
        return Gate::allows('submitPublicMarketReview');
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return array_merge($this->reviewerCoreRules(), [
            'country' => 'nullable|string|max:255',
            'experience_level' => 'nullable|string|max:255',
            'pros' => 'nullable|string',
            'cons' => 'nullable|string',
            'recommend' => 'nullable|in:0,1,1,0,true,false',
        ]);
    }
}
