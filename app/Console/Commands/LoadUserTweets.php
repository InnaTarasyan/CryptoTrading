<?php

namespace App\Console\Commands;

use App\Models\TweeterMessages;
use App\Models\TwitterMeta;
use App\Models\TwitterUsers;
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
        $userIds = [
            config('twitter.bitcoin_id'),
            config('twitter.eth_id'),
            config('twitter.coin_market_cap'),
            config('twitter.tesla'),
            config('twitter.coinbase'),
            config('twitter.litecoin'),
            config('twitter.btctn'),
            config('twitter.bitcoin_magazine'),
            config('twitter.shib'),
        ];

        $userId = $userIds[array_rand($userIds, 1)];

        $params = [
            'place.fields' => 'country,name',
            'tweet.fields' => 'author_id,geo',
            'expansions' => 'author_id,in_reply_to_user_id',
            TwitterContract::KEY_RESPONSE_FORMAT => TwitterContract::RESPONSE_FORMAT_ARRAY,
        ];

        dump($params);

        $response = Twitter::userTweets($userId, $params);

        dump($response);

        foreach ($response['includes']['users'] as $datum) {
            TwitterUsers::updateOrCreate([
                'user_id' => $datum->id,
            ], [
                'user_id'  => $datum->id,
                'name'     => $datum->name,
                'username' => $datum->username,
            ]);
        }


        foreach ($response['data'] as $datum) {
            TweeterMessages::updateOrCreate([
                'tweet_id' => $datum['id'],
            ], [
                'tweet_id' => $datum['id'],
                'edit_history_tweet_ids' => json_encode($datum['edit_history_tweet_ids']),
                'text' => $datum['text'],
                'author_id' => $datum['author_id'],
            ]);
        }

        foreach ($response['meta'] as $datum) {
            TwitterMeta::updateOrCreate([
                'result_count' => $datum['result_count'],
                'newest_id'    => $datum['newest_id'],
                'oldest_id'    => $datum['oldest_id'],
            ], [
                'result_count' => $datum['result_count'],
                'newest_id'    => $datum['newest_id'],
                'oldest_id'    => $datum['oldest_id'],
            ]);
        }
    }
}
