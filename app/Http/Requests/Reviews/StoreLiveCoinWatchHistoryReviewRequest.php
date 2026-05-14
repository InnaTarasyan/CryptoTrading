<?php

namespace App\Http\Requests\Reviews;

use App\Http\Requests\Concerns\AnonymousReviewRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreLiveCoinWatchHistoryReviewRequest extends FormRequest
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
        return $this->reviewerCoreRules();
    }
}
