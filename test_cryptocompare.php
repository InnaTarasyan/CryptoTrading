<?php

require_once 'vendor/autoload.php';

use App\Library\Services\CryptoCompareService;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test the CryptoCompare service
$service = new CryptoCompareService();

echo "Testing CryptoCompare API...\n";

try {
    // Test ping
    echo "Testing ping...\n";
    $service->ping();
    
    // Test single market data
    echo "Testing markets...\n";
    $service->handleSingle();
    
    echo "Tests completed successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 