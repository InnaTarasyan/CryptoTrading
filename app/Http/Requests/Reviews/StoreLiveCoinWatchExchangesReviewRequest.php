<?php

namespace App\Http\Requests\Reviews;

use App\Http\Requests\Concerns\AnonymousReviewRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreLiveCoinWatchExchangesReviewRequest extends FormRequest
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
            'exchange_code' => 'required|string|max:255',
        ], $this->reviewerCoreRules(), $this->reviewerExtendedRules());
    }
}
