<?php

namespace App\Listeners;

use App\Events\PublicReviewSubmitted;
use Illuminate\Support\Facades\Log;

class LogPublicReviewSubmission
{
    public function handle(PublicReviewSubmitted $event): void
    {
        Log::info('public_review.submitted', [
            'review_type' => get_class($event->review),
            'review_id' => $event->review->getKey(),
        ]);
    }
}
