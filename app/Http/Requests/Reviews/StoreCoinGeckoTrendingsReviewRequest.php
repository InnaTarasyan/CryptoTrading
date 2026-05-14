<?php

namespace App\Http\Requests\Reviews;

use App\Http\Requests\Concerns\AnonymousReviewRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreCoinGeckoTrendingsReviewRequest extends FormRequest
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
        return array_merge([
            'trending_code' => 'required|string|max:255',
        ], $this->reviewerCoreRules(), [
            'country' => 'nullable|string|max:255',
            'experience_level' => 'nullable|string|max:255',
            'pros' => 'nullable|string',
            'cons' => 'nullable|string',
            'recommend' => 'nullable|in:0,1,true,false',
        ]);
    }
}
