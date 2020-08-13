<?php

namespace App\Library\Services;
use App\CoindarSocials;
use App\Library\Services\Base\BaseService;

class CoindarSocialsService extends BaseService{

    public function get(){

        $url = config('coindar.coin_socials_url').'?access_token='.config('coindar.token');

        $request = "{$url}"; // create the request URL

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        curl_close($curl); // Close request

        CoindarSocials::truncate();

        foreach (json_decode($response) as  $data){
            CoindarSocials::create([
                "coin_id"         => isset($data->coin_id) ? (int)$data->coin_id : null,
                "website"         => isset($data->website) ? $data->website : null,
                "bitcointalk"     => isset($data->bitcointalk) ? $data->bitcointalk : null,
                "twitter"         => isset($data->twitter) ? $data->twitter : null,
                "reddit"          => isset($data->reddit) ? $data->reddit : null,
                "telegram"        => isset($data->telegram) ? $data->telegram : null,
                "facebook"        => isset($data->facebook) ? $data->facebook : null,
                "github"          => isset($data->github) ? $data->github : null,
                "explorer"        => isset($data->explorer) ? $data->explorer : null,
                "youtube"         => isset($data->youtube) ? $data->youtube : null,
                "twitter_count"   => isset($data->twitter_count) ? (int)$data->twitter_count : null,
                "reddit_count"    => isset($data->reddit_count) ? (int)$data->reddit_count : null,
                "telegram_count"  => isset($data->telegram_count) ? (int)$data->telegram_count : null,
                "facebook_count"  => isset($data->facebook_count) ? (int)$data->facebook_count : null,
            ]);
        }
    }

}