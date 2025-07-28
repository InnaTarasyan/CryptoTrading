<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Atymic\Twitter\Facade\Twitter;
use Atymic\Twitter\Twitter as TwitterContract;
use Illuminate\Http\JsonResponse;


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

//        $params = [
//            'place.fields' => 'country,name',
//            'tweet.fields' => 'author_id,geo',
//            'expansions' => 'author_id,in_reply_to_user_id',
//            TwitterContract::KEY_RESPONSE_FORMAT => TwitterContract::RESPONSE_FORMAT_JSON,
//        ];
//
//        return JsonResponse::fromJsonString(Twitter::userTweets($userId, $params));

        $tweets = Twitter::userTweets($userId, $params);

        // Process the retrieved tweets
        foreach ($tweets as $tweet) {
            dump($tweet);
            echo $tweet->text . "\n";
        }
    }
}
