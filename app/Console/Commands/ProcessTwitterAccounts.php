<?php

namespace App\Console\Commands;

use App\Models\TwitterAccount;
use App\Models\TwitterMessages;
use App\Models\TwitterMeta;
use App\Models\TwitterUsers;
use Illuminate\Console\Command;
use Atymic\Twitter\Facade\Twitter;
use Atymic\Twitter\Twitter as TwitterContract;
use Illuminate\Support\Facades\Log;

class ProcessTwitterAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-twitter-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads user tweets according to userId from twitter_accounts table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (TwitterAccount::where('processed', null)->get() as $account) {
            $userId = $account->account;

            try {
                $params = [
                    'place.fields' => 'country,name',
                    'tweet.fields' => 'author_id,geo',
                    'expansions' => 'author_id,in_reply_to_user_id',
                    TwitterContract::KEY_RESPONSE_FORMAT => TwitterContract::RESPONSE_FORMAT_ARRAY,
                ];

                $response = Twitter::userTweets($userId, $params);

                TwitterUsers::query()->where('timeline', $userId)->delete();

                foreach ($response['includes']['users'] as $datum) {
                    TwitterUsers::create([
                        'user_id'  => $datum['id'],
                        'name'     => $datum['name'],
                        'username' => $datum['username'],
                        'timeline' => $userId,
                    ]);
                }

                TwitterMessages::query()->where('timeline', $userId)->delete();

                foreach ($response['data'] as $datum) {
                    TwitterMessages::create([
                        'tweet_id' => $datum['id'],
                        'edit_history_tweet_ids' => json_encode($datum['edit_history_tweet_ids']),
                        'text' => $datum['text'],
                        'author_id' => $datum['author_id'],
                        'timeline'  => $userId,
                    ]);
                }

                TwitterMeta::query()->where('timeline', $userId)->delete();

                TwitterMeta::create([
                    'result_count' => $response['meta']['result_count'],
                    'newest_id'    => $response['meta']['newest_id'],
                    'oldest_id'    => $response['meta']['oldest_id'],
                    'timeline'     => $userId,
                ]);


                $account->processed = 1;
                $account->save();

                Log::channel('crabler')->info('Twitter Accounts '.$userId);
            } catch (\Exception $exception) {
                continue;
            }

        }
    }
}
