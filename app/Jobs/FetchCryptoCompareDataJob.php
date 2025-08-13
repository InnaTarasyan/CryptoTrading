<?php

namespace App\Jobs;

use App\Library\Services\CryptoCompareService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchCryptoCompareDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $single;

    /**
     * Create a new job instance.
     */
    public function __construct(bool $single = false)
    {
        $this->single = $single;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::channel('crabler')->info('Starting CryptoCompare data fetch job', [
                'single' => $this->single
            ]);

            $service = new CryptoCompareService();

            if ($this->single) {
                $service->handleSingle();
                Log::channel('crabler')->info('CryptoCompare single data fetch completed');
            } else {
                $service->handle();
                Log::channel('crabler')->info('CryptoCompare full data fetch completed');
            }
        } catch (\Exception $e) {
            Log::channel('crabler')->error('CryptoCompare data fetch job failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::channel('crabler')->error('CryptoCompare data fetch job failed permanently', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
} 