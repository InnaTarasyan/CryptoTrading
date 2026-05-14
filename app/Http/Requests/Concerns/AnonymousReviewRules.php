<?php

namespace App\Http\Requests\Concerns;

trait AnonymousReviewRules
{
    /**
     * @return array<string, mixed>
     */
    protected function reviewerCoreRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function reviewerExtendedRules(): array
    {
        return [
            'country' => 'nullable|string|max:255',
            'experience_level' => 'nullable|string|max:255',
            'pros' => 'nullable|string',
            'cons' => 'nullable|string',
            'recommend' => 'nullable|boolean',
        ];
    }
}
