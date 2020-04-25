<?php

namespace App\Library\Services;

use App\Coinmarketcap;
use App\Library\Services\Base\BaseService;


class CoinMarketService extends  BaseService {

    public function get(){

        $url = env('COIN_MARKET_CAP_URL');
        $parameters = [
            'start' => '1',
            'limit' => '5000',
            'convert' => 'USD'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: '.env('COIN_MARKET_KEY'),

        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        print_r(json_decode($response)); // print json decoded response
        curl_close($curl); // Close request

        Coinmarketcap::truncate();

        foreach (json_decode($response)->data as  $data){
            $data->native_id = $data->id;
            $data->rank = $data->cmc_rank;
            $data->{'24h_volume_usd'} = $data->quote->USD->volume_24h;
            $data->market_cap_usd = $data->quote->USD->market_cap;
            $data->price_usd = $data->quote->USD->price;
            $data->percent_change_1h = $data->quote->USD->percent_change_1h;
            $data->percent_change_24h = $data->quote->USD->percent_change_24h;
            $data->percent_change_7d = $data->quote->USD->percent_change_7d;
            Coinmarketcap::create((array)$data);
        }

    }
}
