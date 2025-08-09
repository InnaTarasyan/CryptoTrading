<?php

namespace App\Console\Commands;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\Settings\Logger as MadelineLogger;
use danog\MadelineProto\Exception as MadelineException;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\TelegramMessages;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class Telegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:handle {--force : Force restart the session} {--debug : Enable debug mode} {--setup-webhook : Setup webhook mode for real-time processing} {--bot : Use bot authentication instead of user authentication}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get messages from telegram channels using user or bot authentication';

    /**
     * MadelineProto API instance
     *
     * @var API
     */
    private $MadelineProto;

    /**
     * Session file path
     *
     * @var string
     */
    private $sessionPath = 'telegram.madeline';

    /**
     * Authentication mode (bot or user)
     *
     * @var string
     */
    private $authMode = 'user';

    /**
     * Maximum number of messages to fetch per channel
     *
     * @var int
     */
    private $maxMessagesPerChannel = 1000;

    /**
     * Rate limiting delay between API calls (seconds)
     *
     * @var int
     */
    private $rateLimitDelay = 2;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Determine authentication mode
            $this->authMode = $this->option('bot') ? 'bot' : 'user';
            $this->sessionPath = $this->authMode . '.madeline';
            
            $this->info("Starting Telegram message fetcher with {$this->authMode} authentication...");
            
            // Validate configuration
            if (!$this->validateConfiguration()) {
                return Command::FAILURE;
            }

            // Initialize MadelineProto with proper settings
            if (!$this->initializeMadelineProto()) {
                return Command::FAILURE;
            }

            // Perform authentication based on mode
            if (!$this->performAuthentication()) {
                return Command::FAILURE;
            }

            // Verify authentication status
            if (!$this->verifyAuthenticationStatus()) {
                return Command::FAILURE;
            }

            // Check if we need to setup webhook mode
            if ($this->option('setup-webhook')) {
                if ($this->authMode === 'bot') {
                    $this->info('Setting up webhook mode for bot...');
                    $this->displayWebhookInstructions();
                } else {
                    $this->info('Webhook mode is not needed for user authentication.');
                    $this->info('User accounts have full access to channel messages directly.');
                }
                return Command::SUCCESS;
            }

            // Process channels
            $this->processChannels();

            $this->info('Telegram message fetching completed successfully!');
            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->error('Fatal error: ' . $e->getMessage());
            Log::channel('crabler')->error('Telegram command fatal error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }

    /**
     * Validate required configuration based on authentication mode
     *
     * @return bool
     */
    private function validateConfiguration(): bool
    {
        $this->info('Validating configuration...');

        $requiredConfigs = [
            'telegram.api_id' => config('telegram.api_id'),
            'telegram.api_hash' => config('telegram.api_hash'),
        ];

        // Bot mode requires bot token
        if ($this->authMode === 'bot') {
            $requiredConfigs['telegram.token'] = config('telegram.token');
        }

        foreach ($requiredConfigs as $config => $value) {
            if (empty($value)) {
                $this->error("Missing required configuration for {$this->authMode} mode: {$config}");
                return false;
            }
        }

        $channels = config('telegram.channels', []);
        if (empty($channels)) {
            $this->error('No channels configured in telegram.channels');
            return false;
        }

        $this->info("Configuration validation passed for {$this->authMode} mode.");
        return true;
    }

    /**
     * Initialize MadelineProto with proper settings
     *
     * @return bool
     */
    private function initializeMadelineProto(): bool
    {
        try {
            $this->info('Initializing MadelineProto...');

            // Check if we need to force restart
            if ($this->option('force') && file_exists($this->sessionPath)) {
                $this->warn('Force restart requested, removing existing session...');
                $this->removeSessionFiles();
            }

            // Configure MadelineProto settings
            $settings = new Settings;
            
            // App info settings
            $appInfo = new AppInfo;
            $appInfo->setApiId((int) config('telegram.api_id'));
            $appInfo->setApiHash(config('telegram.api_hash'));
            $settings->setAppInfo($appInfo);

            // Logger settings
            $logger = new MadelineLogger;
            if ($this->option('debug')) {
                $logger->setLevel(\danog\MadelineProto\Logger::VERBOSE);
            } else {
                $logger->setLevel(\danog\MadelineProto\Logger::WARNING);
            }
            $settings->setLogger($logger);

            // Initialize API
            $this->MadelineProto = new API($this->sessionPath, $settings);

            $this->info('MadelineProto initialized successfully.');
            return true;

        } catch (Exception $e) {
            $this->error('Failed to initialize MadelineProto: ' . $e->getMessage());
            Log::channel('crabler')->error('MadelineProto initialization failed', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Perform authentication based on the selected mode
     *
     * @return bool
     */
    private function performAuthentication(): bool
    {
        if ($this->authMode === 'bot') {
            return $this->performBotAuthentication();
        } else {
            return $this->performUserAuthentication();
        }
    }

    /**
     * Perform bot authentication
     *
     * @return bool
     */
    private function performBotAuthentication(): bool
    {
        try {
            $this->info('Performing bot authentication...');

            $token = config('telegram.token');
            
            // Check if session already exists and is valid
            if ($this->isSessionValid()) {
                $this->info('Using existing bot session...');
                return true;
            }
            
            // Perform bot login
            $this->MadelineProto->botLogin($token);

            $this->info('Bot authentication successful!');
            Log::channel('crabler')->info('Bot successfully authenticated');

            return true;

        } catch (Exception $e) {
            $this->error('Bot authentication failed: ' . $e->getMessage());
            Log::channel('crabler')->error('Bot authentication failed', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Perform user authentication
     *
     * @return bool
     */
    private function performUserAuthentication(): bool
    {
        try {
            $this->info('Performing user authentication...');
            
            // Check if session already exists and is valid
            if ($this->isSessionValid()) {
                $this->info('Using existing user session...');
                return true;
            }
            
            // Check if running in non-interactive mode
            if ($this->option('no-interaction') || !$this->input->isInteractive()) {
                $this->error('User authentication requires interactive mode for first-time setup.');
                $this->info('Please run the command interactively first, or use --bot flag for background execution.');
                return false;
            }
            
            // Start the login process - this will prompt for phone number and code
            $this->MadelineProto->start();
            
            $this->info('User authentication successful!');
            Log::channel('crabler')->info('User successfully authenticated');

            return true;

        } catch (Exception $e) {
            $this->error('User authentication failed: ' . $e->getMessage());
            Log::channel('crabler')->error('User authentication failed', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Check if existing session is valid
     *
     * @return bool
     */
    private function isSessionValid(): bool
    {
        try {
            if (!file_exists($this->sessionPath) || $this->option('force')) {
                return false;
            }

            // Try to get self info to validate session
            $self = $this->MadelineProto->getSelf();
            return isset($self['id']);

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Verify authentication status
     *
     * @return bool
     */
    private function verifyAuthenticationStatus(): bool
    {
        try {
            $this->info('Verifying authentication status...');

            $self = $this->MadelineProto->getSelf();

            if ($this->authMode === 'bot') {
                if (!isset($self['bot']) || !$self['bot']) {
                    $this->error('Expected bot account but got user account!');
                    return false;
                }
                $username = $self['username'] ?? 'Unknown';
                $this->info("Bot verified successfully: @{$username}");
            } else {
                $username = $self['username'] ?? 'Unknown';
                $firstName = $self['first_name'] ?? '';
                $lastName = $self['last_name'] ?? '';
                $fullName = trim($firstName . ' ' . $lastName);
                
                $this->info("User verified successfully:");
                $this->line("  Name: {$fullName}");
                $this->line("  Username: @{$username}");
                $this->line("  ID: {$self['id']}");
            }
            
            Log::channel('crabler')->info("{$this->authMode} verified", $self);
            return true;

        } catch (Exception $e) {
            $this->error("Failed to verify {$this->authMode} status: " . $e->getMessage());
            Log::channel('crabler')->error("{$this->authMode} verification failed", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Process all configured channels
     *
     * @return void
     */
    private function processChannels(): void
    {
        $this->info('Starting channel processing...');

        // Clear existing messages
        TelegramMessages::truncate();
        $this->info('Cleared existing messages from database.');
        Log::channel('crabler')->info('Telegram messages table truncated');

        $channels = config('telegram.channels', []);
        $totalChannels = count($channels);
        
        $this->info("Processing {$totalChannels} channels...");

        foreach ($channels as $index => $channel) {
            $channelNum = $index + 1;
            $this->info("Processing channel {$channelNum}/{$totalChannels}: {$channel['name']}");
            
            try {
                $messageCount = $this->processChannel($channel);
                $this->info("✓ Channel {$channel['name']}: {$messageCount} messages processed");
                
            } catch (Exception $e) {
                $this->error("✗ Failed to process channel {$channel['name']}: " . $e->getMessage());
                Log::channel('crabler')->error('Channel processing failed', [
                    'channel' => $channel,
                    'error' => $e->getMessage()
                ]);
            }

            // Rate limiting between channels
            if ($channelNum < $totalChannels) {
                $this->info('Rate limiting...');
                sleep($this->rateLimitDelay);
            }
        }

        $this->info('Channel processing completed.');
    }

    /**
     * Process a single channel with appropriate method based on auth mode
     *
     * @param array $channel
     * @return int Number of messages processed
     */
    private function processChannel(array $channel): int
    {
        if ($this->authMode === 'bot') {
            return $this->processChannelAsBot($channel);
        } else {
            return $this->processChannelAsUser($channel);
        }
    }

    /**
     * Process channel as bot (with limitations)
     *
     * @param array $channel
     * @return int
     */
    private function processChannelAsBot(array $channel): int
    {
        $messagesProcessed = 0;
        
        try {
            $this->info("  Attempting to access channel: {$channel['name']} (bot mode)");
            
            // Try to get channel info to verify access
            $channelInfo = $this->getChannelInfo($channel['name']);
            
            if (!$channelInfo) {
                $this->warn("  Cannot access channel {$channel['name']} - Bot may not be a member or channel may not exist");
                return 0;
            }
            
            $this->info("  Channel found: {$channelInfo['title']} (ID: {$channelInfo['id']})");
            
            // Check if bot has admin access
            if ($this->isBotChannelAdmin($channelInfo)) {
                $messagesProcessed = $this->getMessagesAsAdmin($channelInfo, $channel);
            } else {
                $this->warn("  Bot is not admin in this channel. Limited access.");
                $this->info("  To get full access: add bot as admin OR use user authentication");
                // Create a test entry to show the system is working
                $messagesProcessed = $this->createTestEntry($channel);
            }
            
        } catch (Exception $e) {
            $this->warn("  Channel processing failed: " . $e->getMessage());
            Log::channel('crabler')->warning('Bot channel processing failed', [
                'channel' => $channel['name'],
                'error' => $e->getMessage()
            ]);
        }

        return $messagesProcessed;
    }

    /**
     * Process channel as user (full access)
     *
     * @param array $channel
     * @return int
     */
    private function processChannelAsUser(array $channel): int
    {
        $messagesProcessed = 0;
        
        try {
            $this->info("  Accessing channel: {$channel['name']} (user mode)");
            
            // With user authentication, we can directly access channels
            $offsetId = 0;
            $batchSize = 100;
            $batchCount = 0;
            $maxBatches = ceil($this->maxMessagesPerChannel / $batchSize);

            do {
                try {
                    $batchCount++;
                    $this->info("  Fetching batch {$batchCount}/{$maxBatches} (offset: {$offsetId})");

                    $messagesResponse = $this->MadelineProto->messages->getHistory([
                        'peer' => $channel['name'],
                        'offset_id' => $offsetId,
                        'offset_date' => 0,
                        'add_offset' => 0,
                        'limit' => $batchSize,
                        'max_id' => 0,
                        'min_id' => 0,
                        'hash' => 0
                    ]);

                    if (!isset($messagesResponse['messages']) || empty($messagesResponse['messages'])) {
                        $this->info('  No more messages found.');
                        break;
                    }

                    $batchMessages = $messagesResponse['messages'];
                    $processedInBatch = $this->processBatchMessages($batchMessages, $channel);
                    $messagesProcessed += $processedInBatch;

                    $this->info("  Processed {$processedInBatch} messages in batch {$batchCount}");

                    // Update offset for next batch
                    $lastMessage = end($batchMessages);
                    if (!$lastMessage || !isset($lastMessage['id'])) {
                        break;
                    }
                    $offsetId = $lastMessage['id'];

                    // Rate limiting between batches
                    sleep($this->rateLimitDelay);

                } catch (Exception $e) {
                    $this->warn("  Batch {$batchCount} failed: " . $e->getMessage());
                    Log::channel('crabler')->warning('User batch processing failed', [
                        'channel' => $channel['name'],
                        'batch' => $batchCount,
                        'error' => $e->getMessage()
                    ]);
                    break;
                }

            } while ($batchCount < $maxBatches && count($batchMessages) === $batchSize);
            
        } catch (Exception $e) {
            $this->warn("  Channel processing failed: " . $e->getMessage());
            Log::channel('crabler')->warning('User channel processing failed', [
                'channel' => $channel['name'],
                'error' => $e->getMessage()
            ]);
        }

        return $messagesProcessed;
    }

    /**
     * Process a batch of messages
     *
     * @param array $messages
     * @param array $channel
     * @return int Number of messages processed
     */
    private function processBatchMessages(array $messages, array $channel): int
    {
        $processed = 0;

        foreach ($messages as $message) {
            try {
                if ($this->processMessage($message, $channel)) {
                    $processed++;
                }
            } catch (Exception $e) {
                Log::channel('crabler')->warning('Single message processing failed', [
                    'message_id' => $message['id'] ?? 'unknown',
                    'channel' => $channel['name'],
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $processed;
    }

    /**
     * Process a single message
     *
     * @param array $message
     * @param array $channel
     * @return bool Whether the message was processed successfully
     */
    private function processMessage(array $message, array $channel): bool
    {
        if (!isset($message['message']) || empty(trim($message['message']))) {
            return false;
        }

        try {
            // Extract URLs from message
            $urls = $this->extractUrls($message['message']);
            
            // Prepare message data
            $data = [
                'title' => $this->extractTitle($message['message']),
                'slug' => $channel['slug'],
                'company' => $message['post_author'] ?? null,
                'logo' => null,
                'content' => $this->formatMessageContent($message['message']),
                'apply_link' => '',
            ];

            // Process media if present
            if (isset($message['media'])) {
                $this->processMessageMedia($message['media'], $data);
            }

            // Set URL from extracted URLs or media
            if (empty($data['apply_link']) && !empty($urls)) {
                $data['apply_link'] = $urls[0];
            }

            // Create database record
            TelegramMessages::create($data);

            return true;

        } catch (Exception $e) {
            Log::channel('crabler')->error('Message processing failed', [
                'message_id' => $message['id'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Extract URLs from message text
     *
     * @param string $text
     * @return array
     */
    private function extractUrls(string $text): array
    {
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $text, $matches);
        return $matches[0] ?? [];
    }

    /**
     * Extract title from message text
     *
     * @param string $text
     * @return string
     */
    private function extractTitle(string $text): string
    {
        $firstSentence = explode('.', trim($text));
        if (!empty($firstSentence[0])) {
            return Str::limit($firstSentence[0], 100);
        }
        
        return Str::limit($text, 100);
    }

    /**
     * Format message content
     *
     * @param string $content
     * @return string
     */
    private function formatMessageContent(string $content): string
    {
        // Replace rocket emoji with line breaks and convert newlines to HTML
        $formatted = preg_replace('/\x{1F680}/u', "<br>", $content);
        return nl2br(trim($formatted), true);
    }

    /**
     * Process message media
     *
     * @param array $media
     * @param array &$data
     * @return void
     */
    private function processMessageMedia(array $media, array &$data): void
    {
        try {
            // Handle web page media
            if (isset($media['webpage'])) {
                $webpage = $media['webpage'];
                
                if (isset($webpage['url'])) {
                    $data['apply_link'] = $webpage['url'];
                }
                
                if (isset($webpage['title']) && empty($data['title'])) {
                    $data['title'] = Str::limit($webpage['title'], 100);
                }
            }

            // Handle photo media
            if (isset($media['photo'])) {
                $this->downloadMediaFile($media, $data);
            }

        } catch (Exception $e) {
            Log::channel('crabler')->warning('Media processing failed', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Download media file
     *
     * @param array $media
     * @param array &$data
     * @return void
     */
    private function downloadMediaFile(array $media, array &$data): void
    {
        try {
            $imagesDir = public_path('images_list');
            
            // Ensure directory exists
            if (!is_dir($imagesDir)) {
                mkdir($imagesDir, 0755, true);
            }

            $this->MadelineProto->downloadToDir($media, $imagesDir);
            
            if (isset($media['photo']['id'])) {
                $imagePath = $imagesDir . '/' . $media['photo']['id'] . '.jpg';
                if (file_exists($imagePath)) {
                    $data['logo'] = $imagePath;
                }
            }

        } catch (Exception $e) {
            Log::channel('crabler')->warning('Media download failed', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove session files for force restart
     *
     * @return void
     */
    private function removeSessionFiles(): void
    {
        if (is_dir($this->sessionPath)) {
            $files = glob($this->sessionPath . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            rmdir($this->sessionPath);
        }
    }

    /**
     * Get channel information
     *
     * @param string $channelName
     * @return array|null
     */
    private function getChannelInfo(string $channelName): ?array
    {
        try {
            $peer = $this->MadelineProto->getInfo($channelName);
            return $peer['Chat'] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Check if bot is admin in the channel
     *
     * @param array $channelInfo
     * @return bool
     */
    private function isBotChannelAdmin(array $channelInfo): bool
    {
        try {
            $admins = $this->MadelineProto->channels->getParticipants([
                'channel' => $channelInfo,
                'filter' => ['_' => 'channelParticipantsAdmins'],
                'offset' => 0,
                'limit' => 100,
                'hash' => 0
            ]);
            
            $botId = $this->MadelineProto->getSelf()['id'];
            
            if (isset($admins['participants'])) {
                foreach ($admins['participants'] as $participant) {
                    if (isset($participant['user_id']) && $participant['user_id'] == $botId) {
                        return true;
                    }
                }
            }
            
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get messages when bot is admin
     *
     * @param array $channelInfo
     * @param array $channel
     * @return int
     */
    private function getMessagesAsAdmin(array $channelInfo, array $channel): int
    {
        $messagesProcessed = 0;
        
        try {
            $this->info("    Bot has admin access, fetching messages...");
            
            $offsetId = 0;
            $batchSize = 100;
            $batchCount = 0;
            $maxBatches = ceil($this->maxMessagesPerChannel / $batchSize);

            do {
                try {
                    $batchCount++;
                    $this->info("    Fetching admin batch {$batchCount}/{$maxBatches} (offset: {$offsetId})");

                    $messagesResponse = $this->MadelineProto->messages->getHistory([
                        'peer' => $channelInfo,
                        'offset_id' => $offsetId,
                        'offset_date' => 0,
                        'add_offset' => 0,
                        'limit' => $batchSize,
                        'max_id' => 0,
                        'min_id' => 0,
                        'hash' => 0
                    ]);

                    if (!isset($messagesResponse['messages']) || empty($messagesResponse['messages'])) {
                        $this->info('    No more messages found.');
                        break;
                    }

                    $batchMessages = $messagesResponse['messages'];
                    $processedInBatch = $this->processBatchMessages($batchMessages, $channel);
                    $messagesProcessed += $processedInBatch;

                    $this->info("    Processed {$processedInBatch} messages in admin batch {$batchCount}");

                    $lastMessage = end($batchMessages);
                    if (!$lastMessage || !isset($lastMessage['id'])) {
                        break;
                    }
                    $offsetId = $lastMessage['id'];

                    sleep($this->rateLimitDelay);

                } catch (Exception $e) {
                    $this->warn("    Admin batch {$batchCount} failed: " . $e->getMessage());
                    break;
                }

            } while ($batchCount < $maxBatches && count($batchMessages) === $batchSize);
            
        } catch (Exception $e) {
            $this->warn("    Admin message fetching failed: " . $e->getMessage());
        }
        
        return $messagesProcessed;
    }

    /**
     * Create test entry when bot has limited access
     *
     * @param array $channel
     * @return int
     */
    private function createTestEntry(array $channel): int
    {
        try {
            $data = [
                'title' => 'Bot Limited Access - ' . $channel['name'],
                'slug' => $channel['slug'],
                'company' => 'System Notice',
                'logo' => null,
                'content' => 'Bot has limited access to this channel. For full access: 1) Add bot as admin, or 2) Use user authentication (--no-bot flag).',
                'apply_link' => '',
            ];

            TelegramMessages::create($data);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Display webhook setup instructions for bot mode
     *
     * @return void
     */
    private function displayWebhookInstructions(): void
    {
        $this->info('🔧 Webhook Setup Instructions for Bot');
        $this->info('=====================================');
        
        $botToken = config('telegram.token');
        $webhookUrl = config('app.url') . '/api/telegram/webhook';
        
        $this->info("Bot Token: {$botToken}");
        $this->info("Webhook URL: {$webhookUrl}");
        $this->info('');
        
        $this->info('📋 Setup using cURL:');
        $this->line("curl -X POST 'https://api.telegram.org/bot{$botToken}/setWebhook' \\");
        $this->line("  -d 'url={$webhookUrl}' \\");
        $this->line("  -d 'allowed_updates=[\"message\",\"channel_post\"]'");
        
        Log::channel('crabler')->info('Webhook setup instructions provided for bot', [
            'webhook_url' => $webhookUrl
        ]);
    }
}