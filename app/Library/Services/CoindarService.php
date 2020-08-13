<?php

namespace App\Library\Services;

use App\CoindarEventsVersion2;
use App\CoindarVersion2;
use App\Library\Services\Base\BaseService;
use Carbon\Carbon;

class CoindarService extends  BaseService {

    public function get()
    {
       // $this->obtainCoindarCoins();
        $this->obtainCoindarEvents();
    }

    protected function obtainCoindarCoins()
    {
        $url = config('coindar.coins_url').'?access_token='.config('coindar.token');

        $request = "{$url}"; // create the request URL

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        print_r(json_decode($response)); // print json decoded response
        curl_close($curl); // Close request

        foreach (json_decode($response) as $data) {
            CoindarVersion2::create((array)$data);
        }
    }


    protected function obtainCoindarEvents()
    {
        $now = Carbon::now();
        $page=1;
        while (true) {
            $url = config('coindar.events_url').'?access_token='.config('coindar.token').'&page_size=100&page='.$page.
                '&filter_date_start='.$now->format('Y-m-d');

            $page++;

            $request = "{$url}"; // create the request URL

            $curl = curl_init(); // Get cURL resource
            // Set cURL options
            curl_setopt_array($curl, array(
                CURLOPT_URL => $request,            // set the request URL
                CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
            ));

            $response = curl_exec($curl); // Send the request, save the response
            print_r(json_decode($response)); // print json decoded response
            curl_close($curl); // Close request

            if(empty(json_decode($response))) {
                return;
            }

            CoindarEventsVersion2::truncate();

            foreach (json_decode($response) as $data) {
                try {
                CoindarEventsVersion2::create([
                    "caption" => $data->caption,
                    "source" => $data->source,
                    "source_reliable" => (boolean)$data->source_reliable,
                    "important" => (boolean)$data->important,
                    "date_public" => !empty($data->date_public) ? $data->date_public : null,
                    //  "date_start" => !empty($data->date_start) ? $data->date_start : null,
                    "date_end" => !empty($data->date_end) ? $data->date_end : null,
                    "coin_id" => !empty($data->coin_id) ? $data->coin_id : null,
                    "coin_price_changes" => !empty($data->coin_price_changes) ? $data->coin_price_changes : null,
                    "tags" => !empty($data->tags) ? $data->tags : null,
                ]);
                } catch (\Exception $e) {
                    continue;
                }


            }

        }


    }
}