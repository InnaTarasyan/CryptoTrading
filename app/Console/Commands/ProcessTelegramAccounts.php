<?php

namespace App\Console\Commands;

use App\Models\TelegramAccount;
use App\Models\TwitterMessages;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\TelegramMessages;
use Illuminate\Support\Facades\Log;
use App\Models\LiveCoinWatch\LiveCoinHistory;

class ProcessTelegramAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-telegram-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads user telegram messages according to timeline from telegram_accounts table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $account = TelegramAccount::where('processed', null)->first();

        if(!$account) {
            return;
        }

        $MadelineProto = new \danog\MadelineProto\API('bot.madeline');

        try {
            $MadelineProto->botLogin(config('telegram.token'));

            Log::channel('crabler')->info("Bot successfully logged in!");

            $self = $MadelineProto->getSelf();

            Log::channel('crabler')->info("Bot Username: @" . $self['username']);

        } catch (\Exception $e) {
            Log::channel('crabler')->info("Error logging in bot: " . $e->getMessage());
            return 0;
        }

        $MadelineProto->start();
        $me = $MadelineProto->getSelf();

        Log::channel('crabler')->info('Telegram messages');



        $livecoinhistory = LiveCoinHistory::find($account->coin);
        $slug = strtolower($livecoinhistory->code);

        $this->processResults($me, $MadelineProto, $account, $slug);

        $account->processed = 1;
        $account->save();
    }

    protected function processResults($me, $MadelineProto, $account, $slug)
    {
        TelegramMessages::where('slug', $slug)->delete();

        $counter = 0;
        $messagesArray = [];
        if (!$me['bot']) {

            $offset_id = 0;
            $limit = 10;

            do {
                $messages_Messages = $MadelineProto->messages->getHistory([
                    'peer'        => $account->account,
                    'offset_id'   => $offset_id,
                    'offset_date' => 0,
                    'add_offset'  => 0,
                    'limit'       => $limit,
                    'max_id'      => 0,
                    'min_id'      => 0,
                    'hash'        => 0
                ]);

                //  print_r($messages_Messages);

                if(!array_key_exists('messages', $messages_Messages)) {
                    break;
                }

                foreach ($messages_Messages['messages'] as $message) {
                  //   print_r($message);

                    if(array_key_exists('message', $message)) {
                        $link = '';
                        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#',
                            $message['message'], $matches);
                        if (isset($matches[0])) {
                            $link = $matches[0];
                        }


                        $data = [
                            'date'        => date('m/d/Y H:i:s', $message['date']),
                            'message'     => $message['message'],
                            'link'        => $link,
                            'views'       => $message['views'],
                            'forwards'    => $message['forwards'],
                            'post_author' => array_key_exists('post_author', $message) ? $message['post_author'] : null,
                            'title'       => ''
                        ];

                        $media = array_key_exists('media', $message) ? $message['media'] : null;

                        if ($media) {
                            try {
                                $MadelineProto->downloadToDir($media, public_path('images_list'));
                                $data['image'] = public_path('images_list').'/'.$media['photo']['id'].'.jpg';
                            } catch (\Exception $e) {

                            }

                            if(array_key_exists('webpage', $media)) {
                                $data['url'] = array_key_exists('url', $media['webpage']) ?
                                    $media['webpage']['url'] : null;
                                $data['title'] = array_key_exists('title', $media['webpage']) ?
                                    $media['webpage']['title'] : null;
                            }
                        }

                        if(!isset($data['url']) && isset($data['link'][0])) {
                            $data['url'] = $data['link'][0];
                        }

                        if(!isset($data['title']) && isset($data['message'])) {
                            $first = explode('.', $data['message']);
                            if($first) {
                                $data['title'] =  $first[0];
                            }
                        }

                        TelegramMessages::create([
                            'title'          => $data['title'],
                            'slug'           => $slug,
                            'company'        => $data['post_author'],
                            'logo'           => array_key_exists('image', $data) ? $data['image'] : null,
                            'content'        => preg_replace('/\x{1F680}/u',"<br>",
                                nl2br($data['message'], true)),
                            'apply_link'     => array_key_exists('url', $data) ? $data['url'] : '',
                        ]);

                        $messagesArray[] = $data;
                    }

                }

                $end =  end($messages_Messages['messages']);
                if(!$end) {
                    break;
                }
                $offset_id = $end['id'];
                $counter++;
                sleep(2);

            } while ($counter < 10);
        }
    }
}
