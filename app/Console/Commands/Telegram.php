<?php

namespace App\Console\Commands;

use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\TelegramMessages;
use Illuminate\Support\Facades\Log;

class Telegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get messages from telegram channel';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $MadelineProto = new \danog\MadelineProto\API('bot.madeline');
       // $MadelineProto->botLogin(config('telegram.api_id'), config('telegram.api_hash'));

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

        TelegramMessages::truncate();
        Log::channel('crabler')->info('Telegram messages');

        $channels = config('telegram.channels');
        $counter = 0;
        foreach ($channels as $channel) {
            $messagesArray = [];
            if (!$me['bot']) {

                $offset_id = 0;
                $limit = 100;

                do {
                    $messages_Messages = $MadelineProto->messages->getHistory([
                        'peer'        => $channel['name'],
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
                       // print_r($message);

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
                                'slug'           => $channel['slug'],
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

        return 0;
    }
}