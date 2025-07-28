<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Atymic\Twitter\Facade\Twitter;


class LoadUserTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-user-tweets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads user tweets according to userId';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = config('twitter.user_id');

        $params = [
            'count' => 2,
            'exclude_replies' => true
        ];

        $tweets = Twitter::userTweets($userId, $params);

        // Process the retrieved tweets
        foreach ($tweets as $tweet) {
            dump($tweet);
            echo $tweet->text . "\n";
        }
    }
}
